<?php

namespace App\Http\Controllers;

use App\Entities\Repositories\UserMetadataRepo;
use App\Entities\Repositories\UserRepo;
use App\Http\Requests\UserRequest;
use App\Http\Traits\JsonResponseTrait;

/**
 * @property UserRepo         model_repo
 * @property UserMetadataRepo metadata_model_repo
 */
class TeacherController extends UserController
{
    use JsonResponseTrait;

    /**
     * @var int
     */
    protected $role_id = 2;

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPeriods(UserRequest $request)
    {
        $teacher_id    = ($request->route()->parameters)['teacher_id'];
        $json_response = $this->handleResponse([
            "status" => 'error',
            "method" => "getPeriodsByTeacherId",
            "id"     => $teacher_id
        ], null);
//        $periods       = $this->model_repo->($teacher_id);

//        if ($periods) {
//            $json_response = $this->handleResponse([
//                "status" => 'success',
//                "method" => 'getPeriodsByTeacherId',
//                "id"     => $teacher_id
//            ],
//                $periods);
//        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function getStudents(UserRequest $request)
    {
        $params        = $request->route()->parameters;
        $json_response = $this->handleResponse([
            "status" => 'error',
            "method" => "getStudents",
            "id"     => $params['teacher_id']
        ], null);

        $students = $this->model_repo->getStudentsByTeacherId($params['teacher_id'], $params['period_id']);

        if ($students) {
            $json_response = $this->handleResponse([
                "status" => 'success',
                "method" => 'getPeriodsByTeacherId',
                "id"     => $params['teacher_id']
            ],
                $students);
        }

        return response()->json($json_response, $json_response["status"]);
    }
}
