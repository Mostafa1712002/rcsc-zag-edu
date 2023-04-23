<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['created_at'=>'datetime','updated_at'=>'datetime'];
    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
