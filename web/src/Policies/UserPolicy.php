<?php

namespace TinnyApi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use TinnyApi\Models\UserModel as User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can view a list of model.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
//        return $user->can('view any users');
        return true;
    }

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
//        return $user->can('view users') || $user->id === $model->id;
        return true;
    }

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
//        return $user->can('create users');
        return true;
    }

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
//        return $user->can('update users') || $user->id === $model->id;
        return true;
    }

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
//        return $user->can('delete users');
        return true;
    }

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
//        return $user->can('restore users');
        return true;
    }

    /**
     * @todo will replace it later when having role feature
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
//        return $user->can('force delete users');
        return true;
    }
}
