<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;


class AdminUser extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_image','user_role','short_description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // add admin user function call in controller 

    public function webinar() {
        return $this->hasMany('App\Webinar','presenter');
    }

    public static function addadminuser($request) {
        $json_data = "";
        if(isset($request->admin_user_role) && !empty($request->admin_user_role)){
            $array_filter = array_filter($request->admin_user_role);
            $json_data = json_encode($array_filter);
        }
        
        $blog = self::updateOrCreate([
            'name' => $request->admin_user_name,
            'email' => $request->admin_user_email,
            'profile_image' => $request->image_path,
            'user_role' => $json_data,
            'short_description' => $request->user_description,
            'password' => bcrypt($request->password),
        ]);

        return $blog;
    }

    // add admin user function call in controller


    // get admin user function  

    public static function getuserByID($id) {
        return self::where('id', $id)->first();
    }
    // get admin user function  

    //get user permission role by id 
    public static function getuserroleByID($id) {
        return self::where('id', $id)->select('user_role')->first();
    }
    // get user permission role by id 


    // add admin user function call in controller 

    public static function editadminuser($request) {
        $admin_role = "";
        if(isset($request->admin_user_role) && !empty($request->admin_user_role)){
            $admin_role = json_encode(array_filter($request->admin_user_role));
        }

        $updateToArray = [
            'name' => $request->admin_user_name,
            'profile_image' => $request->last_used,
            'email' => $request->admin_user_email,
            'user_role' => $admin_role,
            'short_description' => $request->user_description,
        ];

        if(isset($request->password) && !empty($request->password)){
            $updateToArray = array_merge($updateToArray, [
                'password' => bcrypt($request->password)
            ]);
        }

        $user = self::where(['id' => $request->user_id])->update($updateToArray);
        return $user;
    }

    // add admin user function call in controller 






}
