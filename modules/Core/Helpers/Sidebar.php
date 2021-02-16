<?php

namespace Modules\Core\Helpers;

use Auth;
use Illuminate\Support\Arr;

class Sidebar
{
    protected $stores = [];

    /**
     * Create a new sidebar instance.
     */
    public function __construct(array $stores = [])
    {
        $this->stores = $stores;
    }

    /**
     * Get store data
     * @example $sidebar->get('backend.system')
     */
    public function get($path = null)
    {
        if ($path) {
            return Arr::get($this->stores, $path);
        } else {
            return $this->stores;
        }
    }

    /**
     * Load current user menu item
     * @example app()->sidebar->load();
     */
    public function load()
    {
        // Get current user
        $user = Auth::user();

        // Check current user
        if (empty($user)) {
            return $this->stores['backend'] ?? [];
        }

        // Check current user publisher
        if ($user->has('publisher')) {
            return $this->stores['publisher'] ?? $this->stores['backend'] ?? [];
        }

        // Check current user bookcase
        if ($user->has('bookcase')) {
            return $this->stores['bookcase'] ?? $this->stores['backend'] ?? [];
        }

        // Return default
        return $this->stores['backend'] ?? [];
    }
}