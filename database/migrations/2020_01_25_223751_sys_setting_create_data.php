<?php

use App\Setting;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Run this migration command
 * @example php artisan migrate --path=/database/migrations/2020_01_25_223751_sys_setting_create_data.php
 */
class SysSettingCreateData extends Migration
{
    /**
     * Initialize migration collection
     *
     * @return void
     */
    public function __construct()
    {
        $this->collection = (new Setting)->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::collection($this->collection, function (Blueprint $collection) {
            foreach($this->sample() as $item) {
                if (Setting::find($item['_id']) == false) {
                    $model = Setting::fromFillable($item);
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
            foreach($this->sample() as $item) {
                if ($node = Setting::find($item['_id'])) {
                    $node->forceDelete();
                }
            }
        });
    }

    public function sample()
    {
        return [
            [
                '_id' => 'adsense.types',
                'name' => 'AdSense Types',
                'format' => 'json',
                'value' => [
                    'image' => 'Image',
                    'video' => 'Video',
                    'iframe' => 'Iframe'
                ],
                'status' => 1,
            ],
            [
                '_id' => 'banner.types',
                'name' => 'Banner Types',
                'format' => 'json',
                'value' => [
                    'home' => 'Home',
                    'product' => 'Product',
                    'category' => 'Category'
                ],
                'status' => 1,
            ],
            [
                '_id' => 'campaign.positions',
                'name' => 'Campaign Positions',
                'format' => 'json',
                'value' => [
                    'home-1' => 'Home 1',
                    'home-2' => 'Home 2',
                    'home-3' => 'Home 3',
                    'home-4' => 'Home 4'
                ],
                'status' => 1,
            ],
            [
                '_id' => 'category.types',
                'name' => 'Category Types',
                'format' => 'json',
                'value' => [
                    'blog',
                    'page',
                    'store',
                ],
                'status' => 1,
            ],
            [
                '_id' => 'content.types',
                'name' => 'Content Types',
                'format' => 'json',
                'value' => [
                    'blog',
                    'page'
                ],
                'status' => 1,
            ],
        ];
    }
}
