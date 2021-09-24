<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\AdminUser;
use App\User;
use File;
use View;

class AdminUserController extends Controller
{

	public function __construct() {
		$this->middleware(function ($request, $next) { 
			$roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('admin users Management', $roles)) {
                echo "This User can not be updated.";
                die;
            } 
			return $next($request);
		});
		$this->middleware('auth:admin');
		// $roles = json_decode(Auth::user()->user_role,true);
		
	} 



 	//show admin user list in admin
	public function admin_users(){
		
		$admin_users = AdminUser::orderBy('id', 'desc')->get();
		return view('admin.admin_user', ['admin_users' => $admin_users]);
	}
 	//show admin user list in admin


	// add new admin user 
	public function add_new_admin_user(){
		$user_roles = \Config::get('admin_roles.admin_roles');
		return view('admin.add_admin_user', ['user_roles' => $user_roles]);
	}
	// add new admin user 


	//  save new admin user 
	public function save_new_admin_user(Request $request){
		$validator = Validator::make($request->all(), [
			'admin_user_name' => 'required|unique:admin_users,name',
			'profile_picture' => 'mimes:jpeg,jpg,png,gif|max:20000',
			'admin_user_email' => 'required|email|unique:admin_users,email',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)
			->withInput();
		}

		$user = AdminUser::addadminuser($request);
		$request->session()->flash('status', 'Admin User added successfully');
		return redirect()->route('admin-user');
	}
	//  save new admin user 

	//   admin section upload drag and drop image 
	public function upload_user_profile(Request $request){
		if ($request->has('profile_picture')) {
			$path_to_delete = str_replace(config('app.url') . '/', "", $request->get('last_used'));
			if (File::exists($path_to_delete)) {
				unlink($path_to_delete);
			}
			$file = $request->file('profile_picture'); 
			$file = is_array($file) ? $file[0] : $file;

			$filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();

			$path = $file->storeAs('admin_user_profile', $filename, 'public');
			$url = config('app.url') . '/storage/' . $path;
			return response()->json(['success'=>true,'url'=>$url]);
		}
		return response()->json(['success'=>false,'url'=>""]);
	}
	//   admin section upload drag and drop image 


	//   admin section upload drag and drop image  

	public function edit_user_form(Request $request, $id){
		$admin_user = AdminUser::getuserByID($id);
		if($admin_user->email == "info@debutify.com"){
			die("This User can not be updated");
		}
		$user_roles = \Config::get('admin_roles.admin_roles');
		return view('admin.edit_admin_user', ['admin_user' => $admin_user,'user_roles' => $user_roles]);
	}
	// admin section upload drag and drop image  



	// edit admin user form  
	public function edit_user(Request $request, $id){

		$validator = Validator::make($request->all(), [
			'admin_user_name' => 'required|unique:admin_users,name,' .$id,
			'profile_picture' => 'mimes:jpeg,jpg,png,gif|max:20000',
			'admin_user_email' => 'required|email|unique:admin_users,email,' .$id,
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)
			->withInput();
		}

		$admin_user = AdminUser::find($id);
		if($admin_user->email == "info@debutify.com"){
			die("This User can not be updated");
		}
		if($admin_user){
			$user_roles = \Config::get('admin_roles.admin_roles');
			$request->request->add(['user_id' => $id,'user_roles' => $user_roles]);
			AdminUser::editadminuser($request);
			$request->session()->flash('status', 'Admin User updated successfully');
		}
		return redirect()->route('admin-user');

	}		
	// edit admin user form  


		//  admin section delete admion user 
	public function deleteadminuser(Request $request, $id) {
		$AdminUser = AdminUser::find($id);
		if($AdminUser->email == "info@debutify.com"){
			die("This User can not be updated");
		}
		if ($AdminUser) {
			$AdminUser->delete();
		}
		$request->session()->flash('status', 'Admin User deleted successfully');
		return redirect()->route('admin-user');
	}
		//  admin section delete admion user 


	public function ajax_search_admin(Request $request){

	 			$admin_users = AdminUser::where(function ($query) use($request) {
                if($request->query('query') != ''){
                  $query->where('name', 'like', '%' . $request->query('query') . '%')
                       ->orWhere('email', 'like', '%'.$request->query('query').'%') 
                       ->orWhere('user_role', 'like', '%'.$request->query('query').'%') 
                       ->orWhere('short_description', 'like', '%'.$request->query('query').'%') ;
                }
              })->orderBy('id', 'desc')
              ->paginate(50);
              $html = View::make('admin.admin_user_table',['admin_users' => $admin_users]);
              $response = $html->render();
              return response()->json([
                  'status' => 'success',
                  'html' => $response
              ]); 
    }


}
