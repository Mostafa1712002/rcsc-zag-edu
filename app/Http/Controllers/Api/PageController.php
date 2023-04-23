<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Models\Page;
use App\Http\Requests\LikeRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PageResource;

class PageController extends Controller{
    public function show(Page $page){
        return new PageResource($page);
    }
}
