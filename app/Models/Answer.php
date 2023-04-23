<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $casts = ['created_at'=>'datetime','updated_at'=>'datetime'];
    public $timestamps = false;

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
