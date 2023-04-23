<?php

namespace App\Models;

use App\Traits\FollowTrait;
use App\Traits\RatingTrait;
use App\Traits\SecureDelete;
use Illuminate\Support\Carbon;
use App\Traits\RelationshipsTrait;
use App\Services\GenerateCodeService;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable implements JWTSubject,MustVerifyEmail{
    use HasFactory,RelationshipsTrait,SecureDelete,RatingTrait,FollowTrait,Notifiable;
    protected $guarded = [];

    protected $casts = ['created_at'=>'datetime','verification_code_generated_at'=>'datetime','reset_password_code_generated_at'=>'datetime'];


    public function unreadChatMessages(){

        return $this->hasMany(ChatMessage::class,'customer2_id')->whereNull('read_at')->whereHas('customer1',function($query){
            return $query->whereStatus('active');
        });
    }
    public function favoriteAds(){
        return $this->hasManyThrough(Ad::class,Favorite::class,'ad_id','id');
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function devices(){
        return $this->hasMany(CustomerDevice::class);
    }

    public function followingAds(){
        return
            Ad::with(['customer','city','department','parentCategory','subCategory','admodel'])
                ->orderByDesc('updated_at')
                ->find($this->following('ad')->pluck('followable_id'));
    }


    public function isFollowing($followable_id,$followable_type){
        return $this->following($followable_type)->where('followable_id',$followable_id)->exists();
    }


    public function commissionTransfers(){
        return $this->hasMany(CommissionTransfer::class)->orderByDesc('id');
    }

    public function ads(){
        return $this->hasMany(Ad::class)->orderByDesc('updated_at');
    }

    public function trashedAds(){
        return $this->hasMany(Ad::class)->onlyTrashed();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function visits(){
        return $this->hasMany(AdVisit::class);
    }

    public function getAvgRatingAttribute(){
        return round($this->ratingsOn()->avg('value'),2);
    }


    public function getAvatarUrlAttribute(){
        return ($this->picture)? url('uploads/pics/'.$this->picture) : asset('front/assets/images/icons-user-avatar.png');
    }

    public function scopeIsActive($query){
        return $query->whereStatus('active');
    }

    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function getMobileFullNumberAttribute(){
        return $this->phoneCountry->phone_code.$this->mobile;
    }

    public function phoneCountry(){
        return $this->belongsTo(Country::class,'country_code','iso_code');
    }

    public function getRatingStarsAttribute(){
        return spark_starsRating($this->avg_rating);
    }

   //JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function getVerificationCodeGeneratedSinceAttribute(){
        return now()->diffInSeconds(Carbon::parse($this->verification_code_created_at));
    }

    public function getResetPasswordCodeGeneratedSinceAttribute(){
        return now()->diffInSeconds(Carbon::parse($this->reset_password_code_generated_at));
    }

    public function getForgetPasswordWaitTimeAttribute(){
        $wait_time = $this->reset_password_num<=3 || $this->reset_password_num==null? 180:3600;
        return $wait_time-$this->reset_password_code_generated_since;
    }


    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->resend_verification_code_num=0;
            $model->status='active';
            $model->verification_code_generated_at = now();
            $model->verification_code= GenerateCodeService::getCode();
        });
    }

}
