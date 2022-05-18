<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Notification;
use App\Notifications\AlertNotification;
use Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = request(['email', 'password']);
 
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->createNewToken($token);
        
        // $users = User::where('email', $request->email)->get();
        // if (count($users) > 0) {
        //     $user = $users[0];
        //     if (! $token = auth()->attempt($validator->validated())) {
        //         return response()->json(['error' => 'Password is invalid'], 401);
        //     }
        //     return $this->createNewToken($token);
        // } else {
        //     return response()->json(['error' => 'Email is invalid'], 401);
        // }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'company' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|max:100|unique:users',
            // 'password' => 'required|confirmed|min:8|max:16',
            'password' => 'required|min:8|max:16',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        $user->roles()->attach([2]);    // Default role is client on registration

        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];
  
        // Notification::send($user, new AlertNotification($details));

        return response()->json([
            'message' => 'success',
            'user' => $user
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            // 'password' => 'required|confirmed|min:8|max:16',
            'password' => 'required|min:8|max:16',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $users = User::where('email', $request->email)->get();
        if (count($users) > 0) {
            $user = $users[0];
            $user -> update([
                'password' => bcrypt($request->password),
            ]);
        } else {
            return response()->json([
                'message' => 'Such email not exists',
            ], 401);
        }
        return response()->json([
            'message' => 'success',
            'user' => $user
        ], 200);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        auth()->user()->roles;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60000,
            'user' => auth()->user()
        ]);
    }

    /**
     * Get auth user
     * 
     * @return App\Models\User
     */
    public function auth() {
        // return response()->json('date');
        return response()->json(auth()->user());
    }
}
