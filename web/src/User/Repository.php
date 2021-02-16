<?php

namespace TinnyApi\User;

use TinnyApi\User\Model\UserModel;
use TinnyApi\User\Resource\UserResource;

class Repository implements RepositoryContract
{
    /**
     * @return UserResource
     */
    public function getAll(): UserResource
    {
        return new UserResource(UserModel::all());
    }

    /**
     * @param string $email
     * @param array $request
     * @return mixed
     */
    public function update(string $email, array $request)
    {
        $user = UserModel::findOrFail($email);
        return $user->update($request);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function store(array $request)
    {
        return UserModel::create($request);
    }

    /**
     * @param string $email
     * @return UserResource
     */
    public function select(string $email): UserResource
    {
        return new UserResource(UserModel::findOrFail($email));
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function delete(string $email)
    {
        $user = UserModel::findOrFail($email);
        return $user->delete();
    }
}
