<?php

namespace App\Entities\Repositories;


use App\Entities\Models\Period;

/**
 * Class PeriodsRepo
 *
 * @package App\Entities\Repositories
 */
class PeriodsRepo extends Repository
{
    /**
     *
     */
    const MODEL = Period::class;

    /**
     * @param $period
     *
     * @return mixed
     */
    function getStudents($period)
    {
        $model = $this->find($period);

        return $model->students;
    }

    /**
     * @param $model_id
     * @param $student_id
     *
     * @return
     */
    public function attachStudent($model_id, $student_id)
    {
        $model = $this->find($model_id);
        $model->students()->attach($student_id);

        return $model->students->contains($student_id);
    }


    /**
     * @param $model_id
     * @param $student_id
     *
     * @return bool
     */
    public function detachStudent($model_id, $student_id)
    {
        $model = $this->find($model_id);
        $model->students()->detach($student_id);

        return !$model->students->contains($student_id);
    }

    /**
     * @param $teacher_id
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByTeacherIdAndId($teacher_id, $id)
    {
        return $this->query()
            ->where('id', $id)
            ->where('teacher_id', $teacher_id)
            ->get();
    }

    /**
     * @param $teacher_id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTeacherPeriods($teacher_id)
    {
        return $this->query()->where('teacher_id', $teacher_id)->get();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getByTeacherId($id)
    {
        return $this->query()->where('teacher_id', $id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getUsersByPeriodId($id)
    {
        $model = $this->find($id);

        return $model->users()->whereStudent()->get();
    }
}

