<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource{

    public function toArray($request){
        return [
            'id'=>(int) $this->id,
            'title'=>$this->{"title_".app()->getLocale()}
        ];
    }
}
