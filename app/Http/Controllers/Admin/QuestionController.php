<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller{

    protected $model;
    public function __construct(){
    }


    public function index(){
        $data = ['page_title'=>__('site.questions')];
        return view('pages.admin.questions.index',$data);
    }

    public function answers(Question $question){
        $data = ['page_title'=>__('site.question_answers'), 'record'=>$question];
        return view('pages.admin.questions.answers',$data);
    }

}
