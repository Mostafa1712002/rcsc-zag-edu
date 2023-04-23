<?php

namespace App\Http\Controllers\Front;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CommissionTransfer;
use App\Http\Controllers\Controller;

class CommissionController extends Controller{
    public function index(Request $request){
        $records = auth('customer')
            ->user()
            ->commissionTransfers()
            ->when(request('status'),function($query,$status){
                return $query->whereStatus($status);
            });
        $records_count = $records->count();
        $records = $records->orderByDesc('id')->paginate();
        $data = [
            'page_title'=>__('site.commission_transfer_history'),
            'records'=>$records,
            'records_count'=>$records_count
        ];
        return view('pages.front.pages.commission_history',$data);
    }

    public function show(CommissionTransfer $commission_transfer){

        $data = [
            'page_title'=>__('site.transfer_details_of_request_number').$commission_transfer->id,
            'record'=>$commission_transfer
        ];
        return view('pages.front.pages.commission_transfer_details',$data);
    }

    public function calculate(){
        $data=[
            'page_title'=>__('site.calculate_commission'),
            'commission_percent'=>Setting::where('id',1)->value('commission_percent')
        ];
        return view('pages.front.calculate_commission',$data);
    }

    public function create(){
        $data=[
            'page_title'=>__('site.pay_commission'),
            'commission_percent'=>Setting::where('id',1)->value('commission_percent'),
            'bank_account_id'=>Setting::where('id',1)->value('bank_account_id'),
            'banks'=>[],
            'phone_countries'=>[]
        ];
        return view('pages.front.create-commission',$data);
    }


}
