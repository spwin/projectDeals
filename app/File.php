<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Exception\NotWritableException;

class File extends Model
{
    protected $uploads = 'uploads';
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'folder', 'filename', 'path', 'mime', 'size'
    ];

    public function saveFile($folder, $file){
        $folder_prefix = date('Y', time()).'/'.date('m', time()).'/';
        $path = $file->store($folder_prefix.$folder, 'public');

        $parameters = [
            'name' => $file->getClientOriginalName(),
            'folder' => $folder,
            'filename' => basename($path),
            'path' => $path,
            'mime' => $file->getMimeType(),
            'size' => $file->getSize()
        ];

        return $this->fill($parameters)->save();
    }

    public function deleteFile(){
        $path = '/'.trim($this->uploads, '/').'/'.$this->getAttribute('path');
        if(file_exists(public_path($path))){
            unlink(public_path($path));
        }

        $delete = $this;
        try {
            $delete = $this->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $delete;
    }

    public function original(){
        $path = '/'.trim($this->uploads, '/').'/'.$this->getAttribute('path');
        if(file_exists(public_path($path))){
            return $path;
        }
        return null;
    }

    public function displayImage($size, $type = 'resize', $use_empty = true){
        $path = 'uploads/'.$this->getAttribute('path');

        if($type !== 'resize') $type = 'fit';
        $full_path = '/thumbs/'.$size.'/'.$this->getAttribute('path');

        if(!$path) {
            return $this->displayEmptyImage($path, $size, $use_empty);
        } elseif(file_exists(public_path($full_path))) {
            return str_replace(' ', '%20', $full_path);
        } elseif(file_exists(public_path($path))) {
            $path_parts = explode('/', $full_path);
            $filename = array_pop($path_parts);
            $directory = public_path(implode('/', $path_parts));

            // Return original file if svg
            // - START -
            $contentType = mime_content_type(public_path($path));
            if($contentType == 'image/svg+xml'){
                return $path;
            }
            // - END -

            $dimensions = explode('x', $size);
            $width = $dimensions[0];
            $height = null;

            if(count($dimensions) > 1){
                $height = $dimensions[1];
            }

            try {
                $this->increaseLimits(['memory_limit' => '1024M']);
                $cached_image =  Image::make(public_path($path))->$type($width, $height, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                }
                $cached_image->save(public_path($full_path), 90);
                return str_replace(' ', '%20', $full_path);
            } catch (NotReadableException $e) {
                return $this->displayEmptyImage($path, $size, $use_empty);
            } catch (NotWritableException $e) {
                return $this->displayEmptyImage($path, $size, $use_empty);
            }
        } else {
            return $this->displayEmptyImage($path, $size, $use_empty);
        }
    }

    private function increaseLimits($limits){
        foreach($limits as $limit => $value) {
            ini_set($limit, $value);
        }
        //ini_set('memory_limit', '256M');
        //ini_set('upload_max_filesize', '40M');
        //ini_set('post_max_size', '40M');
    }

    private function displayEmptyImage($path, $size, $use_empty){
        if (strpos($path, 'http://') !== false || strpos($path, 'https://') !== false) {
            return $path;
        } else {
            return $use_empty ? $this->generateImage($size) : $this->generate1x1PNG();
        }
    }

    private function generate1x1PNG(){
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
    }

    private function generateImage($image_size = '800x600'){
        return "http://via.placeholder.com/".$image_size;
    }
}
