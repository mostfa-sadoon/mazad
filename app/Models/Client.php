<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPUnit\Framework\MockObject\Verifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $guard = 'client';

    protected $table = 'clients';
    protected $guarded = [];

    protected $hidden = ['password'];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Get Photo Path
    public function  getPhotoAttribute($photo)
    {
        if ($photo != null) {
            return asset('assets/images/clients/' . $photo);
        } else {
            return '';
        }
    } // End of Get Photo Path



    ///////////////// Relations \\\\\\\\\\\\\\\\\

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    
    public function favourits(){
        return $this->hasMany(Favourite::class , 'client_id', 'id');
    }
}
