<?php

namespace TinnyApi\Repositories;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\Models\UserModel;

class UserEloquentRepository extends AbstractEloquentRepository implements UserRepository
{
    /**
     * @var string
     */
    private $defaultSort = '-created_at';

    /**
     * @var array
     */
    private $defaultSelect = [
        'id',
        'email',
        'facebook',
        'twitter',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    private $allowedFilters = [
        'is_active',
    ];

    /**
     * @var array
     */
    private $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    /**
     * @var array
     */
    private $allowedIncludes = [
    ];

    /**
     * {@inheritdoc}
     */
    public function update(Model $model, array $data): Model
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);

            event(new PasswordReset(auth()->user()));
        }

        return parent::update($model, $data);
    }

    public function findByFilters(): LengthAwarePaginator
    {
        $perPage = (int)request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        return QueryBuilder::for(UserModel::class)
            ->select($this->defaultSelect)
            ->allowedFilters($this->allowedFilters)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }
}
