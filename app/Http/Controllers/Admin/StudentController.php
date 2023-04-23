<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageUserFormRequest;
use App\Http\Requests\DeactivateStudentRequest;

class StudentController extends Controller{

    protected $model;
    public function __construct(Student $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.student.index');
        $this->views_path = 'pages.admin.students';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.students')
        ];
        return view($this->views_path.'.index',$data);
    }





    public function show(Student $student){
        $data = [
            'record'=>$student,
            'page_title'=>$student->full_name,
            'not_deleted_student_ads_count'=>$student->ads()->count(),
            'deleted_student_ads_count'=>$student->trashedAds()->count()
        ];
        return view('pages.admin.students.show',$data);
    }

}
