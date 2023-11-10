<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
   
    public function index()
    {
        $users = User::all();
        if($users->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'users' => $users
            ], 200);

        }else{

            return response()->json([
                'status' => 404,
                'message' => "No records found"
            ], 404);
        }

    }

    public function show($id)
    {
        $user = User::find($id);
        if($user)
        {
            return response()->json([
                'status' => 200,
                'user' => $user
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No user found"
            ], 404);
        }
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'name' => 'required|string|max:191',
                'email' => 'required|string|max:191',
                'password' => 'required|string|max:191',
                'role' => 'Integer|max:19',
                'currency' => 'Integer|max:191'
            ]
        );
        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email; 
            $user->password = $request->password;
            $user->role = $request->role;
            $user->currency = $request->currency;
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => "User created successfully"
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user)
        {
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|string|max:191',
                    'email' => 'required|string|max:191',
                    'password' => 'required|string|max:191',
                    'role' => 'Integer|max:19',
                    'currency' => 'Integer|191'
                ]
            );
            if($validator->fails())
            {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ], 422);
            }
            else{
                $user->name = $request->name;
                $user->email = $request->email; 
                $user->password = $request->password;
                $user->role = $request->role;
                $user->currency = $request->currency;
                $user->save();
                return response()->json([
                    'status' => 200,
                    'message' => "User updated successfully"
                ], 200);
            }
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No user found"
            ], 404);
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => "User deleted successfully"
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No user found"
            ], 404);
        }
    }


}
