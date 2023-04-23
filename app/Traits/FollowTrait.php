<?php
namespace App\Traits;

use App\Models\Follow;
trait FollowTrait{
    //models followed by this model
    public function following($type=null){
        return $this->hasMany(Follow::class)->when($type,function($query) use($type){
            return $query->whereFollowableType('App\Models\\'.ucfirst($type));
        });
    }

    //models following this model
    public function followers(){
        return $this->morphMany(Follow::class,'followable');
    }

    public function getFollowersCountAttribute(){
        return $this->followers()->count();
    }

}
