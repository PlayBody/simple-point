<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class UserController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * Response all data
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->roles;
        }
        return response()->json([
            'message' => 'success',
            'users' => $users
        ], 200);
    }

    public function getAllBusinesses()
    {
        $users = User::all();
        $businesses = [];
        foreach ($users as $user) {
            $user->roles;
            if ($user->roles[0]->name == 'Business') {
                array_push($businesses, $user);
            }
        }
        return response()->json([
            'message' => 'success',
            'businesses' => $businesses
        ], 200);
    }

    /**
     * Response one data by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, $userId)
    {
        $user = User::find($userId);
        $user->roles;

        return response()->json([
            'message' => 'success',
            'user' => $user,
        ], 200);
    }

    /**
     * Create new data
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'company' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|confirmed|min:8|max:16',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        
        $role = Role::where('name', $request->role)->first();
        $roleIds = [];
        array_push($roleIds, $role->id);
        $user->roles()->attach($roleIds);

        return response()->json([
            'message' => 'success',
            'user' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Update user
        $request->validate([
            'name' => 'required|string',
            'company' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|max:100',
            'password' => 'confirmed',
            'role' => 'required',
        ]);
        $user = User::find($request->id);
        if ($request->password) {
            $user -> update([
                'password' => bcrypt($request->password),
                'name' => $request->name,
                'company' => $request->company,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        } else {
            $user -> update([
                'name' => $request->name,
                'company' => $request->company,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        }

        $role = Role::where('name', $request->role)->first();
        $roleIds = [];
        array_push($roleIds, $role->id);
        $user->roles()->sync($roleIds);

        return response()->json([
            'message' => 'success',
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $userId)
    {
        //delete User
        $user = User::find($userId);
        $user -> delete();

        $users = User::all();
        foreach ($users as $user) {
            $user->roles;
        }
        return response()->json([
            'message' => 'success',
            'users' => $users
        ], 200);
    }
}
