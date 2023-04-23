<?php

namespace App\Http\Controllers\Api;

use App\Models\Bank;
use App\Models\Region;
use App\Models\Admodel;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdmodelBreifResource;
use App\Http\Resources\BankResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\AdmodelResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\CategoryBreifResource;
use App\Http\Resources\DepartmentBreifResource;


class DataController extends Controller
{
    public function getRegions(){
        return RegionResource::collection(Region::active()->get());
    }

    public function getBanks(){
        return BankResource::collection(Bank::isActive()->orderBy('title_'.app()->getLocale())->get());
    }

    public function getDepartments(){
        return DepartmentResource::collection(Department::isActive()->get());
    }

    public function getAdmodels(){
        return AdmodelResource::collection(Admodel::isActive()->get());
    }

    public function contactSettings(){
        return new SettingResource(Setting::find(1));
    }

    public function getDepartmentCategories(Department $department){
        return response()->json(CategoryResource::collection($department->parentCategories()->isActive()->get()));
    }



    //V2
    public function getDepartmentsV2(){
        return DepartmentBreifResource::collection(Department::isActive()->get());
    }

    public function getParentCategories(Department $department){
        return CategoryBreifResource::collection($department->parentCategories()->isActive()->get());
    }

    public function getSubCategories(Category $category){
        return CategoryBreifResource::collection($category->children()->isActive()->get());
    }

    public function getCategoryAdmodels(Category $category){
        return AdmodelBreifResource::collection($category->admodels()->isActive()->get());
    }

}
