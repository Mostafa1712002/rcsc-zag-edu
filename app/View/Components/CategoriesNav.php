<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Department;
use Illuminate\View\Component;

class CategoriesNav extends Component{
    public $categories,$current_category_id;
    public function __construct(Department $department=null,$category=null){
        $this->categories =  $department->categories()->isActive()->isParent()->pluck('title_'.app()->getLocale(),'id');
        $this->current_category_id=$category;
    }

    public function render(){
        return view('components.categories-nav');
    }
}
