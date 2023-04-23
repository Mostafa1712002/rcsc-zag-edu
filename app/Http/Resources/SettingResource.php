<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource{

    public function toArray($request){
        return [
            'whatsapp'=>$this->whatsapp,
            'linkedin'=>$this->linkedin,
            'youtube'=>$this->youtube,
            'instagram'=>$this->instagram,
            'twitter'=>$this->twitter,
            'facebook'=>$this->facebook,
            'snapchat'=>$this->snapchat,
            'email'=>$this->email,
            'website'=>$this->website,
            'mobile_number'=>$this->mobile_number,
            'fax'=>$this->fax,
            'commission_percent'=>$this->commission_percent,
            'bank_account_id'=>$this->bank_account_id
        ];
    }
}
