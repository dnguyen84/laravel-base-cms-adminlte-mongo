<?php

namespace App\Traits;

use App\Media;

/**
 * Add method to get thumb image
 * @example $obj->coverLink
 * @example $obj->coverImage
 * @example $obj->coverThumb
 * @example $obj->coverCache
 */
trait Coverable
{
    /**
     * Add embedded media cover object
     * @example $user->cover->thumb
     * @example $user->cover->link
     */
    public function cover()
    {
        return $this->embedsOne('App\Media');
    }

    /**
     * Process media cover embeds data
     * @example $model->processCoverEmbeds();
     */
    public function processCoverEmbeds()
    {
        if (isset($this->attributes['cover']) && is_string($this->attributes['cover'])) {
            $this->cover = Media::firstOrNew(['_id' => $this->attributes['cover'] ?? ''], [])->getEmbedded2();
        }
    }
}