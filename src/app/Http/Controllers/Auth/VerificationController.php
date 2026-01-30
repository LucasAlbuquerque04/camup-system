<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

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
        $request->fulfill();

        Log::info('Email verified for user: ' . $request->user()->id, [
            'ip' => $request->ip(),
            'email' => $request->user()->email
        ]);

        return redirect()->route('dashboard')->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        Log::info('Verification email resent for user: ' . $request->user()->id, [
            'ip' => $request->ip()
        ]);

        return back()->with('status', 'verification-link-sent');
    }
}
