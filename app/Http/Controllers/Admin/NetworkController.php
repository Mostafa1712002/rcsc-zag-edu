<?php

namespace App\Http\Controllers\Admin;

use App\Models\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageNetworkFormRequest;

class NetworkController extends Controller
{
    protected $model;
    public function __construct(Network $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.network.index');
        $this->views_path = 'pages.admin.networks';
    }

    public function index(){
        $data = [
            'records'=>$this->model->select(['id','symbol','network_id','title'])->withCount('coins')->paginate(),
            'page_title'=>__('site.networks')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function create(){
        return view($this->views_path.'.create',['page_title'=>__('general.addNew')]);
    }

    public function store(ManageNetworkFormRequest $request){
        $record = $this->model::create($request->validated());
        return $this->redirect->withSuccessMessage(__('general.saved'));
    }

    public function edit(Network $network){
        return view($this->views_path.'.edit',['page_title'=>__('general.edit'),'record'=>$network]);
    }

    public function update(ManageNetworkFormRequest $request, Network $network) {
        $network->update($request->validated());
        return $this->redirect->withSuccessMessage(__('general.saved'));
    }


    public function destroy(Network $network){
        if($network->coins->count()){
            return $this->redirect->withErrorMessage(__('general.can_not_be_deleted'));
        }
        $network->delete();
        return $this->redirect->withSuccessMessage(__('general.saved'));
    }
}
