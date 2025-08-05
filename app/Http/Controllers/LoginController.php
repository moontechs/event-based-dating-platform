<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function loginWithEmail(string $email): RedirectResponse
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = $this->createNewUser($email);
        }

        Auth::login($user, true);

        if (! $this->isProfileComplete($user)) {
            return redirect()->route('profile.setup');
        }

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function createNewUser(string $email): User
    {
        $password = Str::random(40);

        return User::create([
            'name' => Str::random(10),
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
            'full_name' => null,
            'whatsapp_number' => null,
            'relationship_intent' => null,
            'status' => 'active',
            'status_reason' => null,
            'terms_accepted' => false,
        ]);
    }

    private function isProfileComplete(User $user): bool
    {
        return $user->hasCompletedProfile();
    }
}
