<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class CourseController extends Controller{

    protected $model;
    public function __construct(){
    }


    public function index(){
        $data = ['page_title'=>__('site.courses')];
        return view('pages.admin.courses.index',$data);
    }


}
