<?php

namespace TinnyApi\Repositories;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Cache\Repository as CacheRepository;
use Ramsey\Uuid\Uuid;
use TinnyApi\Contracts\BaseRepository;
use Illuminate\Contracts\Events\Dispatcher as Event;

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
    protected $cacheRepository;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Event
     */
    protected $event;

    /**
     * EloquentRepository constructor.
     *
     * @param Model $model
     * @param CacheRepository $cacheRepository
     * @param Guard $auth
     * @param Event $event
     */
    public function __construct(Model $model, CacheRepository $cacheRepository, Guard $auth, Event $event)
    {
        $this->model = $model;
        $this->cacheRepository = $cacheRepository;
        $this->auth = $auth;
        $this->event = $event;
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

        if (!empty($this->with) || $this->auth->check()) {
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
