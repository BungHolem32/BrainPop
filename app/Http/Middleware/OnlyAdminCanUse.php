<?php

namespace App\Http\Middleware;

use Closure;

class OnlyAdminCanUse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user->role->name != 'admin') {
            return response()->json([
                'status'=> 403,
                'message' => 'Only admin permitted to use this method',
            ]);
        }

        return $next($request);
    }
}
