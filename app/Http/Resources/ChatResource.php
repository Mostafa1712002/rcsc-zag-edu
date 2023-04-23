<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource{
    public function toArray($request){
        $other_customer_id = $this->customer1_id;
        $current_customer_id = auth('customer')->id()? auth('customer')->id() : auth('api-customers')->id();
        if($current_customer_id == $this->customer1_id){
            $other_customer_id = $this->customer2_id;
        }
        return [
            'key'=>$this->id,
            'id'=>$this->id,
            'customer1_id'=>$this->customer1_id,
            'customer1'=>new CustomerBreifResource(Customer::find($this->customer1_id)),
            'customer2'=>new CustomerBreifResource(Customer::find($this->customer2_id)),
            'other_customer'=>new CustomerBreifResource(Customer::find($other_customer_id)),
            'last_message'=>new ChatMessageResource($this->chatMessages()->orderByDesc('id')->first()),
            'first_message_id'=>$this->chatMessages()->orderBy('id')->value('id'),
            'unread_count'=>$this->chatMessages()->whereCustomer2Id($current_customer_id)->unread()->count(),
            'created_at'=>$this->created_at,
            'created_at_timestamp'=>strtotime($this->created_at),
            'updated_at'=>$this->updated_at,
            'updated_at_timestamp'=>strtotime($this->updated_at),

        ];
    }
}
