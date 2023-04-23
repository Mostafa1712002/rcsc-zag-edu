<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageCategoryRequest;

class CategoryController extends Controller
{

    protected $model;
    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.category.index');
        $this->views_path = 'pages.admin.categories';
        $this->locale = app()->getLocale();
    }


    public function index($parent_id=null){
        $parent_category = $parent_id? Category::find($parent_id) : null;
        $data = [
            'records'=>$this->model->withCount('children')->whereParentId($parent_id)->orderByDesc('id')->paginate(),
            'page_title'=>$parent_id? __('site.sub_categories') : __('site.categories'),
            'parent_id'=>$parent_id,
            'parent_category'=>$parent_category,
            'create_route'=>route('admin.category.create') . (($parent_id)? '?parent_id='.$parent_id.'&department_id='.$parent_category->department_id : '')
        ];


        return view($this->views_path.'.index',$data);
    }


    public function create(Request $request){
        $title_field = 'title_'.$this->locale;
        $parent_categories =
            request('department_id')?
                Category::isParent()->whereDepartmentId(request('department_id'))->orderBy($title_field)->pluck($title_field,'id')->prepend(__('site.parent_category'),'') :
                collect([__('site.parent_category'),'']);
        $departments = Department::orderBy($title_field)
                       ->where('status','active')
                       ->when(request('department_id'),function($query,$department_id){
                            return $query->orWhere('id',$department_id);
                       })->pluck($title_field,'id')->prepend(__('site.please_select'),'');
        $data = [
            'page_title'=>request('parent_id')? __('site.add_new_sub_category') : __('site.add_new_category'),
            'parent_categories'=>$parent_categories,
            'departments'=>$departments
        ];
        return view($this->views_path.'.create',$data);
    }

    public function store(ManageCategoryRequest $request){
        Category::create($request->validated());
        $route = $request->parent_id ? route('admin.category.children',$request->parent_id) : route('admin.category.index');
        return redirect()->to($route)->withSuccessMessage(__('site.saved'));
    }

    public function edit(Category $category){
        $title_field = 'title_'.$this->locale;
        $department_id = ($parent = $category->parent)? $parent->department_id : $category->department_id;
        $parent_id = ($parent)? $parent->id : null;
        $departments = Department::orderBy($title_field)
                       ->where('status','active')->orWhere('id',$department_id)
                       ->pluck($title_field,'id')->prepend(__('site.please_select'),'');
        $parent_categories = Category::isParent()
                            ->whereStatus('active')
                            ->whereDepartmentId($department_id)
                            ->orWhere(function($query) use($parent_id){
                                return $query->whereId($parent_id);
                            })->orderBy($title_field)
                            ->pluck($title_field,'id')
                            ->prepend(__('site.parent_category'),'');
        $data = [
            'page_title'=>$category->$title_field,
            'record'=>$category,
            'parent_categories'=>$parent_categories,
            'departments'=>$departments
        ];
        return view($this->views_path.'.edit',$data);
    }


    public function update(ManageCategoryRequest $request, Category $category){
        $category->update($request->validated());
        $route = $request->parent_id ? route('admin.category.children',$request->parent_id) : route('admin.category.index');
        return redirect()->to($route)->withSuccessMessage(__('site.saved'));
    }


    public function destroy(Category $category){
        return redirect()->back();
    }
}
