<?php

namespace Modules\Filesystem;

use App\Common\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

use Modules\Filesystem\Features\Filesystem;

class Provider extends ServiceProvider
{
    /**
     * This is module name
     * 
     * @var string
     */
    protected $module = 'filesystem';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Register common models
         */
        $this->alias('App\Filesystem', Filesystem::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load module policies
        $this->loadPolicies();

        // Load module routes
        $this->loadRoutes();

        // Load module languages
        $this->loadTranslationsFrom(__DIR__ . '/Translations', $this->module);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Route::middleware(['web', 'admin', 'can:backend.view'])
            ->namespace('Modules\Filesystem\Features')
            ->prefix(config('backend.route'))
            ->group(__DIR__ . '/Routes.php');
    }

    /**
     * Define the policies for the module.
     *
     * @return void
     */
    public function loadPolicies()
    {

    }
}
