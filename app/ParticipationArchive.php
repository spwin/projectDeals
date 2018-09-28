<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipationArchive extends Model
{

    protected $table = 'participation_archive';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_id', 'user_id', 'winner', 'rotation_id'
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
}
