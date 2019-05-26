<?php

namespace App\Http\Requests;


class PeriodRequest extends CustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method_name = substr(strstr(($this->route()->action)['as'], '.'), 1);

        switch ($method_name) {
            case 'show':
                return [
                    "period_id" => "required|integer|exists:periods,id"
                ];
            case 'store':
            case 'update':
                return [
                    'teacher_id' => 'required|string|exists:users,id',
                    'name'       => 'required|string'
                ];
            case 'destroy':
                return [
                    'period_id' => 'required|exists:periods,id'
                ];
            case 'store-teacher-period':
            case 'update-teacher-period':
                return [
                    'name' => 'required|string'
                ];
            case 'getStudents':
                return [
                    'period_id' => "required|integer|exists:periods,id"
                ];
            case 'attachStudent':
            case 'detachStudent':
                return [
                    'period_id' => 'required|integer|exists:periods,id',
                    'user_id'   => 'required|integer|exists:users,id'
                ];
        }
    }

}
