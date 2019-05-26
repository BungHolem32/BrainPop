<?php
/**
 * Created by PhpStorm.
 * User: ilanvac
 * Date: 5/26/2019
 * Time: 2:53 AM
 */

namespace App\Entities\Repositories;


use App\Entities\Models\UserPeriod;

class UserPeriodRepo extends Repository
{

    const MODEL = UserPeriod::class;

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLinkedUsers()
    {
        $user_ids = $this->model()
            ->all()
            ->pluck('user_id')
            ->unique()
            ->values()
            ->all();

        return (new UserRepo())->getByIds($user_ids);
    }
}
