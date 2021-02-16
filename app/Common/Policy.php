<?php

namespace App\Common;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    protected $prefix = '';

    public function view($user)
    {
        return $user->hasPerm("{$this->prefix}.view");
    }

    public function create($user)
    {
        return $user->hasPerm("{$this->prefix}.create");
    }

    public function update($user)
    {
        return $user->hasPerm("{$this->prefix}.update");
    }

    public function delete($user)
    {
        return $user->hasPerm("{$this->prefix}.delete");
    }
}
