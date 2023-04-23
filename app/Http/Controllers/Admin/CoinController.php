<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coin;
use App\Models\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManageCoinFormRequest;

class CoinController extends Controller
{
    protected $model;
    public function __construct(Coin $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.coin.index');
        $this->views_path = 'pages.admin.coins';
        $this->statuses = ['presale','lunched'];
    }

    public function index(){
        $data = [
            'records'=>$this->model->with(['network','user'])->paginate(),
            'page_title'=>__('site.coin')
        ];

        return view($this->views_path.'.index',$data);
    }

    public function create(){
        return view(
            $this->views_path.'.create',
            [
                'page_title'=>__('general.addNew'),
                'networks'=>Network::all(['id','title']),
                'statuses'=>$this->statuses
            ]
        );
    }

    public function store(ManageCoinFormRequest $request){
        $logo = $request->logo->store(date('Y').'_'.date('m').'_'.date('d'),'uploads');
        auth()->user()->coins()->create(array_merge($request->validated(),['logo'=>$logo]));
        return $this->redirect->withSuccessMessage(__('general.saved'));
    }

    public function edit(Coin $coin){
        return view(
            $this->views_path.'.edit',
            [
                'page_title'=>__('general.edit'),
                'record'=>$coin,
                'networks'=>Network::all(['id','title']),
                'statuses'=>$this->statuses
            ]
        );
    }

    public function update(ManageCoinFormRequest $request, Coin $coin) {
        $data = $request->validated();
        $data['logo'] = ($request->hasFile('logo'))? $request->logo->store(date('Y').'_'.date('m').'_'.date('d'),'uploads') : $coin->logo;
        $coin->update($data);
        return $this->redirect->withSuccessMessage(__('general.saved'));
    }


    public function destroy(Coin $coin){
        if($coin->votes->count() || $coin->watchlists->count()){
            return $this->redirect->withErrorMessage(__('general.can_not_be_deleted'));
        }
        $coin->delete();
        return $this->redirect->withSuccessMessage(__('general.saved'));
    }
}
