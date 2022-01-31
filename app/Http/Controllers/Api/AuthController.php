<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        
    
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'document_number' => 'required|string|unique:users|digits_between:10,10',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator);
        }
     

        // Retrieve the validated input...
        $validated = $validator->validated();

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return response(null, 204);
    }

    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator);
        }

        $validated = $validator->validated();

        if (Auth::attempt($validated)) {
          $token = Str::random(80);

          $request->user()->api_token = $token;
          $request->user()->save();

          return response()->json(['token' => $token]);
        }

        $data = [
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'errors' => [
                    'phone' => 'phone or password incorrect'
                ]
            ]
        ];

        return response()->json($data, 422);
        
    }
}
