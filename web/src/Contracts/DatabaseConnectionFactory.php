<?php

namespace TinnyApi\Contracts;

use Illuminate\Database\Connection;

interface DatabaseConnectionFactory
{
    public function create(): Connection;
}
