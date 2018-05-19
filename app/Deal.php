<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id', 'company_id', 'name', 'slug', 'description', 'price', 'rating', 'status', 'reward',
        'seo', 'location', 'meta_data'
    ];

    protected $casts = [
        'seo' => 'collection',
        'location' => 'collection',
        'meta_data' => 'collection'
    ];

    public function company(){
        return $this->hasOne(Company::class, 'id','company_id');
    }

    public function image(){
        return $this->hasOne(File::class, 'id', 'image_id');
    }

    public function getImage($size = null){
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
