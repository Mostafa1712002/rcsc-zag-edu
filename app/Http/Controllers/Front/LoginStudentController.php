<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginStudentController extends Controller{
    public function __invoke(){
        return view('front.login-student');
    }
}
