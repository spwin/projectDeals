<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed image
 */
class Rotation  extends Model
{

    protected $table = 'rotation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at', 'ended_at', 'data', 'active', 'previous'
    ];

    protected $casts = [
        'data' => 'collection'
    ];

    public function listings(){
        return $this->hasMany(Participation::class, 'rotation_id', 'id');
    }

    public function coupons(){
        return $this->hasMany(Coupon::class, 'rotation_id', 'id');
    }
}
