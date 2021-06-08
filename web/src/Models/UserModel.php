<?php

namespace TinnyApi\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
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
     * @var string[]
     */
    protected $casts = [
        'id'        => 'string',
        'is_active' => 'boolean',
    ];

    /**
     * @var string
     */
    protected $connection = 'mysql';

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
