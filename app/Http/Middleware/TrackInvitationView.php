<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackInvitationView
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        if ($slug) {
            $invitation = Invitation::where('slug', $slug)->where('is_active', 1)->first();

            if ($invitation) {
                $sessionKey = 'viewed_invitation_' . $invitation->id;
                $today = now()->format('Y-m-d');

                if (session($sessionKey) !== $today) {
                    $invitation->increment('view_count');
                    session([$sessionKey => $today]);
                }
            }
        }

        return $next($request);
    }
}
