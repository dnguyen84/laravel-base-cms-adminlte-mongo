<?php

namespace App\Common;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Class alias loader instance
     */
    protected $loader = null;

    /**
     * Create a new controller instance.
     * 
     * @todo Set component {view} folder here
     * @return void
     */
    public function __construct($app)
    {
        /**
         * Initialize service provider
         */
        parent::__construct($app);

        /**
         * Create alias loader
         */
        $this->loader = AliasLoader::getInstance();
    }

    /**
     * Create a class alias for service
     * 
     * @example $this->alias('User', User::class)
     */
    public function alias(string $name, string $alias)
    {
        return $this->loader->alias($name, $alias);
    }
}
