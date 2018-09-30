<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $table = 'coupons';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'used', 'used_at', 'valid_until', 'company_id', 'user_id',
        'deal_id', 'listing_id', 'rotation_id', 'created_at', 'updated_at'
    ];

    public function listing() {
        return $this->hasOne(Listing::class, 'id', 'listing_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function rotation(){
        return $this->hasOne(Rotation::class, 'id', 'rotation_id');
    }

    public function company(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function deal(){
        return $this->hasOne(Deal::class, 'id', 'deal_id');
    }
}
