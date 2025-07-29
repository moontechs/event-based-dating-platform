<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationCodeEmail;
use App\Models\MagicLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MagicLinkController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function sendMagicLink(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');

        $key = 'magic-link-'.$request->ip().'-'.$email;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'email' => "Please wait {$seconds} seconds before requesting another login.",
            ])->withInput();
        }

        RateLimiter::hit($key, 5 * 60);

        $magicLink = MagicLink::createForEmail($email);

        SendVerificationCodeEmail::dispatch($email, $magicLink->token);

        return redirect()->route('verify.form', ['email' => $email]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator);
        }

        $email = $request->input('email');
        $token = $request->input('token');

        $magicLink = MagicLink::findValidToken($email, $token);

        if (! $magicLink) {
            return redirect()->route('login')->withErrors([
                'token' => 'Invalid or expired verification.',
            ]);
        }

        $magicLink->markAsUsed();

        return app(LoginController::class)->loginWithEmail($email);
    }

    public function showVerificationForm(Request $request): View|RedirectResponse
    {
        $email = $request->query('email');

        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('login');
        }

        return view('auth.verify', compact('email'));
    }
}
