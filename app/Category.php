<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'icon', 'order', 'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'collection'
    ];

    public function listings(){
        return $this->belongsToMany(Listing::class, 'listing_category');
    }
}
