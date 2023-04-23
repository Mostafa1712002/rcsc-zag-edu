<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $status = '',
    $email='',
    $mobile='';

    protected function getFilteredRecords(){
        return User::query()
                ->when($this->status,function($query){
                    return $query->whereStatus($this->status);
                })->when($this->email,function($query){
                    return $query->whereEmail($this->email);
                })->when($this->mobile,function($query){
                    return $query->whereMobile($this->mobile);
                })->orderByDesc('id')->paginate();
    }

    public function updated(){
        $this->email = trim($this->email);
        $this->mobile = trim($this->mobile);
        $this->validate();
        $this->resetPage();
    }

    protected function getRules(){
        return [
            'email'=>'nullable|email:dns,rfc',
            'mobile'=>'nullable|integer|digits:9'
        ];
    }

    public function render(){
        return view('livewire.admin.user-index',['records'=>$this->getFilteredRecords()]);
    }
}
