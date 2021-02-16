<?php

namespace Modules\Media\Features;

use Auth;
use Upload;

use App\Model as Eloquent;
use App\Traits\Objectable;

class Media extends Eloquent
{
    use Objectable;

    protected $connection = 'mongodb';
    protected $collection = 'sys.media';

    const STATUS_DELETED  = -2;
    const STATUS_DRAFT    = -1;
    const STATUS_PRIVATE  = 0;
    const STATUS_PUBLIC   = 1;
    
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    const DELETED_AT = 'deleted';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id',      // Media object id
        'uid',      // Media owner id
        'type',     // Media type {product, cover, avatar, timeline}
        'name',     // Media file name
        'path',     // Media relation path
        'url',      // Media absolute url
        'ext',      // Media file extension
        'vendor',   // Media vendor: object id {user, product, review, comment}
        'caption',  // Media caption
        'size',     // Media file size
        'width',    // Media width
        'height',   // Media height
        'status',   // Integer
        'created',  // Created at timestamp
        'updated',  // Updated at timestamp
    ];

    /**
     * The model's default values for embeddeds.
     *
     * @var array
     */
    protected $embeddeds = [
        '_id',      // Uuid
        'url',      // Media absolute url
        'path',     // Media relation path
        'width',    // Media width
        'height',   // Media height
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Create new media for product
     */
    public static function fromProduct($pid, $photo)
    {
        $media = self::fromFillable([
            'uid' => Auth::user()->id,
            'type' =>'product',
            'vendor' => $pid,
            'status' => static::STATUS_PRIVATE,
            'created' => now(),
            'updated' => now(),
        ]);

        $media->fill($photo);
        $media->save();

        return $media;
    }

    /**
     * Get cover link
     * @example $user->avatar->src
     * @return string
     */
    public function getSrcAttribute()
    {
        return isset($this->path) ? MediaGenerator::url($this->path) : '';
    }

    /**
     * Get media original link
     * @example $user->avatar->link
     * @return string
     */
    public function getLinkAttribute()
    {
        return isset($this->path) ? MediaGenerator::url($this->path) : '';
    }

    /**
     * Get image link
     * @example $user->avatar->image
     * @return string
     */
    public function getImageAttribute()
    {
        return isset($this->path) ? MediaGenerator::url($this->path) : '';
    }

    /**
     * Get thumb link
     * @example $user->avatar->thumb
     * @return string
     */
    public function getThumbAttribute()
    {
        return isset($this->path) ? MediaGenerator::url($this->path, ['type' => 'thumb']) : '';
    }

    /**
     * Get cover link
     * @example $user->cover->cover
     * @return string
     */
    public function getCoverAttribute()
    {
        return isset($this->path) ? MediaGenerator::url($this->path, ['type' => 'cover']) : '';
    }

    /**
     * Get cache image link
     * @example $user->avatar->cache
     * @return string
     */
    public function getCacheAttribute()
    {
        return isset($this->path) ? MediaGenerator::url($this->path, ['type' => 'small']) : '';
    }
}