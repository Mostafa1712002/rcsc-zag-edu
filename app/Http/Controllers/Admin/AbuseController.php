<?php
namespace App\Http\Controllers\Admin;

use App\Models\Abuse;
use App\Http\Controllers\Controller;

class AbuseController extends Controller{
    public function index(){
        return view('pages.admin.abuses.index',['page_title'=>__('site.manage_abuses')]);
    }

    public function show(Abuse $abuse){
        $data = [
            'page_title'=>__('site.details_of_abuse_number').' '.$abuse->id,
            'record'=>$abuse
        ];
        return view('pages.admin.abuses.show',$data);
    }
}
