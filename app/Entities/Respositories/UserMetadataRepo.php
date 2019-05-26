<?php

namespace App\Entities\Repositories;


use App\Entities\Models\UserMetadata;

class UserMetadataRepo extends Repository
{
    const MODEL = UserMetadata::class;

    /**
     * @param $user
     * @param $fields
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection | bool
     */
    public function storeMetadata($user, $fields)
    {
        if (empty($fields['metadata'])) {
            return false;
        }

        $data   = $this->prepare($fields, $user);
        $model  = $this->model();
        $result = $model->insert($data);

        if ($result) {
            return $this->getMetaDataByUserId($user->id);
        }
    }

    public function updateMetadata($user, $fields)
    {
        $data  = $this->prepare($fields, $user);
        $model = $this->query()->where('user_id', $user->id)->first();

        $model->update($data[0]);

        return $model;
    }

    private function prepare($raw_data, $user)
    {
        $index = 0;
        $data  = [];
        foreach ($raw_data['metadata'] as $field => $value) {
            $data[$index]            = [];
            $data[$index]['user_id'] = $user->id;
            $data[$index]['role_id'] = $raw_data['role_id'];
            $data[$index]['key']     = $field;
            $data[$index]['value']   = $value;
            $index++;
        }

        return $data;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getMetaDataByUserId($id)
    {
        return $this->query()
            ->where('user_id', $id)
            ->get()
            ->last();
    }

    /**
     * @param $role_id
     *
     * @return mixed
     */
    public function getByRoleId($role_id)
    {
        return $this->query()->whereRoleId($role_id)->get();
    }


    /**
     * @param $user_id
     * @param $role_id
     *
     * @return mixed
     */
    public function getRoleIdAndId($user_id, $role_id)
    {
        return $this->query()->where('user_id', $user_id)->whereRoleId($role_id)->get()->first();
    }
}
