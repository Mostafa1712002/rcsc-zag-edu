<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller{
    private $model;
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getCategories($parent_id=null)
    {
        return response()->json(CategoryResource::collection($this->model->whereParentId($parent_id)->get()));
    }
}
