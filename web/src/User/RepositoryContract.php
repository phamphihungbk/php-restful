<?php

namespace TinnyApi\User;

interface RepositoryContract
{
    public function getAll();
    public function update(array $request);
    public function delete();
}
