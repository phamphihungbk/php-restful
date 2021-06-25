<?php

namespace TinnyApi\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class EmailWasVerifiedEvent
{
    use SerializesModels;

    /**
     * @var Model
     */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param Model $user
     */
    public function __construct(Model $user)
    {
        $this->user = $user;
    }
}
