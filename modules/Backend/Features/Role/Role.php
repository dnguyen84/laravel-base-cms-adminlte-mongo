<?php

namespace Modules\Backend\Features\Role;

use App\Model;

use Illuminate\Support\Str;

class Role extends Model
{
   /* protected $connection = 'mongodb';*/
    protected $collection = 'sys.roles';
    
    const DELETED_AT = 'deleted';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id',
        'name',
        'about',
        'level',
        'perms',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * Build role data by mapping by field
     */
    public static function mapWith($field = '_id')
    {
        // Load all role from db
        $maps = [];
        $roles = static::all();

        // Build role data
        foreach($roles as $item) {
            $perms = [];
            foreach($item->perms as $perm) {
                $perms[$perm] = 1;
            }
            $maps[$item->{$field}] = $perms;
        }

        return $maps;
    }

    /**
     * Get role list permissions module
     * @example $role->groups
     * @return array
     */
    public function getGroupsAttribute()
    {
        $modules = [];
        $columns = [];

        foreach($this->perms as $item) {
            if (Str::contains($item, '.')) {
                list($module, $perm) = explode('.', $item);
                $modules[$module][$perm] = $perm;
                $columns[$perm] = $perm;
            }
        }

        ksort($modules);

        return [
            'modules' => $modules,
            'columns' => $columns,
        ];
    }

    /**
     * Get role list module
     * @example $role->modules
     * @return array
     */
    public function getModulesAttribute()
    {
        $modules = [];

        foreach($this->perms as $item) {
            if (Str::contains($item, '.')) {
                list($module, $perm) = explode('.', $item);
                $modules[$module][$perm] = $perm;
            }
        }

        ksort($modules);

        return $modules;
    }

    /**
     * Get role list unique permissions
     * @example $role->columns
     * @return array
     */
    public function getColumnsAttribute()
    {
        $columns = [];

        foreach($this->perms as $item) {
            if (Str::contains($item, '.')) {
                list($module, $perm) = explode('.', $item);
                $columns[$perm] = $perm;
            }
        }

        return $columns;
    }
}