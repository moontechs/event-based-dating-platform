<?php

namespace App\Http\Middleware;

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
            return redirect()->route('profile.setup');
        }

        return $next($request);
    }

    private function isProfileComplete($user): bool
    {
        return ! empty($user->full_name) &&
               ! empty($user->whatsapp_number) &&
               ! empty($user->photo_path) &&
               ! empty($user->relationship_intent) &&
               $user->terms_accepted;
    }
}
