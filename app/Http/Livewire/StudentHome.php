<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Student;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Traits\ValidationTrait;
use Illuminate\Validation\Validator;

class StudentHome extends Component{
    use WithFileUploads, ValidationTrait;
    public $form, $personal_pic, $ack_video;
    public $exam_pic=null;
    public $questions;

    public $student_answers = [];
    public $has_uploaded_exam_pic=false, $has_already_answered_exam=false;
    public $error_message = '';

    public $visible_questions =0;


    public function mount(){
        $this->questions = $this->getQuestions();
        $this->has_uploaded_exam_pic = !is_null(auth('student')->user()->exam_pic);
        $this->has_already_answered_exam = !is_null(auth('student')->user()->exam_degree);

    }

    public function store(){
        $this->validate();
        $path = date('Y/m/d');
        $this->exam_pic = $this->exam_pic->storeAs($path,Str::random(75).'_'.mt_getrandmax().'.'.$this->exam_pic->extension(),'public');
        auth('student')->user()->update(['exam_pic'=>$this->exam_pic]);
        $this->has_uploaded_exam_pic = true;
    }

    public function saveAnswers(){
        $this->error_message = '';
        if(count($this->student_answers) == count($this->questions)){
            $student_degree = Answer::whereIn('id',$this->student_answers)->whereIsCorrect('correct')->count() * 10;
            auth('student')->user()->update(['exam_degree'=>$student_degree,'exam_at'=>now(),'questions_count'=>count($this->questions)]);
            return redirect(route('student.exam_finished'));
        }else{
            $this->error_message = __('site.please_answer_all_questions');
        }
    }

    public function setAnswer($question_id, $answer_id){
        $this->student_answers[$question_id]=$answer_id;
        $this->visible_questions = count($this->student_answers);
        if(count($this->student_answers) == count($this->questions)){
            $this->error_message='';
        }
    }

    public function getRules(){
        return [
            'exam_pic'=>'required|file|mimes:png,jpg,jpeg|max:6000'
        ];
    }

    public function updatedExamPic(){
        $this->withValidator(function (Validator $validator) {
            if($validator->errors()->any()){
                $this->exam_pic = null;
            }
        })->validateOnly('exam_pic');
    }

    protected function getQuestions(){
        return Question::whereStatus('active')->with('answers')->inRandomOrder()->limit(20)->get();
    }

    public function render(){
        return view('livewire.student-home');
    }
}
