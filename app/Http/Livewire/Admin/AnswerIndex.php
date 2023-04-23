<?php

namespace App\Http\Livewire\Admin;

use App\Models\Answer;
use Livewire\Component;
use App\Models\Question;

class AnswerIndex extends Component{
    public $question, $current_answer_id, $current_answer;
    public $form;
    public function mount(Question $question){
        $this->question = $question;
    }

    public function save(){
        $this->validate([
            'form.content'=>'required|max:200',
            'form.is_correct'=>'required|in:correct,wrong'
        ]);
        if($this->current_answer_id){
            Answer::whereId($this->current_answer_id)->update($this->form);
        }else{
            $this->question->answers()->create($this->form);
        }

        $this->form=[];
        $this->dispatchBrowserEvent('hide-modal',['modal_id'=>'answer-modal','alert_id'=>'alert-success']);
    }

    public function delete(){
        Answer::whereId($this->current_answer_id)->delete();
        $this->dispatchBrowserEvent('hide-modal',['modal_id'=>'delete-modal','alert_id'=>'delete-answer-success']);
    }

    public function updatedCurrentAnswerId(){
        $this->form = $this->current_answer_id? Answer::find($this->current_answer_id)->toArray() : [];
    }

    protected function filterRecords(){
        return $this->question->answers();
    }
    public function render(){
        return view('livewire.admin.answer-index',['records'=>$this->filterRecords()->paginate(100)]);
    }
}
