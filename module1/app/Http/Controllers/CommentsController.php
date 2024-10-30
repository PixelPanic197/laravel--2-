<?php

namespace App\Http\Controllers;

use App\Models\CommentModel;
use App\Models\PostsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
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
    public function create(Request $request, $id)
    {
        $data = $request->all();
        $token = request()->bearerToken();
        $validation = Validator::make($data, [
            'text' => 'required',
            'author' => 'required',
            'date_time' => 'required'
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
        $user = User::where('api_token', $token)->get(['id', 'api_token'])->first();
        $post = PostsModel::where('id', $id)->get('date_pub')->first();

        if($token != $user and $token != null){
            $model = [
                'text' => $data['text'],
                'author' => $data['author'],
                'date_time' => $data['date_time'],
                'date_publish' => $post->date_pub,
                'id_user' => $user->id,
                'post_id' => $id,


            ];
            CommentModel::create($model);
            $last_id = CommentModel::where('text', $data['text'])->get('id')->last();
            return response()->json([
                'data' => [
                    'comment_content' => [
                        'text' => $data['text'],
                        'date_publish' => $post->date_pub,
                        'aurhor' => $data['author'],
                        'post_id' => $id,
                        'id' => $last_id->id
                    ]
                ]
            ]);
        }
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
    public function show(Request $request, $id, $idComment)
    {

        $data = $request->all();
        $validation = Validator::make($data, [

        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => [
                    'code' => '422',
                    'message' => 'Validation error',
                    'error' => $validation->errors()
                ]
            ], 422);
        }
        $comment = CommentModel::where('id', $idComment)->get(['text', 'date_publish', 'author', 'post_id', 'id'])->first();
        return response()->json([
            'data' => [
                'comment_content' => [
                    'text' => $comment->text,
                    'date_publish' => $comment->date_publish,
                    'aurhor' => $comment->author,
                    'post_id' => $comment->post_id,
                    'id' => $comment->id
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request, $idComment)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'text' => 'required',
            'author' => 'required',
            'date_time' => 'required'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => [
                    'code' => '422',
                    'message' => 'Validation error',
                    'error' => $validation->errors()
                ]
            ], 422);


        }
        $model = [
            'text' => $data['text'],
            'author' => $data['author'],
            'date_time' => $data['date_time']
        ];
        $comment = CommentModel::where('id', $idComment)->update($model);
        $full = CommentModel::where('id', $idComment)->get(['text', 'date_publish', 'author', 'post_id', 'id_user', 'id'])->first();
        return response()->json([
            'data' => [
                'comment_content' => [
                    'text' => $full->text,
                    'date_publish' => $full->date_publish,
                    'aurhor' => $full-> author,
                    'post_id'=> $full->post_id,
                    'id' => $full->id
                ]
            ]
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
    public function destroy(Request $request, $id, $idComment)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'text' => 'required',
            'author' => 'required',
            'date_time' => 'required'
        ]);
        $test = $id;
        if ($validation->fails()) {
            return response()->json([
                'error' => [
                    'code' => '422',
                    'message' => 'Validation error',
                    'error' => $validation->errors()
                ]
            ], 422);


        }
        $comment = CommentModel::where('id', $idComment)->get(['text', 'date_publish', 'author', 'post_id', 'id_user'])->first();
        $delete = CommentModel::where('id', $idComment)->first()->delete();
        $text = $comment->text;
        $date = $comment->date_publish;
        $aurhor = $comment->author;
        $post_id = $comment->post_id;
        $id_user = $comment->id_user;
        return response()->json([
            'data' => [
                'comment_content' => [
                    'text' => $text,
                    'date_publish' => $date,
                    'aurhor' => $aurhor,
                    'post_id' => $post_id,
                    'id_user' => $id_user
                ]
            ]
        ]);
    }
}
