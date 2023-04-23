<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;

class Footer extends Component{
    public $settings;
    public function __construct(){
        $this->settings = Setting::find(1);
    }

    public function render(){
        return view('components.footer');
    }
}
