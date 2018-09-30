<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed image
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'role', 'email', 'password', 'image_id', 'confirmed', 'google2fa_secret', 'google2fa_ts'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    /**
     * Ecrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function company(){
        $company = null;
        if($this->getAttribute('role') == 'manager'){
            $company = $this->belongsTo(Company::class, 'user_id');
        }
        return $company;
    }

    public function image(){
        return $this->hasOne(File::class, 'id', 'image_id');
    }

    public function reviews(){
        return $this->belongsToMany(Deal::class, 'deal_reviews')->withPivot('review', 'rating');
    }

    public function participating(){
        return $this->belongsToMany(Listing::class, 'participation')->withPivot('winner');
    }

    public function coupons($unused = true){
        return $this->hasMany(Coupon::class, 'coupon_id', 'id')->where(['used' => !$unused]);
    }

    public function avatar($size = null){
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
