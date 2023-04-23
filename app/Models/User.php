<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes, HasRoles;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phoneCountry(){
        return $this->belongsTo(Country::class,'country_code','iso_code');
    }

    public function getAvatarUrlAttribute(){
        if($this->avatar=='default_user_avatar.png'){
            return asset('front/assets/images/icons-user-avatar.png');
        }
        return url('uploads/'.$this->avatar);
    }

    public function getMobileFullNumberAttribute(){
        return $this->phoneCountry->phone_code.$this->mobile;
    }

    public function scopeIsActive($query){
        return $query->whereStatus('active');
    }

    public function notifications(){
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc')->withPivot('data');
    }

}
