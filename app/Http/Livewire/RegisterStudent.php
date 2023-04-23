<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Traits\ValidationTrait;
use Illuminate\Validation\Validator;

class RegisterStudent extends Component{
    use WithFileUploads, ValidationTrait;
    public $form, $personal_pic, $ack_video;

    public function store(){
        info('bbbbbbbbbbbbbbbbbbbb',[$this->form]);
        $this->validate();
        $path = date('Y/m/d');
        $this->form['personal_pic'] = $this->personal_pic->storeAs($path,Str::random(75).'_'.mt_getrandmax().'.'.$this->personal_pic->extension(),'public');
        $this->form['ack_video'] = $this->ack_video->storeAs($path,Str::random(75).'_'.mt_getrandmax().'.'.$this->ack_video->extension(),'public');
        // dd($this->form);
        Student::create($this->form);
        return redirect()->to(route('student.login'));
    }

    public function getRules(){
        return [
            'form.full_name'=>'required|max:200',
            'form.national_id'=>'required|numeric|digits:14',
            'personal_pic'=>'required|file|mimes:png,jpg,jpeg|max:6000',
            'ack_video'=>'required|file|mimetypes:video/*|max:102400',
            'form.course_ids'=>'required|array',
            'form.course_ids.*'=>'exists:courses,id'
        ];
    }

    public function updatedPersonalPic(){
        $this->withValidator(function (Validator $validator) {
            if($validator->errors()->any()){
                $this->personal_pic = null;
            }
        })->validateOnly('personal_pic');
    }

    public function updatedAckVideo(){
        $this->withValidator(function (Validator $validator) {
            if($validator->errors()->any()){
                $this->ack_video = null;
            }
        })->validateOnly('ack_video');
    }

    public function render(){
        return view('livewire.register-student',['courses'=>Course::get()]);
    }
}
