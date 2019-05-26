<?php

namespace App\Http\Middleware;

use App\Entities\Repositories\PeriodsRepo;
use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class OnlyTeacherCanUse extends BaseMiddleware
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
        $user   = auth()->user();
        $params = getQueryParam();

        if (!in_array($user->role->name, ['teacher', 'admin'])) {
            return response()->json([
                'status'  => 403,
                'message' => 'only teachers permitted to use these methods',
            ]);
        }

        if (!empty($params) && !empty($params['period_id']) ) {
            $period = (new PeriodsRepo())->find($params['period_id']);
            if ($user->id != $period->teacher_id && $user->role->id != 1) {
                return response()->json([
                    'status'  => 403,
                    'message' => 'Only self manipulation is available.',
                ]);
            }
        }
        if (!empty($params) && !empty($params['teacher_id'])) {
            if ($user->id != $params['teacher_id'] && $user->role->id != 1) {
                return response()->json([
                    'status'  => 403,
                    'message' => 'Only self manipulation is available.',
                ]);
            }
        }

        return $next($request);
    }
}
