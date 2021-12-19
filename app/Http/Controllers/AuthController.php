<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Image;
use DB;
use Log;
use File;
Use Exception;
use Carbon\Carbon;
use \DateTime;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  

    public function registration()
    {
        return view('auth.registration');
    }

    public function storeUser(Request $request){

        // Log::info(print_r($request->all(),true));
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();

            if(isset($request->image)){

                foreach($request->image as $img_key => $img_val){
            
                    $filenameoriginal = $img_val['subject']->getClientOriginalName();

                    $destinationPath = public_path('images/users');

                    $image_name = 'users/USER' . '_' . time() . "." . $img_val['subject']->getClientOriginalExtension();;

                    $img_val['subject']->move($destinationPath, $image_name);
                
                    $image = new Image();
                    $image->user_id = $user->id;
                    $image->image_name = $image_name;
                    $image->save();
                }
            }

            return redirect()->route('register')->with('error', 'The error message here!');

        } catch(Exception $exception)
        {
        return redirect()->route('register')->with('error', 'The error message here!');
        }
    }

    public function dashboard(Request $request){
        try {

           $get_user = User::orderBy('id','DESC')->get();

           return view('auth.dashboard',compact('get_user'));


        } catch(Exception $exception)
        {
          return redirect()->route('register')->with('error', 'The error message here!');
        }
    }

    public function userImage(Request $request){

        if (User::where('id', $request->id)->exists()) {

            $image = Image::where('user_id',$request->id)->get()->toArray();

            return response()->json(['success' => 1 , 'data' =>  $image]);



        }
        else {

          return redirect()->route('register')->with('error', 'User not found!');
        }
    }

    public function json(Request $request){

        $data = $request->all();
   $temp = [];

    foreach ($data as $key => $val){

        if(!in_array($val,$temp)){
          array_push($temp,$val);
        }
      
    }
  
        return response()->json($temp, 200);
    }
    
}