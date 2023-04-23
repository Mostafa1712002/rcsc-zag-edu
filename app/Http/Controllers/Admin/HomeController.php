<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Student;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        $data = [
            'page_title'=>trans('general.home'),
            'admins_count'=>User::isActive()->count(),
            'students_count'=>Student::isActive()->count(),
            'questions_count'=>Question::count(),
        ];
        return view('pages.admin.dashboard',$data);
    }/*index*/

}
