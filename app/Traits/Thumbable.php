<?php

namespace App\Traits;

use App\Media;

/**
 * Add method to get avatar link
 * @example $obj->thumbImage
 * @example $obj->thumbLink
 * @example $obj->thumbCache
 */
trait Thumbable
{
    /**
     * Add embedded media thumb object
     * @example $product->thumb->thumb
     * @example $product->thumb->link
     */
    public function thumb()
    {
        return $this->embedsOne('App\Media');
    }

    /**
     * Process media thumb embeds data
     * @example $model->processThumbEmbeds();
     */
    public function processThumbEmbeds()
    {
        if (isset($this->attributes['thumb']) && is_string($this->attributes['thumb'])) {
            $this->thumb = Media::firstOrNew(['_id' => $this->attributes['thumb'] ?? ''], [])->getEmbedded2();
        }
    }
}