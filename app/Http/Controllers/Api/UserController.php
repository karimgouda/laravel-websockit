<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return response()->json([
            'users'=>$users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'=>'required|string:min:3|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);
        if ($validation->fails()){
            return response()->json([
                'status'=>400,
                'message'=>'validation Error',
                'errors'=> $validation->errors()
            ]);
        }
        $user = User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);
        return response()->json([
            'status'=>200,
            'message'=>'create User Successfully',
            'user'=> $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'users'=>$user
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(),[
            'name'=>'required|string:min:3|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);

        if ($validation->fails()){
            return response()->json([
                'status'=>400,
                'message'=>'validation Error',
                'errors'=> $validation->errors()
            ]);
        }

        $user->update([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);

        return response()->json([
            'status'=>200,
            'message'=>'Update User Successfully',
            'user'=> $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
       $user->delete();
        return response()->json([
            'status' =>200,
            'message' =>'deleted successfully',
        ]);
    }
}
