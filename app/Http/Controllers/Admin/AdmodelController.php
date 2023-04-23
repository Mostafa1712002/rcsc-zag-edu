<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admodel;
use App\Models\Category;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageAdmodelRequest;
use App\Http\Requests\ManageDepartmentRequest;

class AdmodelController extends Controller
{

    protected $model;
    public function __construct(Admodel $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.admodel.index');
        $this->views_path = 'pages.admin.admodels';
        $this->locale = app()->getLocale();
    }


    public function index(){
        $data = [
            'records'=>$this->model->with(['parentCategory','subCategory','department'])->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.admodels')
        ];
        return view($this->views_path.'.index',$data);
    }


    public function create(){
        $data = [
            'page_title'=>__('site.add_new_admodel'),
            'parent_categories'=>collect([__('site.parent_category')]),
            'sub_categories'=>collect([__('site.sub_category')]),
            'departments'=>Department::isActive()->pluck('title_'.$this->locale,'id')->prepend(__('site.please_select'),''),
        ];
        return view($this->views_path.'.create',$data);
    }

    public function store(ManageAdmodelRequest $request){
        Admodel::create($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }

    public function edit(Admodel $admodel){
        $title_field = "title_".$this->locale;
        $data = [
            'page_title'=>$admodel->$title_field,
            'record'=>$admodel,
            'parent_categories'=>Category::isParent()->isActive()->whereDepartmentId($admodel->department_id)->pluck($title_field,'id')->prepend(__('site.please_select'),''),
            'departments'=>Department::isActive()->pluck($title_field,'id')->prepend(__('site.please_select'),''),
            'sub_categories'=>Category::whereParentId($admodel->parent_category_id)->pluck($title_field,'id'),
        ];
        return view($this->views_path.'.edit',$data);
    }


    public function update(ManageAdmodelRequest $request, Admodel $admodel){
        $admodel->update($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }



}
