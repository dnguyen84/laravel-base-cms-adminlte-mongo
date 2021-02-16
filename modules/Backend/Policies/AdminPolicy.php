<?php

namespace Modules\Backend\Policies;

use App\Policy;

class AdminPolicy extends Policy
{
    protected $prefix = 'backend';
    
    public function publish($user)
    {
        return $user->hasPerm("{$this->prefix}.publish");
    }

    public function draft($user)
    {
        return $user->hasPerm("{$this->prefix}.draft");
    }
}
