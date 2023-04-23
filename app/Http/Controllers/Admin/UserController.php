<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\ManageUserFormRequest;

class UserController extends Controller{

    protected $model;
    public function __construct(User $model){
        $this->model = $model;
        $this->redirect = redirect()->route('admin.user.index');
        $this->views_path = 'pages.admin.users';
    }


    public function index(){
        $data = [
            'records'=>$this->model->orderBy('id','desc')->paginate(),
            'page_title'=>__('site.users')
        ];
        return view($this->views_path.'.index',$data);
    }

    public function create(){
        $data = [
            'page_title'=>__('site.add_new_user')
        ];
        return view($this->views_path.'.create',$data);
    }

    public function store(ManageUserFormRequest $request){
        $avatar = config('app.default_user_avatar');
        if($request->hasFile('avatar')){
            $avatar = $request->avatar->store(date('Y/m/d'),'uploads');
        }

        $data = array_merge(Arr::except($request->validated(),['password_confirmation']),['avatar'=>$avatar,'password'=>bcrypt($request->password)]);
        User::create($data);
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }

    public function toggleStatus(User $user){
        $new_status = ($user->status=='active')? 'inactive' : 'active';
        $user->update(['status'=>$new_status]);
        return $this->redirect->withSuccessMessage(__('site.saved'));
    }


    public function show(User $user){
        $data = ['record'=>$user,'page_title'=>$user->name];
        return view('pages.admin.users.show',$data);
    }

    public function edit(User $user){
        $data = [
            'page_title'=>$user->name,
            'permissions'=>Permission::orderBy('id')->pluck('name'),
            'record'=>$user
        ];
        return view($this->views_path.'.edit',$data);
    }

    public function update(ManageUserFormRequest $request, User $user){

        if(User::isActive()->count()==1 && $request->status=='inactive' && $user->status !='inactive'){
            return redirect()->back()->withErrorMessage(__('site.cant_deactivate_all_users'));
        }

        $avatar = $user->avatar;
        if($request->hasFile('avatar')){
            $avatar = $request->avatar->store(date('Y/m/d'),'uploads');
        }


        $data = array_merge(Arr::except($request->validated(),['password_confirmation']),['avatar'=>$avatar]);
        $data['password'] = ($data['password'])? bcrypt($data['password']) : $user->password;
        $data['deactivation_reason'] = ($data['status']=='active')? '' : $data['deactivation_reason'];
        $user->update($data);

        if($request->status == 'inactive' && $user->id==auth('admin')->id()){
            auth('admin')->logout();
            return redirect()->route('login');
        }

        return $this->redirect->withSuccessMessage(__('site.saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user){
        if($user->status == 'active' && User::isActive()->count()==1){
            return redirect()->back()->withErrorMessage(__('site.cant_delete_all_users'));
        }

        $user->delete();

        if($user->id == auth('admin')->id()){
            auth('admin')->logout();
            return redirect()->route('login');
        }

        return $this->redirect->withSuccessMessage(__('site.saved'));
    }
}
