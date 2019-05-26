<?php

namespace App\Http\Requests;


class AuthRequest extends CustomRequest
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

        switch ($method_name) {
            case 'register':
                return $this->getRegisterFields();
            case 'login':
                return $this->getLoginFields();
            case 'logout':
                return $this->getLogoutFields();
        }

    }

    /**
     * @return array
     */
    private function getRegisterFields()
    {
        $fields = [
            'full_name' => 'required|string',
            'username'  => 'required|string|unique:users',
            'password'  => 'required|string|min:6|max:12',
            'role_id'   => 'required|exists:roles,id',
            'metadata'  => 'array'
        ];

        $role_id = request()->get('role_id') ?? null;

        if ($role_id == 2) {
            $fields['metadata.email'] = 'required|email';
        }

        if ($role_id == 3) {
            $fields['metadata.grade'] = 'required|integer|between:0,12';
        }

        return $fields;
    }

    /**
     * @return array
     */
    private function getLoginFields()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }

    private function getLogoutFields()
    {
        return [
            'token' => 'required'
        ];
    }
}
