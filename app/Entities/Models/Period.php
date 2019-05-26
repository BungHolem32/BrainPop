<?php

namespace App\Entities\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Period
 *
 * @package App\Entities\Models
 */
class Period extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name','teacher_id'];

    /**
     * @var array
     */
    protected $visible = ['id', 'teacher_id', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function users()
    {
        return $this->belongsToMany(User::class, 'users_periods', 'period_id', 'user_id');
    }
}
