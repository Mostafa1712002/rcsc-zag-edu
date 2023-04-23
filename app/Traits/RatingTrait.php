<?php
namespace App\Traits;

use App\Models\Rating;
trait RatingTrait{
    //Ratings made by customers on this model (MUST be defined in all RATEable models)
    public function ratingsOn(){
        return $this->morphMany(Rating::class,'ratingable');
    }

    //Ratings made by this model on other models
    public function ratingsBy($on=''){
        return $this->hasMany(Rating::class);
    }

}
