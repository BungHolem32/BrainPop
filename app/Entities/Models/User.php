<?php

namespace App\Entities\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @package App
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {

        return [
            'role_id' => auth()->user()->role_id ?? ''
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMeta()
    {
        return $this->hasMany(UserMetadata::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function periods()
    {
        return $this->belongsToMany(Period::class, 'users_periods', 'user_id', 'period_id');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function ScopeWhereStudent($query)
    {
        $student_id = $this->role()
            ->where('name', 'student')
            ->pluck('id')
            ->first();

        return $query->where('role_id', $student_id);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function ScopeWhereTeacher($query)
    {
        return $query->where('role_id', 2);
    }

    /**
     * @param $query
     * @param $role_id
     *
     * @return mixed
     */
    public function ScopeWhereRoleId($query, $role_id)
    {
        return $query->where('role_id', $role_id);
    }
}
