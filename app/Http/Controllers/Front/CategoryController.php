<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller{
    public function __invoke(Category $category){
        $sub_categories =
            is_null($category->parent_id) ?
                $category->children()->pluck('title_'.app()->getLocale(),'id') :
                Category::find($category->parent_id)->children()->pluck('title_'.app()->getLocale(),'id');
        $data = [
            'department'=>$category->department,
            'category'=>$category,
            'page_title'=>$category->{"title_".app()->getLocale()},
            'records'=>$category
                        ->ads($category->parent_id)
                        ->isActive()
                        ->with(['customer','city','department'])
                        ->withCount(['visits'=>function($query){
                            return $query->whereCustomerId(auth('customer')->id());
                        }],'id')
                        ->withSum('visits','visits')
                        ->latest()
                        ->paginate(),
            'sub_categories'=>$sub_categories
        ];
        return view('pages.front.categories.show',$data);
    }
}
