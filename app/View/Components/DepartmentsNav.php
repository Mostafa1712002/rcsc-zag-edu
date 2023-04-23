<?php

namespace App\View\Components;

use App\Models\Department;
use Illuminate\View\Component;

class DepartmentsNav extends Component{
    public $departments,$current_department_id;

    public function __construct($department=null){
        $this->current_department_id = $department;
        $this->departments=Department::isActive()->pluck('title_'.app()->getLocale(),'id');
    }

    public function render(){
        return view('components.departments-nav');
    }
}
