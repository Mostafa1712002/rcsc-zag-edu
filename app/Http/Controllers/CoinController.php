<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function coin(Coin $coin){
        return view('pages.front.pages.coins.coin',compact('coin'));
    }
}
