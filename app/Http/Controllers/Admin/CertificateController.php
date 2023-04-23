<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Student;

class CertificateController extends Controller{

    public function show(Student $student){
        app()->setLocale('en');
        $data = [
            'student'=>$student,
            'course'=>$student->courses()->limit(1)->first()
        ];
        return view('pages.admin.certificates.show',$data);
    }



}
