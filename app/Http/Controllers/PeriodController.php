<?php

namespace App\Http\Controllers;

use App\Entities\Models\Period;
use App\Entities\Repositories\PeriodsRepo;
use App\Http\Requests\PeriodRequest;
use App\Http\Traits\JsonResponseTrait;

/**
 * @property PeriodsRepo model_repo
 */
class PeriodController extends Controller
{
    use JsonResponseTrait;

    /**
     * PeriodController constructor.
     */
    public function __construct()
    {
        $this->model_repo = new PeriodsRepo();
        $this->assignUser();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $periods       = $this->model_repo->getAll();
        $json_response = $this->handleResponse(['status' => 'error', 'method' => 'index'], null);

        if (count($periods)) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'index'], $periods);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * Display the specified resource.
     *
     * @param PeriodRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PeriodRequest $request)
    {
        $period_id     = ($request->route()->parameters())['period_id'];
        $period        = $this->model_repo->find($period_id);
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'show', $period_id], null);

        if ($period && $period->exists) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'show', "id" => $period->id],
                $period);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PeriodRequest $request
     * @param               $id
     *
     * @return Period
     */
    public function update(PeriodRequest $request, $id)
    {
        $updated          = false;
        $json_response    = $this->handleResponse(["status" => 'error', "method" => 'update', "id" => $id],
            null);
        $fields_to_update = $request->all();

        $period = $this->model_repo->find($id);

        if ($period->exists) {
            $updated = $period->update($fields_to_update);
        }

        if ($updated) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'update', "id" => $period->id],
                $period);
        }

        return response()->json($json_response, $json_response["status"]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PeriodRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodRequest $request)
    {
        $json_response  = $this->handleResponse(["status" => 'error', "method" => 'store'], null);
        $fields_to_save = $request->all();
        $period         = $this->model_repo->store($fields_to_save);

        if ($period) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'store', "id" => $period->id],
                $period);
        }

        return response()->json($json_response, $json_response["status"]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param PeriodRequest $request
     *
     * @return string
     */
    public function destroy(PeriodRequest $request)
    {
        $deleted       = false;
        $period_id     = ($request->route()->parameters())['period_id'];
        $period        = $this->model_repo->find($period_id);
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'destroy', "id" => $period_id], null);

        if ($period) {
            $deleted = $period->delete();
        }

        if ($deleted) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'destroy', "id" => $period->id],
                $period);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * @param PeriodRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachStudent(PeriodRequest $request)
    {
        $params        = $request->route()->parameters;
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'attachStudent'], null);
        $user_attached = $this->model_repo->attachStudent($params['period_id'], $params['user_id']);

        if ($user_attached) {
            $json_response = $this->handleResponse([
                "status" => 'success',
                "method" => 'attachStudent',
                "id"     => $params['user_id']
            ], null);
        }

        return response()->json($json_response, $json_response['status']);

    }

    /**
     * @param PeriodRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachStudent(PeriodRequest $request)
    {
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'detachStudent'], null);
        $params        = $request->route()->parameters;
        $user_detached = $this->model_repo->detachStudent($params['period_id'], $params['user_id']);

        if ($user_detached) {
            $json_response = $this->handleResponse([
                "status" => 'success',
                "method" => 'detachStudent',
                "id"     => $params['user_id']
            ], null);
        }

        return response()->json($json_response, $json_response['status']);
    }

    public function getTeacherPeriods($teacher_id)
    {
        $json_response = $this->handleResponse(['status' => 'error', 'method' => 'index'], null);
        $periods       = $this->model_repo->getTeacherPeriods($teacher_id);

        if (count($periods)) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'index'], $periods);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * @param $teacher_id
     * @param $period_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeacherPeriod($teacher_id, $period_id)
    {
        $json_response = $this->handleResponse(['status' => 'error', 'method' => 'show'], null);
        $periods       = $this->model_repo->getByTeacherIdAndId($teacher_id, $period_id);

        if (count($periods)) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'show'], $periods);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * @param PeriodRequest $request
     * @param               $teacher_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTeacherPeriod(PeriodRequest $request, $teacher_id)
    {
        $json_response                = $this->handleResponse(["status" => 'error', "method" => 'store'], null);
        $fields_to_save               = $request->all();
        $fields_to_save['teacher_id'] = $teacher_id;
        $period                       = $this->model_repo->store($fields_to_save);

        if ($period) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'store', "id" => $period->id],
                $period);
        }

        return response()->json($json_response, $json_response["status"]);
    }
}
