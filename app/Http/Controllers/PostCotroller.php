<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'content'=>'required|string',
            'image'=>'required|image| mimes:png,jpg|max:2048'
        ]);
        // upload image to server
        $fullname=$request->file('image')->getClientOriginalName();
        $imageName = explode('.',$fullname)[0].time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        // image has been uploaded

        $post = Post::create([
            'title'=>$request->title,
            'content'=>$request->content,
            'image'=>$imageName,
            'userID' =>$request->user()->id
        ]);

        return response()->json([
            'message'=>'post created successfully',
            'post'=>$post

        ],201);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::where('id',$id)->first();
        return response()->json([
            'post'=>$post,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        if($post->userID != $request->user()->id ){
            return response()->json([
                'message'=>'you aren\'t authorized'
            ],403);
        }
        $updated = $post->update($request->all());
        if($updated){
            return [
                'message'=>'updated successfully',
            ];
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if($post->userID != Auth::user()->id ){
            return response()->json([
                'message'=>'you aren\'t authorized'
            ],403);
        }
        $post->delete();
        return [
            'message'=>'delete record successfully'
        ];

   }
}
