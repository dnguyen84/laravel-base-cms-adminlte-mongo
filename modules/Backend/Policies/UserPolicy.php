<?php

namespace Modules\Backend\Policies;

use App\User;
use App\Policy;

class UserPolicy extends Policy
{
    protected $prefix = 'user';

    /**
     * Create a new instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->user = request()->user ?? new User();
    }

    /**
     * Determine whether the user can view other user.
     *
     * @param  \App\User  $user     current user 
     * @param  \App\Post  $member   target user 
     * @return mixed
     */
    public function view($user, $target = null)
    {
        // Get target user from route
        $target = $target ?? $this->user;
        return $user->hasPerm("{$this->prefix}.view") || $user->id == $target->id;
    }

    public function update($user, $target = null)
    {
        // Get target user from route
        $target = $target ?? $this->user;
        return $user->hasPerm("{$this->prefix}.update") || $user->id == $target->id;
    }

    public function password($user, $target = null)
    {
        // Get target user from route
        $target = $target ?? $this->user;
        return $user->hasPerm("{$this->prefix}.password") || $user->id == $target->id;
    }
}
