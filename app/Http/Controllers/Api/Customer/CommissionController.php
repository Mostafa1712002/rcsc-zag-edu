<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CommissionTransfer;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommissionResource;
use App\Http\Requests\StoreCommissionRequest;

class CommissionController extends Controller{
    public function index(){

        return CommissionResource::collection(auth('api-customers')
            ->user()
            ->commissionTransfers()
            ->when(request('status'),function($query,$status){
                return $query->whereStatus($status);
            })
            ->when(request('ad_id'),function($query,$ad_id){
                return $query->whereAdId($ad_id);
            })->when(request('id'),function($query,$id){
                return $query->whereId($id);
            })
            ->paginate()
        );
    }

    public function show(CommissionTransfer $commission_transfer){

        abort_if(auth('api-customers')->id() != $commission_transfer->customer_id,403,__('site.you_are_not_allowed_to_view_this_page'));
        return new CommissionResource($commission_transfer);
    }

    public function store(StoreCommissionRequest $request){
        $data = $request->validated();
        $data['transfer_receipt'] = $request->transfer_receipt->storeAs(date('Y/m/d'),Str::random(50).'.'.$request->transfer_receipt->extension(),'uploads');
        return new CommissionResource(auth('api-customers')->user()->commissionTransfers()->create($data));
    }
}
