<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_verification_email_and_redirects_to_notice(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Lucas',
            'email' => 'lucas@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $user = User::where('email', 'lucas@example.com')->first();

        $this->assertNotNull($user);
        $this->assertAuthenticatedAs($user);
        $this->assertNull($user->email_verified_at);

        Notification::assertSentTo($user, VerifyEmail::class);

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_unverified_user_is_redirected_from_dashboard_to_verification_notice(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_signed_verification_link_marks_email_as_verified_and_redirects_to_dashboard(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', 'Email verificado com sucesso!');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_expired_verification_link_redirects_to_error_page_with_clear_message(): void
    {
        $user = User::factory()->unverified()->create();

        $expiredUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinute(),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($expiredUrl);

        $response->assertRedirect(route('verification.error'));

        $this->followRedirects($response)
            ->assertOk()
            ->assertSeeText('Link expirado ou inválido. Solicite um novo email de verificação.');
    }

    public function test_resend_verification_email_is_throttled_to_one_request_per_minute(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $firstResponse = $this->actingAs($user)->post(route('verification.resend'));
        $firstResponse->assertRedirect();
        $firstResponse->assertSessionHas('status', 'verification-link-sent');

        Notification::assertSentToTimes($user, VerifyEmail::class, 1);

        $secondResponse = $this->actingAs($user)->post(route('verification.resend'));
        $secondResponse->assertStatus(429);
    }

    public function test_profile_page_shows_email_verification_status(): void
    {
        $unverifiedUser = User::factory()->unverified()->create();

        $this->actingAs($unverifiedUser)
            ->get(route('profile.show'))
            ->assertOk()
            ->assertSeeText('Email não verificado')
            ->assertSeeText('Reenviar email de verificação');

        $verifiedUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($verifiedUser)
            ->get(route('profile.show'))
            ->assertOk()
            ->assertSeeText('Email verificado em:');
    }
}
