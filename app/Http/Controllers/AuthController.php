<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if(!$user->canany(['manage all users', 'manage users'])) abort(403);
        
        $result = [];

        $result['roles'] = Role::all();
        
        $result['users'] = UserResource::collection(User::all());

        return response()->json(['result' => $result], 200);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function update(User $user, Request $request)
    {
        $logingUser = auth()->user();
        
        if( ! $request->has('type') ) {
            if( ! $logingUser->canany(['manage all users', 'manage users']) ) abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if($request->email != $user->email) {
            $request->validate([
                'email' => 'required|email|unique:users'
            ]);
            $user->email = $request->email;
        }

        if($request->username != $user->username) {
            $request->validate([
                'username' => 'required|unique:users'
            ]);
            $user->username = $request->username;
        }

        if($request->has('password') && @$request->password) {
            $validatedPass = $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user->password = Hash::make($validatedPass['password']);
        }

        $user->name = $validatedData['name'];


        if($user->save()) {
            if(! $request->has('type')) {
                $user->syncRoles($request->role);
                return $this->index();
            } else {
                return new UserResource($user);
            }
        }

        return response()->json(['message' => 'Invalid submitted details'], 400);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                'token' => $token,
                'user' => new UserResource($user)
        ]);
    }
}
