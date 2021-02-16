<?php

namespace Modules\Backend;

use App\Sidebar as SidebarNavigation;
use App\Common\ServiceProvider;

use Modules\Backend\Facades\Nav;
use Modules\Backend\Facades\Path;
use Modules\Backend\Facades\Sidebar;

use Modules\Backend\Policies\AdminPolicy;
use Modules\Backend\Policies\PermPolicy;
use Modules\Backend\Policies\RolePolicy;
use Modules\Backend\Policies\SettingPolicy;
use Modules\Backend\Policies\UserPolicy;

use Modules\Backend\Features\Perm\Perm;
use Modules\Backend\Features\Role\Role;
use Modules\Backend\Features\User\User;
use Modules\Backend\Features\User\UserStatus;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

class Provider extends ServiceProvider
{
    /**
     * This is module name
     * 
     * @var string
     */
    protected $module = 'backend';

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
        $this->alias('User',        User::class);
        $this->alias('Perm',        Perm::class);
        $this->alias('Role',        Role::class);

        $this->alias('App\Perm',    Perm::class);
        $this->alias('App\Role',    Role::class);
        $this->alias('App\User',    User::class);
        $this->alias('App\UserStatus', UserStatus::class);

        /**
         * Register facades alias
         */
        $this->alias('Nav',         Nav::class);
        $this->alias('Path',        Path::class);
        $this->alias('Sidebar',     Sidebar::class);
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

        // Load module directives
        $this->loadDirectives();

        // Load module views
        $this->loadViewsFrom(__DIR__ . '/Views', $this->module);

        // Load module languages
        $this->loadTranslationsFrom(__DIR__ . '/Translations', $this->module);

        // Register roles data service
        $this->app->singleton('roles', function($app) {
            return Role::mapWith();
        });

        // Register sidebar menu data
        $this->app->singleton('sidebar', function($app) {
            return new SidebarNavigation(config('menu'));
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Route::middleware('web')
            ->namespace('Modules\Backend\Features')
            ->group(__DIR__ . '/Routes.php');
    }

    /**
     * Define the directives for the application.
     *
     * @return void
     */
    public function loadDirectives()
    {
        // Check current user has role name, e.g: @role('supplier')
        Blade::directive('role', function ($name) {
            return "<?php if (Auth::user()->has($name)) : ?>";
        });

        // Close directive
        Blade::directive('end', function () {
            return "<?php endif; ?>";
        });

        // Check config exists
        Blade::directive('config', function ($key, $value = null) {
            if ($value) {
                return "<?php if (config($key) == $value) : ?>";
            } else {
                return "<?php if (config($key)) : ?>";
            }
        });

        // Check env exists
        Blade::directive('env', function ($key, $value = null) {
            if ($value) {
                return "<?php if (env($key) == $value) : ?>";
            } else {
                return "<?php if (env($key)) : ?>";
            }
        });

        // Rendering alert block
        Blade::directive('alert', function ($args = []) {
            $expression = '"backend::directives.alert"';
            return "<?php echo \$__env->make({$expression}, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });

        // Rendering alert with notification block
        //  @alertNotice
        Blade::directive('alertjs', function ($args = []) {
            $expression = '"backend::directives.alertjs"';
            return "<?php echo \$__env->make({$expression}, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });
    }

    /**
     * Define the policies for the module.
     *
     * @return void
     */
    public function loadPolicies()
    {
        # Manager resource
        Gate::resource('user',          UserPolicy::class);
        Gate::resource('role',          RolePolicy::class);
        Gate::resource('perm',          PermPolicy::class);
        Gate::resource('backend',       AdminPolicy::class);

        # Customize role
        Gate::define('user.password',   UserPolicy::class . '@password');
    }
}
