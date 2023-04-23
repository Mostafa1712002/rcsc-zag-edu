<?php

namespace App\Http\Controllers\Front;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller{
    public function aboutUs(){
        $record = Page::find(1);
        return view('pages.front.pages.page',['record'=>$record,'page_title'=>$record->{"title_".app()->getLocale()}]);
    }

    public function privacyPolicy(){
        $record = Page::find(3);
        return view('pages.front.pages.page',['record'=>$record,'page_title'=>$record->{"title_".app()->getLocale()}]);
    }

    public function terms(){
        $record = Page::find(2);
        return view('pages.front.pages.page',['record'=>$record,'page_title'=>$record->{"title_".app()->getLocale()}]);
    }

    public function commissionAgreement(){
        $record = Page::find(4);
        return view('pages.front.pages.page',['record'=>$record,'page_title'=>$record->{"title_".app()->getLocale()}]);
    }


}
