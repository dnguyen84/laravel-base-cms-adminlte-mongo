<?php

namespace App\Traits;

use App\Media;

/**
 * Add method to get avatar link
 * @example $obj->avatarImage
 * @example $obj->avatarLink
 * @example $obj->avatarCache
 * @example $obj->avatarThumb
 */
trait Avatarable
{
    /**
     * Add embedded media avatar object
     * @example $user->avatar->thumb
     * @example $user->avatar->link
     */
    public function avatar()
    {
        return $this->embedsOne('App\Media');
    }

    /**
     * Process media avatar embeds data
     * - Update model: empty object
     * - Update entity: string
     * - Exists not empty object
     * @example $model->processAvatarEmbeds();
     */
    public function processAvatarEmbeds()
    {
        if (isset($this->attributes['avatar']) && is_string($this->attributes['avatar'])) {
            $this->avatar = Media::firstOrNew(['_id' => $this->attributes['avatar']], [])->getEmbedded2();
        }
    }
}