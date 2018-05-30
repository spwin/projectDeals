<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{

    protected $table = 'listings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deal_id', 'weeks', 'coupons_count', 'starts_at', 'ends_at', 'valid', 'views',
        'status', 'reward', 'meta_data', 'slider_image', 'slider_image_id', 'menu_image',
        'menu_image_id', 'best_deals', 'category_featured', 'follow_link', 'newsletter'
    ];

    protected $casts = [
        'meta_data' => 'collection'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class, 'listing_category');
    }

    public function deal(){
        return $this->hasOne(Deal::class, 'id','deal_id');
    }

    public function sliderImage(){
        return $this->hasOne(File::class, 'id', 'slider_image_id');
    }

    public function menuImage(){
        return $this->hasOne(File::class, 'id', 'menu_image_id');
    }

    public function getSliderImage($size = null){
        if($image = $this->sliderImage) {
            if ($size) {
                return $image->displayImage($size, 'resize', false);
            } else {
                return $image->original();
            }
        } else {
            return '';
        }
    }

    public function getMenuImage($size = null){
        if($image = $this->menuImage) {
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
