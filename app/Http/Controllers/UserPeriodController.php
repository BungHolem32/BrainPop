<?php

namespace App\Http\Controllers;


use App\Entities\Repositories\PeriodsRepo;
use App\Entities\Repositories\UserPeriodRepo;
use App\Entities\Repositories\UserRepo;
use App\Http\Traits\JsonResponseTrait;

/**
 * @property PeriodsRepo    period_repo
 * @property UserRepo       user_repo
 * @property UserPeriodRepo user_period_repo
 */
class UserPeriodController extends Controller
{
    use JsonResponseTrait;

    /**
     * UserPeriodController constructor.
     */
    public function __construct()
    {
        $this->period_repo      = new PeriodsRepo();
        $this->user_repo        = new UserRepo();
        $this->user_period_repo = new UserPeriodRepo();
        $this->assignUser();
    }

    /**
     * @param $period_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByPeriodId($period_id)
    {
        $json_response = $this->handleResponse([
            'status' => 'error',
            'method' => 'getUsersByPeriodId',
            'id'     => $period_id
        ], null);
        $users         = $this->period_repo->getUsersByPeriodId($period_id);

        if ($users->count()) {
            $json_response = $this->handleResponse([
                'status' => 'success',
                'method' => 'getUsersByPeriodId',
                'id'     => $period_id
            ], $users);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    public function getLinkedUsers()
    {
        $json_response = $this->handleResponse([
            'status' => 'error',
            'method' => 'getLinkedUsers',
        ], null);
        $linked_users  = $this->user_period_repo->getLinkedUsers();

        if ($linked_users->count()) {
            $json_response = $this->handleResponse([
                'status' => 'success',
                'method' => 'getLinkedUsers',
            ], $linked_users);
        }

        return response()->json($json_response, $json_response["status"]);
    }
}
