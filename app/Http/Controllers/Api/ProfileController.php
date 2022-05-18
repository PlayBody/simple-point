<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ProfileController extends Controller
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
    public function index()
    {
        // $user = auth('api')->user();
        $user = Auth::user();
        
        return response()->json([
            'message' => 'success',
            'user' => $user,
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
            // 'password' => 'confirmed',
        ]);

        $user = User::find($request->id);
        // $user = auth()->user();
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

        return response()->json([
            'message' => 'success',
            'user' => $user
        ], 200);
    }
}
