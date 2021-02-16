<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;
use App\Role;
use App\Perm;

/**
 * Run this migration command
 * @example php artisan migrate --path=/database/migrations/2019_07_17_175013_create_role_data.php
 */
class CreateRoleData extends Migration
{
    /**
     * Initialize migration collection
     *
     * @return void
     */
    public function __construct()
    {
        $this->collection = (new Role)->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::collection($this->collection, function (Blueprint $collection) {
            foreach($this->roles() as $item) {
                if (Role::find($item['_id']) == false) {
                    $model = Role::fromFillable($item);
                    $model->save();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::collection($this->collection, function (Blueprint $collection) {
            foreach($this->roles() as $item) {
                if ($role = Role::find($item['_id'])) {
                    $role->forceDelete();
                }
            }
        });
    }

    public function roles()
    {
        return [
            [
                '_id' => 'admin',
                'name' => 'Admin',
                'level' => '1',
                'about' => 'Admin has all permission',
                'perms' => Perm::all(),
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ],
            [
                '_id' => 'marketing',
                'name' => 'marketing',
                'level' => '2',
                'about' => 'marketing management',
                'perms' => [],
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ]
        ];
    }
}
