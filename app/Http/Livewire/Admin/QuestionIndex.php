<?php

namespace App\Http\Livewire\Admin;

use App\Models\Answer;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Arr;
use App\Traits\ValidationTrait;

class QuestionIndex extends Component{
    use ValidationTrait;
    public $current_question_id=0;
    public $current_question=[];
    public $answers = [];
    public $form;




    public function updatedCurrentQuestionId(){
        $this->current_question = $this->current_question_id? Question::find($this->current_question_id)->toArray() : [];
    }

    public function filterRecords(){
        return Question::query();
    }



    public function save(){
        $this->validate();
        if($this->current_question_id){
            Question::whereId($this->current_question_id)->update(Arr::only($this->current_question,['content']));
        }else{
            Question::insert([
                'content'=>$this->current_question['content'],
                'created_at'=>now(),
                'updated_at'=>now(),
                'status'=>'active'
            ]);
        }
    }

    public function getRules(){
        return [
            'current_question.content'=>'required|max:700'
        ];
    }

    public function render(){
        $records = $this->filterRecords()->paginate();
        return view('livewire.admin.question-index',['records'=>$records,'page_title'=>__('site.questions')]);
    }
}
