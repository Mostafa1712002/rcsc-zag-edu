<?php

namespace App\Models;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable implements JWTSubject{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['course_ids'=>'array'];

    public function getAvatarUrlAttribute(){
        return url('uploads/pics/'.$this->personal_pic);
    }

    public function getExamPicUrlAttribute(){
        return url('uploads/pics/'.$this->exam_pic);
    }


    public function courses(){
        return Course::whereIn('id',$this->course_ids);
    }

    public function getExamGradeAttribute(){
        if(is_null($this->exam_degree) || is_null($this->questions_count)){
            return 'not_solved';
        }

        $exam_percent = ($this->exam_degree/($this->questions_count*10))*100;
        if($exam_percent>=0 && $exam_percent<50){
            return 'fail';
        }elseif($exam_percent>=50 && $exam_percent<65){
            return 'fair';
        }elseif($exam_percent>=65 && $exam_percent<75){
            return 'good';
        }elseif($exam_percent>=75 && $exam_percent<85){
            return 'very_good';
        }elseif($exam_percent>85){
            return 'excellent';
        }
    }

    public function scopeIsActive($query){
        return $query->whereStatus('active');
    }

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->status='waiting';
            $model->password=bcrypt($model->national_id);
        });
    }

    //JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

}
