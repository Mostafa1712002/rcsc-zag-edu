<?php

namespace App\Http\Controllers\Front;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller{
    public function __invoke(Department $department){
        $ads =
            $department->ads()
            ->with(['customer','city','department'])
            ->withCount(['visits'=>function($query){
                return $query->whereCustomerId(auth('customer')->id());
            }],'id')
            ->withSum('visits','visits')
            ->isActive()->latest()->paginate();
        $data = [
            'department'=>$department,
            'page_title'=>$department->{"title_".app()->getLocale()},
            'records'=>$ads
        ];
        return view('pages.front.departments.show',$data);
    }
}
