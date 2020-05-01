<?php

namespace App\Policies;

use App\Read;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can emails any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can emails the model.
     *
     * @param  \App\User  $user
     * @param  \App\Read  $read
     * @return mixed
     */
    public function view(User $user, Read $read)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Read  $read
     * @return mixed
     */
    public function update(User $user, Read $read)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Read  $read
     * @return mixed
     */
    public function delete(User $user, Read $read)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Read  $read
     * @return mixed
     */
    public function restore(User $user, Read $read)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Read  $read
     * @return mixed
     */
    public function forceDelete(User $user, Read $read)
    {
        //
    }
}
