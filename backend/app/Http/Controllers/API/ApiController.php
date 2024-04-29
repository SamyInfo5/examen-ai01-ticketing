<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            "name"=>"required",
            "role_id"=>"required",
            "email"=>"required|email|unique:users",
            "password"=>"required",
        ]);

        User::create([
            "name"=> $request-> name,
            "role_id"=>$request->role_id,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
        ]);

        return response() ->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }
    public function login(Request $request) {
        $request->validate([
            "name" => "required",
            "password" => "required"
        ]);

        $user = User::where("name", $request->name)->first();

        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("myToken")->plainTextToken;
                return response()->json([
                    "status"=>true,
                    "message"=>"Login successfully",
                    "token"=> $token
                ]);
            }

            return response()->json([
                "status"=>false,
                "message"=>"password incorrect"
            ]);
        }
        return response()->json([
            "status"=> false,
            "message"=>"invalid login or password"
        ]);
    }
    public function profile() {
        $data = auth()->user();
        return response()->json([
            "status"=>true,
            "message"=>"profile data",
            "user"=>$data
        ]);
    }
    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
            "status"=>true,
            "message"=>"user logout",
        ]);
    }
}
