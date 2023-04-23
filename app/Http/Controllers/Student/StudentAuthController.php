<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
class StudentAuthController extends Controller{
    public function showLoginForm(){
        return view('pages.front.pages.login');
    }



    public function logout(){
        auth('customer')->logout();
        return redirect()->to(route('customer.login'))->with('success_message',__('site.logged_out_successfully'));
    }
}
