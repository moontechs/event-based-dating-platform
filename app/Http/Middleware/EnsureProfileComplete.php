<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (! $this->isProfileComplete($user)) {
            return redirect()->route('profile.edit');
        }

        return $next($request);
    }

    private function isProfileComplete(User $user): bool
    {
        return $user->hasCompletedProfile();
    }
}
