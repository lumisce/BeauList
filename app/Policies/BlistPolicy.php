<?php

namespace App\Policies;

use App\User;
use App\Blist;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlistPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any blists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the blist.
     *
     * @param  \App\User  $user
     * @param  \App\Blist  $blist
     * @return mixed
     */
    public function view(User $user, Blist $blist)
    {
        //
    }

    /**
     * Determine whether the user can create blists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the blist.
     *
     * @param  \App\User  $user
     * @param  \App\Blist  $blist
     * @return mixed
     */
    public function update(User $user, Blist $blist)
    {
        return $user->id === $blist->user->id;
    }

    /**
     * Determine whether the user can delete the blist.
     *
     * @param  \App\User  $user
     * @param  \App\Blist  $blist
     * @return mixed
     */
    public function delete(User $user, Blist $blist)
    {
        //
    }

    /**
     * Determine whether the user can restore the blist.
     *
     * @param  \App\User  $user
     * @param  \App\Blist  $blist
     * @return mixed
     */
    public function restore(User $user, Blist $blist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blist.
     *
     * @param  \App\User  $user
     * @param  \App\Blist  $blist
     * @return mixed
     */
    public function forceDelete(User $user, Blist $blist)
    {
        //
    }
}
