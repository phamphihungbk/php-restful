<?php

namespace TinnyApi\Repositories;

use Illuminate\Database\Eloquent\Model;
use TinnyApi\Contracts\BaseRepository;

abstract class EloquentAbstractRepository implements BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * EloquentRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function with(array $with = []): BaseRepository
    {
        // TODO: Implement with() method.
    }

    public function withoutGlobalScopes(): BaseRepository
    {
        // TODO: Implement withoutGlobalScopes() method.
    }

    public function findOneById(string $id): Model
    {
        // TODO: Implement findOneById() method.
    }

    public function findOneBy(array $criteria): Model
    {
        // TODO: Implement findOneBy() method.
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        // TODO: Implement update() method.
    }
}
