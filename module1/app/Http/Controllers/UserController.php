<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request -> all();
        $validation = Validator::make($data, [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validation->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validation->errors()
                ]
            ]);
        }
        $model = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password']
        ];
        User::create($model);
        return response()->json([

        ], 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'username'=> 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ]);
        }
        $user = User::where(['username' => $data['username'], 'password'=>$data['password']])->first();
        if(!$user){
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'error' => [
                        'phone' => 'phone or password incorrect'
                    ]
                ]
            ], 401);
        }
        $user  ->update([
            'api_token' => Str::random(60)
        ]);
        return response()->json([
            'data' => [
                'token' => $user->api_token
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->update([
            'api_token'=> null
        ]);

        return response()->json([
            'data' => [
                'message' => 'logout'
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
