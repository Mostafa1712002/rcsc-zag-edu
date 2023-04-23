<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageBankFormRequest;

class BankController extends Controller
{

    protected $model;
    public function __construct(Bank $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.bank.index');
        $this->views_path = 'pages.admin.banks';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.banks')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function create(){
        $data = [
            'page_title'=>__('site.add_new_bank')
        ];
        return view($this->views_path.'.create',$data);
    }

    public function store(ManageBankFormRequest $request){
        Bank::create($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }

    public function edit(Bank $bank)
    {
        $data = [
            'page_title'=>$bank->{"title_".app()->getLocale()},
            'record'=>$bank
        ];
        return view($this->views_path.'.edit',$data);
    }


    public function update(ManageBankFormRequest $request, Bank $bank){
        $bank->update($request->validated());
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


    public function destroy(Bank $bank){
        $relations = $bank->relationships();
        $message_index = 'error_message';
        $message_content = __('site.cant_delete_this_element_because_its_related_to_other_elements');
        if($bank->secureDelete($relations)){
            $message_index = 'success_message';
            $message_content = __('site.saved');
        }
        return $this->redirect->with($message_index,$message_content);
    }
}
