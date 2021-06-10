<?php

namespace TinnyApi\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    /**
     * The current class of resource to respond
     */
    protected $resourceItem;

    /**
     * The current class of collection resource to respond
     */
    protected $resourceCollection;

    protected function respondWithCustomData($data, $status = 200): JsonResponse
    {
        return new JsonResponse([
            'data' => $data,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], $status);
    }

    /**
     * @return int
     */
    protected function getTimestampInMilliseconds(): int
    {
        return intdiv((int)now()->format('Uu'), 1000);
    }

    /**
     * Return no content for delete requests
     *
     * @return JsonResponse
     */
    protected function respondWithNoContent(): JsonResponse
    {
        return new JsonResponse([
            'data' => null,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return single item response from the application
     *
     * @param Model $item
     * @return mixed
     */
    protected function respondWithItem(Model $item)
    {
        return (new $this->resourceItem($item))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }
}
