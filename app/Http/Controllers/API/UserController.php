<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Throwable;
use App\Http\Controllers\API\BaseController;

class UserController extends BaseController {
    //Creating new user
    public function register(Request $req) {
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'roles' => 'required|array',
                'confirm_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }
            $email = User::where('email', $req->email)->first();
            if($email) { 
                return $this->sendError('Email is already exists. Please try again');
            }
            
            $input = $req->all();
            $input['password'] = bcrypt($input['password']);
            $new_user = User::create($input);
            $new_user->roles()->attach($req->roles);
            $success['token'] = $new_user->createToken('auth_token')->plainTextToken;
            $success['fullName'] = $new_user->name;

            return $this->sendResponse($success, 'User register successfully.');
        } catch (Throwable $err) {
            return $this->sendError('Server error', $err->getMessage(), 500);
        }
    }
    // 
    public function login(Request $req) {
        try {
            //Validate the data entry
            $validator = Validator::make($req->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }
            if (!Auth::attempt($req->only(['email', 'password']))) {
                return $this->sendError('Incorrect username or password, Please try it again',[],400);
            }
            $user = User::where('email', $req->email)->first();
            $success['token'] = $user->createToken('auth_token')->plainTextToken;
            $success['fullName'] = $user->name;
            return $this->sendResponse($success, 'User login successfully');
        } catch (Throwable $err) {
            return $this->sendError('Server error', $err->getMessage(), 500);
        }
    }

    // Get All Users
    public function users() { 
        return User::with('roles')->get();
    }
}
