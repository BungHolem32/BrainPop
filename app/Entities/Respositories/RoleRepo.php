<?php
/**
 * Created by PhpStorm.
 * User: ilanvac
 * Date: 5/24/2019
 * Time: 11:43 AM
 */

namespace App\Entities\Repositories;


use App\Entities\Models\Role;

class RoleRepo extends Repository
{
    const MODEL = Role::class;

    public function getTeacher()
    {
        $query = $this->query();

        return $query->where('name', 'teacher')->pluck('id')->first();

    }

    public function isTeacher($role_id)
    {
        $model = $this->find($role_id);

        return $model->name == 'teacher';
    }
}
