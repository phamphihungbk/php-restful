<?php

namespace TinnyApi\User\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class UserModel extends BaseModel
{
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
}
