<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentHomeController extends Controller{
    public function __invoke(){
        return view('front.student-home');
    }

    public function examFinished(){
        return view('front.exam-finished');
    }

}
