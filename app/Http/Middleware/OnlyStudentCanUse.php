<?php

namespace App\Http\Middleware;

use Closure;

class OnlyStudentCanUse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!in_array($user->role->name, ['student', 'admin'])) {
            return response()->json([
                'status_code' => 403,
                'message'     => 'Only student permitted to use this methods',
            ]);
        }

        if ($user->id != ($request->route()->parameters)['student_id'] && $user->role->id != 1) {
            return response()->json([
                'status'  => 403,
                'message' => 'only self adding is available',
            ]);
        }

        return $next($request);
    }
}
