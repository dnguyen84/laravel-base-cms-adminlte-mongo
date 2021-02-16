<?php

namespace Modules\Backend\Features\User;

use App\Media;
use App\Publisher;

use App\Traits\Coverable;
use App\Traits\Avatarable;
use App\Traits\Guidable;
use App\Traits\Castable;
use App\Traits\SoftDeletes;

use Illuminate\Support\Arr;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Arrayable;

use Cedu\Mongodb\Auth\User as Authenticatable; 

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    
    use UserEvent;

    use Avatarable;
    use Coverable;
    use Guidable;
    use Castable;

    /**
     * Override datetime field name
     */
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    const DELETED_AT = 'deleted';

    /**
     * Model mongo connection
     */
   // protected $connection = 'mongodb';
    protected $collection = 'sys.users';

    protected $rememberTokenName = 'remember';

    protected $permissions = [];

    /**
     * The attributes that are date format.
     *
     * @var array
     */
    protected $dates = [
        'birthday',
        'verified'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * We can use {code,name,mobile} to login
     *
     * @var array
     */
    protected $fillable = [
        '_id',
        'code',         // User unique code for student, ...
        'name',
        'email',
        'password',
        'avatar',
        'cover',
        'mobile',
        'roles',        // Array role [admin, student]
        'groups',       // Array object {id, kind, role}
        'accounts',     // Array object {id, kind, ...}
        'settings',     // Object save user setting data
        'profile',      // Object, user profile data {gender, birthday, about}
        'payment',      // Object payment
        'filters',      // Array object data for filters
        'locales',      // Object locale data
        'search',       // String searching text for mongodb
        'stats',        // User stats data { donationAmount, walletAmount }
        'status',
        'verified',
        'created',
        'updated'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember',
    ];

    /**
     * The attributes that should be cast to native types.
     * @link(https://laravel.com/docs/5.8/eloquent-mutators#attribute-casting)
     * @var array
     */
    protected $casts = [
        'status' => 'int',
        'deleted' => 'datetime',
        'verified' => 'datetime',
    ];

    /**
     * Check user has role with name
     * @example Auth::has('admin')
     * @example Auth::user()->has('admin')
     */
    public function has($role)
    {
        if (isset($this->roles) && is_array($this->roles) && in_array($role, $this->roles)) {
            return true;
        }
        return false;
    }

    /**
     * Check user has perm with name
     * @example Auth::hasPerm('backend.admin')
     * @example Auth::user()->hasPerm('backend.admin')
     */
    public function hasPerm($name)
    {
        return isset($this->perms[$name]);
    }

    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

    /**
     * Get current user embedded data
     * @example $order->customer = $user->getEmbedded()
     */
    public function getEmbedded()
    {
        $fillable = [
            'id',
            'name', 
            'avatar',
        ];

        $node = new User();
        $node->timestamps = false;
        
        foreach($fillable as $field) {
            $value = $this->{$field};
            if ($value instanceof Arrayable) {
                $node->{$field} = $value->toArray();
            } else {
                $node->{$field} = $value;
            }
        }

        return $node;
    }

    /**
     * Add embedded publisher object
     * @example $user->publisher->id
     * @example $user->publisher->avatar->thumb
     * @example $user->publisher->cover->thumb
     */
    public function getPublisherAttribute()
    {
        if ($publisherId = $this->groupFirstByKind('publisher', 'id')) {
            return Publisher::firstOrNew(['_id' => $publisherId], []);
        } else {
            throw new \Exception("The user [{$this->name}] do not belong publisher");
        }
    }

    /**
     * Convert group list to collection
     * @example $user->groupCollection -> collection
     */
    public function getGroupCollectionAttribute()
    {
        // Create collection and validate group data
        return collect($this->groups ?? [])->map(function($group) {
            return [
                'id'   => $group['id']   ?? null,
                'kind' => $group['kind'] ?? null,
                'role' => $group['role'] ?? null,
            ];
        });
    }

    /**
     * Check current user has group by id
     * @example $user->groupHasGuid('12345')
     */
    public function groupHasGuid($guid)
    {
        return $this->groupCollection->contains('id', $guid);
    }

    /**
     * Check current user has group by id
     * @example $user->groupHasGuidAndRole('12345', 'admin')
     */
    public function groupHasGuidAndRole($guid, $role)
    {
        return $this->groupFindByGuid($guid)->contains('role', $role);
    }

    /**
     * Check user has group kind
     * @example $user->groupHasKind('publisher')
     */
    public function groupHasKind($kind)
    {
        return $this->groupCollection->contains('kind', $kind);
    }

    /**
     * Check current user group list by id
     * @example $user->groupFindByGuid('12345') -> []
     */
    public function groupFindByGuid($guid)
    {
        return $this->groupCollection->filter(function($group) use ($guid) {
            return $guid == $group['id'];
        });
    }

    /**
     * Get first element by guid, can get by field
     * @example $user->groupFirstByGuid('12345')
     */
    public function groupFirstByGuid($guid, $field = null)
    {
        $first = $this->groupCollection->firstWhere('id', $guid);

        if ($field && $first) {
            $first = $first[$field] ?? null;
        }

        return $first;
    }

    /**
     * Check current user group list by kind
     * @example $user->groupFindByKind('publisher') -> []
     */
    public function groupFindByKind($kind)
    {
        return $this->groupCollection->filter(function($group) use ($kind) {
            return $kind == $group['kind'];
        });
    }

    /**
     * Get first element by kind, can get field
     * @example $user->groupFirstByKind('publisher') -> {}
     */
    public function groupFirstByKind($kind, $field = null)
    {
        $first = $this->groupCollection->firstWhere('kind', $kind);

        if ($field && $first) {
            $first = $first[$field] ?? null;
        }

        return $first;
    }

    /**
     * Get user primary role
     * @example $user->role
     * @return string
     */
    public function getRoleAttribute()
    {
        return reset($this->roles) ?? 'user';
    }

    /**
     * Add custom attribute to get user list permissions
     * @example $user->perms
     * @return array
     */
    public function getPermsAttribute()
    {
        if (empty($this->permissions) == false) {
            return $this->permissions;
        }

        // Resolve roles database
        $roles = resolve('roles');

        // Get current user roles and perms
        $list = Arr::only($roles, $this->roles);

        // Merge user roles to perms
        $this->permissions = [];

        foreach($list as $item) {
            $this->permissions = array_merge($this->permissions, $item);
        }

        ksort($this->permissions);

        return $this->permissions;
    }

    /**
     * Get current user address location
     * @example $user->address
     * @return string
     */
    public function getAddressAttribute()
    {
        return $this->location['text'] ?? 'N/A';
    }

    /**
     * Get node status name
     * @example $node->statusName -> created
     */
    public function getStatusNameAttribute()
    {
        return UserStatus::getName($this->status);
    }

    /**
     * Get node status color
     * @example $node->statusColor -> success
     */
    public function getStatusColorAttribute()
    {
        return UserStatus::getColor($this->status);
    }

    /**
     * Find list user in array id
     */
    public static function findIn($list)
    {
        return static::whereIn('_id', $list ?? [])->get();
    }

    public static function getCollection($bucket = null)
    {
        $collection = [
            /**
             * Publisher status
             */
            'publisher' => [
                '0' => 'Inactive',
                '1' => 'Active'
            ],

            /**
             * All user status
             */
            'status' => [
                '-1' => 'Blocked',
                '0' => 'Inactive',
                '1' => 'Active'
            ],

            'colors' => [
                '-2' => 'default',
                '-1' => 'danger',
                '0' => 'warning',
                '1' => 'success'
            ],

            'gender' => [
                'unknow' => 'Unknow',
                'male' => 'Male',
                'female' => 'Female',
            ],
        ];

        return $collection[$bucket] ?? $collection;
    }
}
