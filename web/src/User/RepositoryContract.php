<?php

namespace TinnyApi\User;

interface RepositoryContract
{
    public function getAll(): array;
    public function update(array $request);
    public function delete();
}
