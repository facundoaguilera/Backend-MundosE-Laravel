<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::get();
        return $comments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:comments|max:255',
            'email' => 'required|unique:comments|max:150',
            'phone'=>'required',
            'comment'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }else {

                //Creo el comentario en la BD
            $comments = new Comment();
            $comments->name = $request->name;
            $comments->email = $request->email;
            $comments->phone = $request->phone;
            $comments->comment = $request->comment;

            //dd ($comments);

            $comments->save();
        }

        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Comment created',
            'data' => $comments,
        ], Response::HTTP_OK);
        
        
        \Mail::to('example@example.com')->send(new \App\Mail\sendContact($details));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Comment $comment)
    {

        $comment=Comment::findOrFail($request->id);

        $comments = $request->validate([
            'name' => 'required|max:150|unique:comments,name,'.$comment->id,
            'email' => 'required|max:150|unique:comments,email,'.$comment->id,
            'phone'=>'required',
            'comment'=>'required'
        ]);

        

        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->phone = $request->phone;
        $comment->comment = $request->comment;
        
        //dd($comment);
        
        $comment->save();
        

        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Comment created',
            'data' => $comments,
        ], Response::HTTP_OK);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $comments=Comment::destroy($request->id);
        return $comments;
    }
}
