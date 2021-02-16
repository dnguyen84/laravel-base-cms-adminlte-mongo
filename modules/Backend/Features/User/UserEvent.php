<?php

namespace Modules\Backend\Features\User;

use App\Media;
use App\Location;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait UserEvent
{
    /**
     * Clean text data
     */
    public static function clean($input)
    {
        if ($input !== null) {
            $input = strip_tags(trim($input));
        }
        return $input ?? '';
    }

    /**
     * Boot the model event
     *
     * @return void
     */
    public static function bootUserEvent() {
        static::saving(function ($model) {

            $model->code = static::clean($model->code);
            $model->name = static::clean($model->name);
            $model->email = static::clean($model->email);
            $model->mobile = static::clean($model->mobile);

            /**
             * Add user metadata
             */
            if ($model->created == null) {
                $model->created = now();
            }

            if ($model->status === null) {
                $model->status = static::STATUS_INACTIVE;
            }

            $model->updated = now();

            $model->processAvatarEmbeds();
            $model->processCoverEmbeds();
            $model->processSearch();

            /**
             * Cast model value before save
             */
            $casts = [
                'avatar' => 'array',
                'cover' => 'array',
                'roles' => 'array',
                'groups' => 'array',
                'accounts' => 'array',
                'settings' => 'array',
                'profile' => 'array',
                'location' => 'object',
                'payment' => 'array',
                'filters' => 'array',
                'locales' => 'array',
                'stats' => 'object',
            ];

            foreach($casts as $key => $format) {
                $model->attributes[$key] = $model->attributes[$key] ?? [];
            }

            /**
             * Check to save dependency data object
             */
            $model->cast();
        });
    }

    /**
     * Process search
     */
    protected function processSearch()
    {
        $bucket = [];

        $bucket[] = Str::slug($this->name, ' ');

        //$location = (array) $this->attributes['location'] ?? [];

        // Add location full address to search
       /* if ($location && isset($location['text']) && $location['text']) {
            $bucket[] = Str::slug($location['text'], ' ');
        }*/

        $bucket[] = $this->email;
        $bucket[] = $this->mobile;

        if ($bucket) {
            $this->search = implode(', ', $bucket);
        }
    }
}