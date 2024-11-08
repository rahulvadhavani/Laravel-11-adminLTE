<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\{AdminProfileRequest,ChangePasswordRequest,StaticPageRequest};
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
   
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Dashboard';
        $data = [];
        $statistics = Cache::remember('statistics', 60 * 15, function () {
            return [
                'UsersCount' => User::userRole()->count()
            ];
        });
        $data['Users'] = ['count' => $statistics['UsersCount'], 'route' => route('admin.users.index'), 'class' => 'bg-primary', 'icon' => 'fas fa-solid fa-users'];
        $cards = $data;
        return view('admin.dashboard',compact('title','cards'));
    }

    public function profile()
    {
        $title = 'Profile';
        $user = Auth::user();
        return view('admin.profile',compact('title','user'));
    }

    public function updateAdminProfile(AdminProfileRequest $request)
    {
        try{
            $userId = Auth::user()->id;
            $post_data = $request->only('first_name','last_name','name','image');
            $post_data['user_id'] = $userId;
            $validUser = User::find($userId);
            if($validUser == null){
                return error('Invalid user detail');
            }
            if($request->image !=''){
                $img = $this->FileUploadHelper($post_data['image'],'uploads/user');
                $post_data['image'] = $img;    
                if($validUser->image !=''){
                    $path = public_path('uploads/user/'.basename($validUser->image));
                    $this->destroyFileHelper($path);
                }
                $post_data['image'] = $post_data['image'];
            } else {
                unset($post_data['image']);
            }
            $validUser->update($post_data);
            return success('Profile updated successfully');
            
        } catch(Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        try{
            $userId = Auth::user()->id;
            $user =User::where('id',$userId)->first();
            $validatedData['password'] = $request->password;
            $user->update($validatedData);
            return success('Password updated successfully');
            
        } catch(Exception $e) {
            return error('Something went wrong!',$e->getMessage());
        }
    }

    public function Logout(){
    	Auth::logout();
    	return \Redirect::to("admin/login")
        ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));
    }
}

