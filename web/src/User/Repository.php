<?php

namespace TinnyApi\User;

use TinnyApi\User\Model\UserModel;
use TinnyApi\User\Resource\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Repository implements RepositoryContract
{
    public function getAll(): ResourceCollection
    {
        $users = UserModel::all();
        return UserResource::collection($users);
    }

    public function update(array $request)
    {

    }

    public function delete()
    {

    }
}
