<?php

namespace TinnyApi\Models;

use Database\Factories\UserModelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as UserBaseModel;

class UserModel extends UserBaseModel
{
    use HasFactory;

    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $casts = [
        'id'        => 'string',
        'is_active' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'facebook',
        'twitter',
        'email_verified_at',
    ];

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserModelFactory::new();
    }
}
