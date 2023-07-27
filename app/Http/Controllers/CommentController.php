<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function index(string $postID){
        $comments =Comment::where('postID',$postID)->get();
        return $comments;
    }
    public function store(Request $request,string $postID){
        $request->validate([
            'content'=>'required|string'
        ]);
        $comment = Comment::create([
            'content'=>$request->content,
            'userID'=>$request->user()->id,
            'postID'=>$postID
        ]);

        return response()->json([
            'message'=>'comment created successfully',
            'comment'=>$comment

        ],201);


    }
    public function update(Request $request,string $postID,string $id){
            $comment =Comment::findOrFail($id);
            if($comment->userID != $request->user()->id){
                return response()->json([
                    'message'=>'you aren\'t authorized'
                ],403);
            }
            $updated = $comment->update($request->all());
            if($updated){
                return response()->json([
                    'message'=>'comment updated successfully'
                ],206);
            }
            return response()->json([
                'message'=>'Fail'
            ],400);

    }
    public function delete(string $postID,string $id){
        $comment =Comment::findOrFail($id);
        if($comment->userID != Auth::user()->id){
            return response()->json([
                'message'=>'you aren\'t authorized'
            ],403);
        }
        $comment->delete();
        return response()->json([
            'message'=>'delete comment successfully'
        ],204);
    }

}