<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingCategory extends Model
{

    protected $table = 'listing_category';

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_id', 'category_id'
    ];

    public function listing() {
        return $this->hasOne(Listing::class, 'id', 'listing_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
