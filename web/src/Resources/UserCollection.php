<?php

namespace TinnyApi\Resources;

class UserCollection extends UserResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => UserResource::collection($this->collection),
        ];
    }
}
