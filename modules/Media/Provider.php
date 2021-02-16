<?php

namespace Modules\Media;

use App\Common\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

use Modules\Media\Features\Media;
use Modules\Media\Features\MediaGenerator;

class Provider extends ServiceProvider
{
    /**
     * This is module name
     * 
     * @var string
     */
    protected $module = 'media';

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Media\Features';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->alias('Upload', Facade::class);
        $this->alias('Media', Media::class);

        $this->alias('App\Upload',          Facade::class);
        $this->alias('App\Media',           Media::class);
        $this->alias('App\MediaGenerator',  MediaGenerator::class);
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

        // Load module views
        $this->loadViewsFrom(__DIR__ . '/Views', $this->module);

        // Load module languages
        $this->loadTranslationsFrom(__DIR__ . '/Translations', $this->module);

        Blade::directive('upload', function ($data) {
            return "<?php echo Upload::widget($data); ?>";
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
            ->namespace($this->namespace)
            ->group(__DIR__ . '/Routes.php');
    }

    /**
     * Define the policies for the module.
     *
     * @return void
     */
    public function loadPolicies()
    {
        Gate::resource('media', Policy::class);
    }
}
