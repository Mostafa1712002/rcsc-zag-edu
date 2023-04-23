<?php
namespace App\Traits;
    trait ValidationTrait{
        public function getValidationAttributes(){
            $atts = $this->getRules();
            $res = [];
            foreach($atts as $k=>$v){
                $res[$k] = __('validation.attributes.'.str_replace('form.','',$k));
                $res[$k] = __('validation.attributes.'.str_replace('current_question.','',$k));
                $res[$k] = __('validation.attributes.'.str_replace('current_course.','',$k));
            }
            return $res;
        }
    }
