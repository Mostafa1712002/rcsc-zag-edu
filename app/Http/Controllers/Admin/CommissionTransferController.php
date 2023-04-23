<?php

namespace App\Http\Controllers\Admin;

use App\Models\CommissionTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageCommissionTransferRequest;
use App\Http\Requests\ManageCommissionTransferFormRequest;

class CommissionTransferController extends Controller{

    protected $model;
    public function __construct(CommissionTransfer $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.commission-transfer.index');
        $this->views_path = 'pages.admin.commission_transfers';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.manage_commission_transfer')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function show(CommissionTransfer $commission_transfer){
        return view($this->views_path.'.show',['page_title'=>sprintf(__('site.details_of_transfer_request_s'),$commission_transfer->id),'record'=>$commission_transfer]);
    }

    public function receive(CommissionTransfer $CommissionTransfer){
        $CommissionTransfer->update(['status'=>'received']);
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


}
