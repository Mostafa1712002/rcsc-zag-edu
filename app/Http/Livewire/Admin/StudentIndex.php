<?php

namespace App\Http\Livewire\Admin;

use App\Exports\StudentExport;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class StudentIndex extends Component{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $full_name = '',$national_id='', $status='';
    public Student $current_student;
    public $current_student_id;

    public function search(){}

    protected function getFilteredRecords(){
        return Student::query()
                ->when($this->full_name,function($query){
                    return $query->where('full_name','LIKE','%'.$this->full_name.'%');
                })->when($this->national_id,function($query){
                    return $query->whereNationalId($this->national_id);
                })->when($this->status, function($query){
                    return $query->whereStatus($this->status);
                })->orderByDesc('id');
    }

    public function delete(){
        $this->current_student->delete();
    }

    public function accept(){
        $this->current_student->update(['status'=>'active']);
        $this->dispatchBrowserEvent('hide-modal',['modal_id'=>'control-student-modal','alert_id'=>'control-student-success']);
    }

    public function setCurrentStudentId($student_id){
        $this->current_student_id = $student_id;
        $this->current_student = Student::find($student_id);
    }

    public function changeAllTo($action,$ids){
        $query = Student::whereStatus('waiting')->whereIn('id',$ids);
        if($action=='accept'){
            $query->update(['status'=>'active']);
        }else{
            $query->delete();
        }
        $this->dispatchBrowserEvent('hide-modal',['modal_id'=>'all-modal','alert_id'=>'all-success']);
    }

    public function updated(){
        $this->full_name = trim($this->full_name);
        $this->national_id = trim($this->national_id);
        $this->resetPage();
    }

    public function export(){
        return Excel::download(new StudentExport($this->getFilteredRecords()->get()), 'students-'.date('Y-m-d_H_i_s').'.xlsx');
    }



    public function render(){
        return view('livewire.admin.student-index',['records'=>$this->getFilteredRecords()->paginate()]);
    }
}
