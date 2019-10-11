<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\RegisterFormRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','all','update','destroy']]);
    }

    public function all()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ],200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $oldDirectory =  public_path() . '/images/label_images/' . $user->id . '-' . $user->firstname;
        $this->deleteFiles($oldDirectory);

        $user->delete();

        return response()->json([
            'user' => $user
        ],200);
    }

    private function uploadImage($image){
        $exploded = explode(',',$image);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg'))
        {
            $extesion = 'jpg';
        }
        else
        {
            $extesion = 'png';
        }
            //
        $fileName = str_random().'.'.$extesion;

        $path = public_path().'/images/employees/'.$fileName;

        file_put_contents($path,$decoded);

        return $fileName;
    }
    private function deleteFiles($directory)
    {
        
        array_map('unlink', glob("$directory/*.*"));

        if(rmdir($directory)){
            echo "sucessfully deleted";
        }
        else{
            echo "failed to delete";
        }
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $path =  public_path() . '/images/employees/' . $user->profile_pic;
        unlink($path);
        $fileName = $this->uploadImage($request->profile_pic);
        $oldDirectory =  public_path() . '/images/label_images/' . $user->id . '-' . $user->firstname;
        $user->firstname = $request->firstname;
        $user->middleinitial = $request->middleinitial;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->city = $request->city;
        $user->landmark = $request->landmark;
        $user->zip = $request->zip;
        $user->profile_pic = $fileName;
        $user->position = $request->position;
        $user->save();

        $directory =  public_path() . '/images/label_images/' . $user->id . '-' . $user->firstname;
        
        if(file_exists($directory)){
            echo "Error While Renaming $directory" ;
        }
        else{
            if(rename($oldDirectory,$directory)){
                echo "Sucessfully renaming old directory";
            }else{
                echo "Failed to rename";
            }
        }
        return response()->json([
            'user' => $user
        ],200);
    }
/**
  * Get a JWT via given credentials.
  *
  * @return \Illuminate\Http\JsonResponse
  */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
 /**
  * Get the authenticated User.
  *
  * @return \Illuminate\Http\JsonResponse
  */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function register(Request $request)
    {
        
        $exploded = explode(',',$request->profile_pic);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg'))
        {
            $extesion = 'jpg';
        }
        else
        {
            $extesion = 'png';
        }
            //
        $fileName = str_random().'.'.$extesion;

        $path = public_path().'/images/employees/'.$fileName;

        file_put_contents($path,$decoded);
        $user = new User();
        $user->firstname = $request->firstname;
        $user->middleinitial = $request->middleinitial;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->city = $request->city;
        $user->landmark = $request->landmark;
        $user->zip = $request->zip;
        $user->profile_pic = $fileName;
        $user->position = $request->position;
        $user->save();

        $schedule = Schedule::create(['user_id' => $user->id,'start_time' => $request->start_time ,'end_time' => $request->end_time]);

        $user->schedule = $schedule;

        $directory =  public_path() . '/images/label_images/' . $user->id . '-' . $user->firstname;

            File::makeDirectory($directory,0777,true);

            $images = $request->images;

            $i = 1;
            foreach ($images as $img) {
                // code
                $exploded = explode(',',$img);

                $decoded = base64_decode($exploded[1]);

                if(str_contains($exploded[0],'jpeg')){
                    $extesion = 'jpg';
                }
                else{
                    $extesion = 'png';
                }
                //
                $fileName = $i.'.'.$extesion;

                $path = $directory . '/' . $fileName;
                
                file_put_contents($path,$decoded);

                $i++;
            }


            return response()->json([
                'employee' => $user,
                'directory' => $directory,
                'path' => $path,
                'public' => public_path()
            ],200);
    }
/**
  * Log the user out (Invalidate the token).
  *
  * @return \Illuminate\Http\JsonResponse
  */
 public function logout()
 {
     auth('api')->logout();
     return response()->json(['message' => 'Successfully logged out']);
 }
 /**
  * Refresh a token.
  *
  * @return \Illuminate\Http\JsonResponse
  */
 public function refresh()
 {
     return $this->respondWithToken(auth('api')->refresh());
 }
 /**
  * Get the token array structure.
  *
  * @param  string $token
  *
  * @return \Illuminate\Http\JsonResponse
  */
 protected function respondWithToken($token)
 {
     return response()->json([
         'access_token' => $token,
         'user' => $this->guard()->user(),
         'token_type' => 'bearer',
         'expires_in' => auth('api')->factory()->getTTL() * 60
     ]);
 }
 public function guard() {
     return \Auth::Guard('api');
 }
}
