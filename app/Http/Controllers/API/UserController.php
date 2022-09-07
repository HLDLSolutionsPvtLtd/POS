<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
            $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ]);
            
            $user = User::where('email', $request->email)->first();
            
            if (! $user || ! Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'error' => "The provided credentials are incorrect."
                    ]);
                    // throw ValidationException::withMessages([
                    //     'email' => ['The provided credentials are incorrect.'],
                    // ]);
                }

            // First check if a token already exists, remove it, and get a new
            // one.
            if ($user->tokens->count()) {
                $user->tokens->first()->delete();
            }
            $roles = $user->roles()->pluck('name');
            $permisiion = $user->permissions()->pluck('name');
            $store = Store::where('name', $permisiion[0])->first();
            $token = $user->createToken($request->email)->plainTextToken;
            return response()->json([
                'data' => [
                    'token' =>  $token,
                    'user'  =>  $user,
                    'role'  =>  $roles[0],
                    'store' =>  $store->id
                ],
                'message' => 'Login Success',
                'errors' => '',
            ]);
    }
}
