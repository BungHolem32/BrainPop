<?php

namespace App\Entities\Repositories;


use App\Entities\Models\UserMetadata;

class UserMetadataRepo extends Repository
{
    const MODEL = UserMetadata::class;

    /**
     * @param $user
     * @param $fields
     */
    public function storeMetadata($user, $fields)
    {
        if (empty($fields['metadata'])) {
            return;
        }

        $data    = $this->prepare($fields, $user);
        $model   = $this->model();
        $results = $model->insert($data);

        return $results;
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
}
