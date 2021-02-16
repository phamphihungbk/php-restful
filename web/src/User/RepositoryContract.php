<?php

namespace TinnyApi\User;

use TinnyApi\User\Resource\UserResource;

interface RepositoryContract
{
    public function getAll(): UserResource;
    public function update(string $email, array $request);
    public function delete(string $email);
    public function select(string $email): UserResource;
    public function store(array $request);
}
