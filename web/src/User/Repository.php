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
     */
    public function update(string $email, array $request): void
    {
        $user = UserModel::findOrFail($email);
        $user->update($request);
    }

    /**
     * @param array $request
     */
    public function store(array $request): void
    {
        UserModel::create($request);
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
     */
    public function delete(string $email): void
    {
        $user = UserModel::findOrFail($email);
        $user->delete();
    }
}
