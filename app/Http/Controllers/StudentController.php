<?php

namespace App\Http\Controllers\Api;

use App\Entities\Repositories\UserRepo;
use App\Http\Controllers\UserController;

/**
 * @property UserRepo model_repo
 */
class StudentController extends UserController
{
    protected $role_id = 3;

    public function getStudentsByPeriod(){

    }
}
