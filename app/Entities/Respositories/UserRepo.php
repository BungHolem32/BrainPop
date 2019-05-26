<?php

namespace App\Entities\Repositories;


use App\Entities\Models\User;

class UserRepo extends Repository
{
    const MODEL = User::class;

    /**
     * @param $data
     *
     * @return bool
     */
    public function store($data)
    {
        $data  = $this->prepareData($data);
        $model = $this->model()->create($data);

        return $model;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function prepareData($data)
    {
        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    /**
     * @param $role_id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByRoleId($role_id)
    {
        return $this->query()->where('role_id', $role_id)->get();
    }

    /**
     * @param int $role_id
     * @param     $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByRoleIdAndId($role_id, $user_id)
    {
        return $this->query()
            ->where('role_id', $role_id)
            ->where('id', $user_id)
            ->get()
            ->first();
    }

    /**
     * @param $ids
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByIds($ids)
    {
        return $this->query()
            ->whereIn('id', $ids)
            ->get();
    }

}
