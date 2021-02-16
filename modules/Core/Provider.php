<?php

namespace Modules\Core;

use App\Common\Policy;
use App\Common\Controller;
use App\Common\DataTable;
use App\Common\ServiceProvider;

use Modules\Core\Helpers\Parser;
use Modules\Core\Helpers\Sidebar;
use Cedu\Mongodb\Eloquent\SoftDeletes;

class Provider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        # Register sidebar helper
        $this->alias('Sidebar',                 Sidebar::class);
        $this->alias('App\Sidebar',             Sidebar::class);
        $this->alias('App\Parser',              Parser::class);

        # Register core classes
        $this->alias('App\Policy',              Policy::class);
        $this->alias('App\Controller',          Controller::class);
        $this->alias('App\DataTable',           DataTable::class);
        $this->alias('App\ServiceProvider',     ServiceProvider::class);
        $this->alias('App\Traits\SoftDeletes',  SoftDeletes::class);

        # Register core helper
        require_once('Helpers/Function.php');
        require_once('Helpers/Collection.php');
    }
}
