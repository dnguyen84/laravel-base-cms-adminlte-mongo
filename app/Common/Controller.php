<?php

namespace App\Common;

use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Current user data
     */
    protected $user = null;

    /**
     * Create a new controller instance.
     * 
     * @todo Set component {view} folder here
     * @return void
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Set controller theme folder
     * 
     * @example $this->theme(__DIR__ . '/users');
     * @example $this->theme(__DIR__ . '/users', 'users');
     * 
     * @param string $name The theme name
     * @return Controller
     */
    public function theme($path = null, $namespace = null)
    {
    	$path = $path ?? __DIR__;

    	if ($namespace === null) {
    		View::addLocation($path);
    	} else {
    		View::addNamespace($namespace, $path);
    	}

    	return $this;
    }

    /**
     * Get absolute path from relation path
     * @example $this->folder('profile')
     */
    public function folder($path)
    {
    	return __DIR__ . '/' . trim($path, '/');
    }

    public function authorized($prefix)
    {
        $options = [];
        
        $abilities = [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'ajax' => 'view',
            'search' => 'view',
            'datatable' => 'view',
            'publish' => 'update',
            'block' => 'update',
            'delete' => 'update',
            'active' => 'update',
            'verify' => 'update',
            'protect' => 'update',
        ];

        /**
         * Add middleware check current user authentication
         */
        $this->middleware('auth');

        /**
         * Add middeware check current can:user.create/update
         */
        foreach ($abilities as $method => $ability) {
            $this->middleware("can:{$prefix}.{$ability}", $options)->only($method);
        }
    }

}