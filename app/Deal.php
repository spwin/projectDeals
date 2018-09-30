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
        'image_id', 'company_id', 'name', 'slug', 'description', 'price', 'rating', 'status',
        'seo', 'location', 'meta_data', 'link', 'terms_and_conditions', 'map_id', 'maps_link'
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

    public function map(){
        return $this->hasOne(File::class, 'id', 'map_id');
    }

    public function gallery(){
        return $this->belongsToMany(File::class, 'deal_gallery')->withPivot('order');
    }

    public function listings(){
        return $this->hasMany(Listing::class, 'deal_id', 'id');
    }

    public function reviews(){
        return $this->belongsToMany(User::class, 'deal_reviews')->withPivot('review', 'rating', 'date');
    }

    public function coupons(){
        return $this->hasMany(Coupon::class, 'deal_id', 'id');
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
