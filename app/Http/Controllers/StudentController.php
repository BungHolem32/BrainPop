<?php

namespace App\Http\Controllers;

use App\Entities\Repositories\UserRepo;

/**
 * @property UserRepo model_repo
 */
class StudentController extends UserController
{
    /**
     * @var int $role_id related to roles table
     */
    protected $role_id = 3;

    /**
     * @var array validation fields
     */
    protected $fields = ['username', 'password', 'full_name', 'metadata'];
}
