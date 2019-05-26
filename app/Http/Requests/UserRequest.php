<?php

namespace App\Http\Requests;


/**
 * Class UserRequest
 *
 * @package App\Http\Requests
 */
class UserRequest extends CustomRequest
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
        $method_name = getClassMethodName();
        $role_id     = getControllerRoleId();

        switch ($method_name) {
            case 'show':
            case 'destroy':
                return $this->getShowNDestroyParams($role_id);

            case 'store':
            case 'update':
                return $this->getStoreNUpdateParams($role_id);

            case 'getPeriods':
                return $this->getGetPeriodsParams();

            case 'getStudents':
                return $this->getGetStudentsParams();
        }
    }

    /**
     * @param $role_id
     *
     * @return array
     */
    private function getStoreNUpdateParams($role_id)
    {
        $params = [
            'username'  => 'required|string|unique:users',
            'password'  => 'required',
            'full_name' => 'required|string',
            'metadata'  => 'array',
        ];
        if ($role_id == 2) {
            $params['metadata.email'] = 'required|email';

            return $params;
        }

        $params['metadata.grade'] = 'required|integer|grade|between:0,12';

        return $params;

    }

    /**
     * @param $role_id
     *
     * @return array
     */
    private function getShowNDestroyParams($role_id)
    {
        if ($role_id == 2) {
            return [
                "teacher_id" => "required|integer|exists:users,id"
            ];
        }
        return [
            "student_id" => "required|integer|exists:students,id"
        ];
    }

    /**
     * @return array
     */
    private function getGetPeriodsParams()
    {
        return [
            "teacher_id" => "required|integer|exists:users,id"
        ];
    }

    /**
     * @return array
     */
    private function getGetStudentsParams()
    {
        return [
            'teacher_id' => 'required|integer|exists:users,id',
            'period_id'  => 'required|integer|exists:periods,id',
        ];
    }
}
