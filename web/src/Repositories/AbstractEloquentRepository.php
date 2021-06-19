<?php

namespace TinnyApi\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Cache\Repository as CacheRepository;
use Ramsey\Uuid\Uuid;
use TinnyApi\Contracts\BaseRepository;

abstract class AbstractEloquentRepository implements BaseRepository
{
    /**
     * @var bool
     */
    protected $withoutGlobalScopes = false;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $with;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * EloquentRepository constructor.
     *
     * @param Model $model
     * @param CacheRepository $cacheRepository
     */
    public function __construct(Model $model, CacheRepository $cacheRepository)
    {
        $this->model = $model;
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function with(array $with = []): BaseRepository
    {
        $this->with = $with;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutGlobalScopes(): BaseRepository
    {
        $this->withoutGlobalScopes = true;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(string $id): Model
    {
        if (!Uuid::isValid($id)) {
            throw (new ModelNotFoundException())->setModel(get_class($this->model));
        }

        if (!empty($this->with) || auth()->check()) {
            return $this->findOneBy(['id' => $id]);
        }

        return $this->cacheRepository->remember($id, now()->addHour(), function () use ($id) {
            return $this->findOneBy(['id' => $id]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria): Model
    {
        if (!$this->withoutGlobalScopes) {
            return $this->model->with($this->with)
                ->where($criteria)
                ->orderByDesc('created_at')
                ->firstOrFail();
        }

        return $this->model->with($this->with)
            ->withoutGlobalScopes()
            ->where($criteria)
            ->orderByDesc('created_at')
            ->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Model $model, array $data): Model
    {
        return tap($model)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function findByFilters(): LengthAwarePaginator
    {
        return $this->model->with($this->with)->paginate();
    }
}
