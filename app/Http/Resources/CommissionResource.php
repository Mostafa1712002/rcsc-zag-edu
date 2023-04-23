<?php

namespace App\Http\Resources;

use App\Http\Resources\BankResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionResource extends JsonResource{
    public function toArray($request){
        return [
            'id'=>(int) $this->id,
            'amount'=> $this->commission_amount??0,
            'ad_id'=>$this->ad_id,
            'transfer_date'=>$this->transfer_date->format('Y-m-d'),
            'created_at'=>$this->created_at->format('Y-m-d'),
            'status_f'=>__('site.'.$this->status),
            'status'=>$this->status,
            'transfer_receipt'=>url('uploads/pics/'.$this->transfer_receipt),
            'full_name'=>$this->full_name,
            'mobile'=>'966'.$this->mobile,
            'notes'=>$this->notes,
            'transfer_name'=>$this->transfer_name,
            'bank'=>new BankResource($this->bank)
        ];
    }
}
