<?php

namespace Modules\Media\Features;

use Log;
use File;
use Auth;
use Image;
use Storage;
use Response;
use Hashids;

use App\Guid;
use App\Media;
use App\Upload;
use App\Controller;
use Illuminate\Http\Request;

/**
 * Handle user requests
 * @package Modules\Store
 */
class MediaController extends Controller
{
    public function index(Request $request)
    {
        return 'OK';
    }

    public function update(Request $request)
    {
        // Validate media metadata
        $this->validate($request, [
            'id' => 'required|string|max:32',
            'caption' => 'required|string|max:255',
        ]);

        $id     = $request->input('id');
        $text   = $request->input('caption');

        $media  = Media::where(['_id' => $id])->update(['caption' => $text]);

        return $media;
    }

    public function delete(Request $request)
    {
        // Validate media metadata
        $this->validate($request, [
            'id' => 'required|string|max:32',
        ]);
        
        $media = $request->input('id');
        $media = Media::where(['_id' => $media])->first();
        $media->forceDelete();

        if ($media) {
            Storage::disk('media')->delete($media->path);
        }

        return $media;
    }

    /**
     * Get list media has uploaded for listing dialog
     */
    public function uploaded(Request $request)
    {
        $query = Media::query();

        // Check for special user images
        if ($user = $request->input('uid')) {
            $query->where('uid', $user);
        }

        // Check for current user private images
        if ($user = $request->input('private')) {
            $query->where('uid', Auth::user()->id);
        }

        // Check for image type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Check for vendor images
        if ($vendor = $request->input('vendor')) {
            $query->where('vendor', $vendor);
        }

        $files = $query->get();

        // Build response
        $uploads = [];

        foreach($files as $item) {
            $uploads[] = [
                'id' => $item->_id,
                'name' => $item->name,
                'ext' => $item->ext,
                'width' => $item->width,
                'height' => $item->height,
                'caption' => $item->caption,
                'src' => $item->path,
                'link' => $item->link,
                'thumb' => $item->thumb
            ];
        }

        return [
            'uploads' => $uploads
        ];
    }

    /**
     * Upload media to server
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Validate media metadata
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        // Get media file content
        $file = $request->file('file');
        
        // Make image object
        $image = Image::make($file->getRealPath());
        
        $width  = $image->width();
        $height = $image->height();
        
        $resize = false;

        // Check image size limit
        if ($width > config('media.max.width')) {
            $width = config('media.max.width');
            $resize = true;
        }

        if ($height > config('media.max.height')) {
            $height = config('media.max.height');
            $resize = true;
        }

        if ($resize) {
            $image->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($file->getRealPath());
        }

        // Build media information
        $disk   = 'media';
        $name   = Hashids::encode(Guid::next()) . '.' . $file->extension();

        $folder = date('Ym');
        $folder = dechex($folder);

        if ($type = $request->input('type')) {
            $folder = "{$type}/{$folder}";
        }

        // Check store folder
        Storage::disk($disk)->makeDirectory($folder);
        
        $path = $file->storeAs($folder, $name, $disk);

        // Save media to database
        $media = Media::create([
            'uid' => Auth::user()->id,
            'type' => $type,
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'ext' => $file->extension(),
            'vendor' => $request->input('vendor', 'default'),
            'caption' => '',
            'size' => $file->getSize(),
            'width' => $width,
            'height' => $height,
            'status' => 1,
            'created' => now(),
            'updated' => now(),
        ]);

        // Build response data
        return [
            'id' => $media->id,
            'name' => $media->name,
            'ext' => $media->ext,
            'width' => $width,
            'heigh' => $height,
            'caption' => $media->caption,
            'src' => $path,
            'link' => Upload::image($path),
            'thumb' => Upload::thumb($folder . '/' . $name)
        ];
    }
}