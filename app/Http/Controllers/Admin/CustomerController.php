<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageUserFormRequest;
use App\Http\Requests\DeactivateCustomerRequest;

class CustomerController extends Controller{

    protected $model;
    public function __construct(Customer $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.customer.index');
        $this->views_path = 'pages.admin.customers';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.customers')
        ];
        return view($this->views_path.'.index',$data);
    }


    public function activate(Customer $customer){
        $customer->update(['status'=>'active','deactivation_reason'=>'']);
        return redirect()->back()->withSuccessMessage(__('site.saved'));
    }

    public function deactivate(DeactivateCustomerRequest $request, Customer $customer){
        $customer->update(['status'=>'inactive','deactivation_reason'=>$request->deactivation_reason]);
        return redirect()->back()->withSuccessMessage(__('site.saved'));
    }



    public function show(Customer $customer){
        $data = [
            'record'=>$customer,
            'page_title'=>$customer->full_name,
            'not_deleted_customer_ads_count'=>$customer->ads()->count(),
            'deleted_customer_ads_count'=>$customer->trashedAds()->count()
        ];
        return view('pages.admin.customers.show',$data);
    }

}
