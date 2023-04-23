<?php

namespace App\Http\Resources;

use App\Models\Ad;
use App\Models\Customer;
use App\Http\Resources\CustomerBreifResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource{
    public function toArray($request){

        return [
            'id'=>$this->id,
            'event_type'=>$this->data['event_type'],
            'subject_id'=>$this->data['subject_id'],
            'content'=>$this->data['subject']['title_'.app()->getLocale()],
            'title'=>$this->data['title_'.app()->getLocale()],
            'created_ar'=>$this->created_at,
            'read_at'=>$this->read_at,
            'customer'=>new CustomerBreifResource(Customer::find($this->data['customer_id'])),
            'ad'=> new AdBreifResource(Ad::whereId($this->data['subject_id'])->first())
        ];
    }
}
