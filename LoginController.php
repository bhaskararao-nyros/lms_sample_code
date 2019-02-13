<?php 

namespace App\Modules\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
* 
*/
class AuthController extends Controller
{
    
    public function home()
    {
        return view('vueApp');
    }

    public function index()
    {
        // Getting all users on load
        return User::orderBy('id', 'DESC')->get();
    }

    public function userLogin(Request $request)
    {
        $check_user = DB::select('SELECT * FROM `users_tb` WHERE  
                email = "'.$request->email.'" ');
        if (count($check_user) > 0) {
            if ($check_user[0]->status == 1) {
                if ($request->password == $check_user[0]->password) {
                    $roles = DB::select('SELECT * FROM `roles` WHERE  
                    user_type = "'.$check_user[0]->role_as.'" ');
                    return response()->json(['status'=>'success','msg'=>'Authentication successful', 'user'=> $check_user, 'roles'=> $roles, 'access_token'=> sha1(time())]);
                } else {
                    return response()->json(['status'=>'error','msg'=>'Incorrect Password']);
                }
            } else {
                return response()->json(['status'=>'error','msg'=>'Sorry. you are not an activated user']);
            }
        } else {
            return response()->json(['status'=>'error','msg'=>'User not found']);
        }
    }
}