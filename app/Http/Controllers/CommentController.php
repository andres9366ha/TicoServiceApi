<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Collaborator;
use Illuminate\Http\Request;
use JWTAuth;
use DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        $response = [
            'comments' => $comments
        ];
        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $token)
    {

      $this->validate($request, [
            'comment' => 'required',
        ]);
      if($token == null){
          return response()->json(['message' => 'Error en registro de comentario', 'codigo' => 401]);
      }

      $user_comm = JWTAuth::toUser($token);

      $id_receive = $request->coll_id;

        if(!$user_comm || !$id_receive){
            return response()->json(['message' => 'Error en registro de comentario', 'codigo' => 401]);
        }

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->id_user_comm = $user_comm->id;
        $comment->id_user_collab = $id_receive;
        $comment->save();
        return response()->json(['comment' => $comment, 'codigo' => 201]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json(['message' => 'Comentario no existente'], 404);
        }
        return response()->json($comment,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->toUser();
        $comment = Comment::where('id_user_comm', $user->id)->first();
        if(!$comment->id_user_comm)
        {
            return response()->json(['message' => 'Comentario no existente'], 404);
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $comment->comment = $request['comment'];
        $comment->save();
        return response()->json(['comment' => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return response()->json(['message' => 'Comentario eliminado']);
    }
}
