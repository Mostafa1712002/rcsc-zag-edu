<?php
namespace App\Traits;

use App\Models\City;
use App\Models\Region;
use App\Models\Admodel;
use App\Models\Category;
use Illuminate\Validation\Validator;

trait UpdatedTrait{



    public function makeAllZerosNull(){
        if(!$this->form['admodel_id']){
            unset($this->form['admodel_id']);
        }

        if(!$this->form['parent_category_id']){
            unset($this->form['parent_category_id']);
        }

        if(!$this->form['sub_category_id']){
            unset($this->form['sub_category_id']);
        }


    }


    public function updatedFormDepartmentId(){
        if(!intval($this->form['department_id'])){
            $this->parent_categories = [];
            $this->form['parent_category_id']=0;
        }else{
            $this->parent_categories =
                Category::isActive()
                    ->isParent()
                    ->whereDepartmentId($this->form['department_id'])
                    ->orderBy('title_'.$this->locale)
                    ->pluck('title_'.$this->locale,'id');
        }

        $this->sub_categories = [];
        $this->admodels=[];
        $this->form['parent_category_id']=0;
        $this->form['sub_category_id']=0;
        $this->form['admodel_id']=0;
    }

    public function updatedFormRegionId(){
        if(!intval($this->form['region_id'])){
            $this->cities = [];
            $this->form['region_id'] = 0;
        }else{
            $region = Region::query()->find($this->form['region_id']);
            $this->cities =
                    $region->cities()
                    ->orderBy('name_'.$this->locale)
                    ->pluck('name_'.$this->locale,'id');
            $this->preview['region'] = $region->name??'';

        }

        $this->form['city_id']=0;
    }



    public function updatedFormCityId(){
        $this->preview['city'] = City::query()->select('name_'.$this->locale.' As name')->find($this->form['city_id'])->name??'';
    }

    public function updatedFormParentCategoryId(){
        if(!intval($this->form['parent_category_id'])){
            $this->sub_categories = [];
        }else{
            $this->sub_categories =
                Category::find($this->form['parent_category_id'])
                ->children()
                ->isActive()
                ->orderBy('title_'.$this->locale)
                ->pluck('title_'.$this->locale,'id');
        }

        $this->admodels=[];
        $this->form['sub_category_id']=0;
        $this->form['admodel_id']=0;
    }

    public function updatedFormSubCategoryId(){
        if(!intval($this->form['sub_category_id'])){
            $this->admodels = [];
            $this->form['sub_category_id'] = 0;
        }else{
            $this->admodels =
                Admodel::isActive()
                    ->whereSubCategoryId($this->form['sub_category_id'])
                    ->orderBy('title_'.$this->locale)
                    ->pluck('title_'.$this->locale,'id');
            $this->form['admodel_id']=0;
        }
    }

    public function updatedAllowPrice($value){
        $this->form['price'] = $value? (isset($this->form['price']) ? $this->form['price'] : 0) : null;
    }

    public function updatedPics(){

        $this->withValidator(function (Validator $validator) {
            if($validator->errors()->any()){
                $errors = $validator->messages()->toArray();
                foreach($errors as $k=>$v){
                    $pic_index = explode('.',$k)[1];
                    unset($this->pics[$pic_index]);
                }
            }
            //$this->pics_validation_errors = "All pics should be of type: png, jpg, jpeg and less than 10 MB";
        })->validateOnly('pics.*');

        $this->pics_validation_errors='';
        foreach($this->pics as $pic){
            if(count($this->valid_pics)>=20){
                $this->pics_validation_errors = __('site.max_of_20_pics_are_allowed_for_one_ad');
                break;
            }
            $this->valid_pics[] = $pic;
        }
    }

    public function updatedFormAdmodelId(){
        $this->preview['admodel'] = Admodel::query()->select('title_'.$this->locale. ' AS name')->find($this->form['admodel_id'])->name??'';
    }

    public function updatedFormAdType(){
        switch ($this->form['ad_type']){
            case ('supply'):
                $this->preview['ad_type'] = __('site.supply');
            break;

            case ('demand'):
                $this->preview['ad_type'] = __('site.demand');
            break;

            case ('leave'):
                $this->preview['ad_type'] = __('site.leave');
            break;

            case ('rent'):
                $this->preview['ad_type'] = __('site.rent');
            break;

            default:
                $this->preview['ad_type'] = __('site.not_selected');
        }
    }

    public function updatedFormIsDouble(){
        $this->preview['is_double'] = $this->form['is_double']?__('site.yes'):__('site.no');
    }

    public function updatedFormGearType(){
        switch ($this->form['gear_type'])
        {
            case ('manual'):
                $this->preview['gear_type'] = __('site.manual');
                break;

            case ('automatic'):
                $this->preview['gear_type'] = __('site.automatic');
                break;

            default:
                $this->preview['gear_type'] = __('site.not_selected');
        }
    }

    public function updatedFormFuelType(){
        switch ($this->form['fuel_type'])
        {
            case ('gasoline'):
                $this->preview['fuel_type'] = __('site.gasoline');
                break;

            case ('hybrid'):
                $this->preview['fuel_type'] = __('site.hybrid');
                break;

            case ('diesel'):
                $this->preview['fuel_type'] = __('site.diesel');
                break;

            default:
                $this->preview['fuel_type'] = __('site.not_selected');
        }
    }

    public function updatedFormAdStatus(){
        switch ($this->form['ad_status']){
            case ('new'):
                $this->preview['ad_status'] = __('general.new');
                break;

            case ('used'):
                $this->preview['ad_status'] = __('general.used');
                break;

            case ('junk'):
                $this->preview['ad_status'] = __('validation.attributes.junk');
                break;

            default:
                $this->preview['ad_status'] = __('site.not_selected');
        }

    }

    public function updatedFormMobileNumber(){
        $this->preview['mobile'] = $this->form['mobile_number'];
    }

    public function updatedFormPrice(){
        $this->preview['price'] = $this->form['price'];
    }
}
