<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('hoost.login.form');
        }

        $routeName = Route::currentRouteName();

        // Routes universelles accessibles à tout utilisateur connecté
        $allowedCommonRoutes = [
            'hoost.home',
            'hoost.profile.index',
            'hoost.profile.update',
            'hoost.profile.update-photo',
            'hoost.user.settings',
            'hoost.user.security.update',
            'hoost.logout',
            'hoost.preferences.questionnaire',
            'hoost.preferences.store',
            'hoost.preferences.edit',
            'hoost.preferences.update',
            'hoost.recommendations',
            'hoost.notifications.index',
            'hoost.notifications.read',
            'hoost.notifications.readAll',
            'hoost.notifications.edit',
            'hoost.notifications.update',
        ];

        if ($routeName && in_array($routeName, $allowedCommonRoutes)) {
            return $next($request);
        }

        if ($routeName && method_exists($user, 'permissions')) {
            if (!$user->permissions($routeName)) {
                abort(403, 'Accès non autorisé. Vous ne disposez pas des permissions requises pour accéder à cette page.');
            }
        }

        return $next($request);
    }
}
