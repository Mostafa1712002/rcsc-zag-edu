<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Arr;
use App\Traits\ValidationTrait;

class CourseIndex extends Component{
    use ValidationTrait;
    public $current_course_id=0;
    public $current_course=[];
    public $answers = [];
    public $form;




    public function updatedCurrentCourseId(){
        $this->current_course = $this->current_course_id? Course::find($this->current_course_id)->toArray() : [];
    }

    public function filterRecords(){
        return Course::query();
    }



    public function save(){
        $this->validate();
        if($this->current_course_id){
            Course::whereId($this->current_course_id)->update(Arr::only($this->current_course,['title_ar','title_en','description_ar','description_en']));
        }else{
            Course::insert(array_merge($this->current_course,[
                'created_at'=>now(),
                'updated_at'=>now(),
                'status'=>'active'
            ]));
        }
        $this->current_course = [];
        $this->dispatchBrowserEvent('hide-modal',['alert_id'=>'alert-success','modal_id'=>'course-modal']);
    }

    public function getRules(){
        return [
            'current_course.title_ar'=>'required|max:200',
            'current_course.title_en'=>'required|max:200',
            'current_course.description_ar'=>'required|max:500',
            'current_course.description_en'=>'required|max:500'
        ];
    }



    public function render(){
        $records = $this->filterRecords()->paginate();
        return view('livewire.admin.course-index',['records'=>$records,'page_title'=>__('site.courses')]);
    }
}
