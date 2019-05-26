<?php

namespace App\Entities\Repositories;

/**
 * Class Repository
 *
 * @package App\Repositories
 */
abstract class Repository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->query()->get();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->query()->count();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->query()->find($id);
    }

    /**
     * first
     *
     * @return mixed
     */
    public function first()
    {
        return $this->query()->first();
    }


    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        $model = $this->model()->fill($data);
        $model->save();

        return $model;
    }
}
