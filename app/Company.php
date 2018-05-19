<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed image
 */
class Company extends Model
{
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'description', 'image_id', 'user_id'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function image(){
        return $this->hasOne(File::class, 'id', 'image_id');
    }

    public function logo($size = null){
        if($image = $this->image) {
            if ($size) {
                return $image->displayImage($size, 'resize', false);
            } else {
                return $image->original();
            }
        } else {
            return '';
        }
    }
}
