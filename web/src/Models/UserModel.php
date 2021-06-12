<?php

namespace TinnyApi\Models;

use Database\Factories\UserModelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string[]
     */
    protected $casts = [
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
        'id',
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
