<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageDepartmentRequest;

class DepartmentController extends Controller
{

    protected $model;
    public function __construct(Department $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.department.index');
        $this->views_path = 'pages.admin.departments';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.departments')
        ];
        return view($this->views_path.'.index',$data);
    }


    public function create(){
        $data = [
            'page_title'=>__('site.add_new_department'),
            'parent_categories'=>Department::get(['id','title_'.app()->getLocale()])
        ];
        return view($this->views_path.'.create',$data);
    }

    public function store(ManageDepartmentRequest $request){
        Department::create($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }

    public function edit(Department $department){
        $data = [
            'page_title'=>$department->{"title_".app()->getLocale()},
            'record'=>$department
        ];
        return view($this->views_path.'.edit',$data);
    }


    public function update(ManageDepartmentRequest $request, Department $department){
        $department->update($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


    public function destroy(Department $department){
        return redirect()->back();
    }
}
