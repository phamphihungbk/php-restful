<?php

namespace TinnyApi\Resources;

use Illuminate\Http\Request;

class UserCollection extends UserResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => UserResource::collection($this->collection),
        ];
    }
}
