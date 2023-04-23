<?php

namespace App\View\Components\HTML;

use App\Models\Page;
use Illuminate\View\Component;

class CommissionAgreement extends Component{
    public $ad;
    public function __construct($ad = null){
        $this->agreement = $ad? $ad->{"commission_".app()->getLocale()} : Page::whereId(4)->value('content_'.app()->getLocale());
    }


    public function render(){
        return view('components.commission-contract',['agreement'=>$this->agreement]);
    }
}
