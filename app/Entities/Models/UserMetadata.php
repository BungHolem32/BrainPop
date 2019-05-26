<?php

namespace App\Entities\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMeta
 *
 * @package App\Entities\Models
 */
class UserMetadata extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['role_id', 'user_id', 'key', 'value'];

    /**
     * @var string
     */
    protected $table = 'user_metadata';
}
