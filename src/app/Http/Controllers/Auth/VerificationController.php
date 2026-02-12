<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard'))
            : view('auth.verify-email');
    }

    /**
     * Handle the email verification request.
     */
    public function verify(EmailVerificationRequest $request)
    {
        // Check if already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Seu email já foi verificado anteriormente.');
        }

        // Mark email as verified
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Log verification for security audit
        Log::info('Email verified successfully', [
            'user_id' => $request->user()->id,
            'email' => $request->user()->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view('auth.verification-success');
    }

    /**
     * Handle verification errors (expired or invalid tokens).
     */
    public function error(Request $request)
    {
        Log::warning('Email verification failed - invalid or expired token', [
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view('auth.verification-error');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        // Check if already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        // Send new verification email
        try {
            $request->user()->sendEmailVerificationNotification();

            Log::info('Verification email resent successfully', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return back()->with('status', 'verification-link-sent');
        } catch (\Exception $e) {
            Log::error('Failed to resend verification email', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->with('error', 'Erro ao enviar email. Por favor, tente novamente.');
        }
    }
}
