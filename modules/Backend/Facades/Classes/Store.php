<?php

namespace Modules\Backend\Facades\Classes;

use Illuminate\Support\Arr;

class Store
{
	protected $stores = [];

    /**
     * Create a new gate instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @param  callable  $userResolver
     * @param  array  $abilities
     * @param  array  $policies
     * @param  array  $beforeCallbacks
     * @param  array  $afterCallbacks
     * @param  callable|null  $guessPolicyNamesUsingCallback
     * @return void
     */
    public function __construct(array $stores = [])
    {
        $this->stores = $stores;
    }

    /**
     * Load store data from a file
     * @example Sidebar::load(__DIR__ . '/Menu', 'sidebar')
     */
    public function load($path, $namespace = null)
	{
        $bucket = include($path);

        if ($namespace) {
            $bucket = $bucket[$namespace] ?? [];
        }

        if ($bucket) {
            $this->append($bucket);
        }

        return $this;
    }

    /**
     * Push new item to store
     * @example Sidebar::push($item)
     * @example Sidebar::push($item, 'manager.0')
     * @example Sidebar::push($item, 'manager.1')
     */
	public function push($items, $path = null)
	{
        if ($path) {
            // Check for {path}
            Arr::set($this->stores, $path, $items);
        } else {
            // Append item to {store}
            $this->stores[] = $items;
        }

		return $this;
    }
    
    /**
     * Push new item to store
     */
	public function add($items)
	{
		return $this->append($items);
	}

    /**
     * Append new data to store
     */
    public function append(array $items)
	{
        $this->stores = array_merge_recursive($this->stores, $items);
    }
    
    /**
     * Reset store
     */
	public function reset()
	{
        $this->stores = [];
        return $this;
	}

    /**
     * Get store data
     */
	public function get()
	{
		return $this->stores;
    }
    
    /**
     * Get store all data
     */
    public function all()
	{
		return $this->stores;
	}
}