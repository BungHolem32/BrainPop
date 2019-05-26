<?php

namespace App\Http\Controllers;

use App\Entities\Repositories\UserMetadataRepo;
use App\Entities\Repositories\UserRepo;

/**
 * @property UserRepo         model_repo
 * @property UserMetadataRepo metadata_model_repo
 */
class TeacherController extends UserController
{
    /**
     * @var int $role_id related to roles table
     */
    protected $role_id = 2;

    /**
     * @var array validation fields
     */
    protected $fields = ['username', 'password', 'full_name', 'metadata'];
}
