<?php

namespace TinnyApi\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Database\Factories\UserModelFactory;

class UserModel extends BaseModel
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $primaryKey = 'email';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return UserModelFactory
     */
    protected static function newFactory(): UserModelFactory
    {
        return UserModelFactory::new();
    }
}
