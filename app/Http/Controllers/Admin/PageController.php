<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagePageFormRequest;

class PageController extends Controller
{

    protected $model;
    public function __construct(Page $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.page.index');
        $this->views_path = 'pages.admin.pages';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.page')
        ];
        return view($this->views_path.'.index',$data);
    }


    public function edit(Page $page){
        $data = [
            'page_title'=>$page->{"title_".app()->getLocale()},
            'record'=>$page
        ];
        return view($this->views_path.'.edit',$data);
    }


    public function update(ManagePageFormRequest $request, Page $page){
        $page->update($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


    public function destroy(Page $page){
        $page->delete();
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }
}
