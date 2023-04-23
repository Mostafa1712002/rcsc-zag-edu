<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamFinishedController extends Controller{
    public function __invoke(){
        return view('front.exam-finished');
    }
}
