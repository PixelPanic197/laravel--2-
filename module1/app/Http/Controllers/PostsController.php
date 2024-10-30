<?php

namespace App\Http\Controllers;

use App\Models\PostsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
//        $data = $request->get('postname');
//        $post = PostsModel::where('title', $data)->get(['title', 'text_post', 'date_pub', 'id'])->first();
//        $title = $post->title;
//        if($title != ''){
//            return response()->json([
//                'data' => [
//                    'title' => $post->title,
//                    'text_post' => $post->text_post,
//                    'date_pub' => $post->date_pub,
//                    'id' => $post -> id
//                ]
//            ]);
//        }else if($title == ''){
//            return response()->json([
//                'posts' => []
//            ]);
//        }
        $test = $request->query('postname');
        return response()->json([
                'data' => [
                    'title' => $test['postname'],

                ]
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request -> all();
        $token = request()->bearerToken();

        $validator = Validator::make($data, [
            'title' => 'required',
            'text_post' => 'required',
            'date_pub' => 'required'
        ]);
        if($validator->fails()){
            return response()-> json([
                'error' => [
                    'code' => '422',
                    'message' => 'Validation error',
                    'error' => $validator->errors()
                ]
            ],422);

        };
        $whereUser = User::where('api_token', $token) -> get('api_token');
        $jsontoken = $whereUser[0] -> api_token;


        if($jsontoken == $token and $jsontoken != null){
            $id_user = User::where('api_token', $token)->get('id');
            $id_us = $id_user[0]-> id ;

            $model = [
                'title' => $data['title'],
                'text_post' => $data['text_post'],
                'date_pub' => $data['date_pub'],
                'id_user' => $id_us
            ];
            PostsModel::create($model);
            $id = DB::table('posts')->get('id')->last()-> id;


            return response() -> json([
                'data' => [
                    'title' => $data['title'],
                    'text_post' => $data['text_post'],
                    'date_pub' => $data['date_pub'],
                    'id' => $id

                ]
            ], 201);
        };
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_last = PostsModel::where('id', $id)->get(['title', 'text_post', 'date_pub', 'id']);
        $title = $id_last[0] -> title;
        $text_post = $id_last[0] -> text_post;
        $date_pub = $id_last[0] -> date_pub;
        $id = $id_last[0] -> id;
        return response()->json([
            'data' => [
                'title' => $title,
                'text_post' => $text_post,
                'date_pub' => $date_pub,
                'id' => $id
            ]
        ],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $data = $request->all();
        $validation = Validator::make($data,[
            'title' => 'required',
            'text_post' => 'required',
            'date_pub' => 'required'
        ]);
        if($validation->fails()){
            return response()-> json([
                'error' => [
                    'code' => '422',
                    'message' => 'Validation error',
                    'error' => $validation->errors()
                ]
            ],422);
        }

        $posts = PostsModel::where('id', $id)->get(['title', 'id', 'date_pub', 'text_post'])->first();
        $model = [
            'title' => $data['title'],
            'text_post' => $data['text_post'],
            'date_pub' => $data['date_pub']
        ];
        $posts->update($model);
        return response()->json([
            'title' => $data['title'],
            'text_post' => $data['text_post'],
            'date_pub' => $data['date_pub'],
            'id' => $posts->id
        ]);
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
        $post = PostsModel::where('id', $id)->get('id')->first();
        $post->delete();
        return response()->json([
            'data' => [
                'message' => 'Пост удален'
            ]
        ]);
    }
}
