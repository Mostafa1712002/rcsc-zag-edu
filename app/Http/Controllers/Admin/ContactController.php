<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyContactRequest;

class ContactController extends Controller
{

    protected $model;
    public function __construct(Contact $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.contact.index');
        $this->views_path = 'pages.admin.contacts';
    }


    public function index(Request $request){
        $data = [
            'records'=>$this->model->with('user')->when($request->status,function($query) use($request){
                return $query->whereStatus($request->status);
            })->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.contacts')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function show(Contact $contact){
        $data = [
            'page_title'=>($contact->status=='unreplied')? __('site.reply') : __('site.details'),
            'record'=>$contact
        ];
        return view($this->views_path.'.show',$data);
    }

    public function update(ReplyContactRequest $request, Contact $contact){
        $data = ['user_id'=>auth('admin')->id(),'status'=>'replied'];
        $contact->update(array_merge($request->validated(),$data));
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }
}
