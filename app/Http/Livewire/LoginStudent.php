<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LoginStudent extends Component{
    public $national_id;
    public function store(){
        $this->validate();
        if(Auth::guard('student')->attempt(['national_id' => $this->national_id, 'password' => $this->national_id])){
            return redirect()->to(route('student.home'));
        }
    }

    public function getRules(){
        return [
            'national_id'=>[
                'required',
                'numeric',
                'digits:14',
                Rule::exists('students','national_id')->where('status','active')
            ]
        ];
    }

    public function render(){
        return view('livewire.login-student');
    }
}
