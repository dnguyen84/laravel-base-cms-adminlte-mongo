<?php

namespace Modules\Customer;

use App\Common\ServiceProvider;

use Modules\Setting\Features\Setting;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class Provider extends ServiceProvider
{
    /**
     * This is module name
     *
     * @var string
     */
    protected $module = 'customer';

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
        $this->alias('Customer', Customer::class);
        $this->alias('App\Customer', Customer::class);
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
        $this->loadTranslationsFrom(__DIR__.'/Translations', $this->module);

        // Load module view
        $this->loadViewsFrom(__DIR__.'/Features/Views', $this->module);

        // Register setting widget
        Blade::directive('customer', function ($data) {
            return "<?php echo view('setting::widget', ['customer' => App\Customer::firstOrCreate($data)])->render(); ?>";
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Route::middleware(['web', 'can:backend.view'])
             ->namespace('Modules\Customer\Features')
             ->prefix(config('backend.route'))
             ->group(__DIR__.'/Routes.php');
    }

    /**
     * Define the policies for the module.
     *
     * @return void
     */
    public function loadPolicies()
    {
        Gate::resource('customer', Policy::class);
    }
}
