<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;

/**
 * Example for migration with mongodb
 * 
 * @example php artisan migrate --path=/database/migrations/2020_01_25_223645_sys_users_create_index.php
 * 
 * @link(https://stackoverflow.com/a/50407173)
 * @link(https://github.com/jenssegers/laravel-mongodb/issues/1269)
 */
class SysUsersCreateIndex extends Migration
{
    protected $indexable = [
        'code',
        'email',
        'mobile',
        'roles',
        'groups',
        'search',
        'status',
        'deleted',
    ];

    /**
     * Initialize migration collection
     *
     * @return void
     */
    public function __construct()
    {
        $this->collection = (new User)->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::collection($this->collection, function (Blueprint $collection) {
            foreach($this->indexable as $field) {
                $collection->index($field);
            }

            $collection->index([
                'search' => 'text',
                'location.text' => 'text',
            ], 
            'searchable', null, 
            [
                "weights" => [
                    "search" => 32,
                    "location.text" => 12,
                ],
                'name' => 'searchable'
            ]);
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
            foreach($this->indexable as $field) {
                $collection->dropIndex([$field]);
            }

            $collection->dropIndex(['searchable']);
        });
    }
}
