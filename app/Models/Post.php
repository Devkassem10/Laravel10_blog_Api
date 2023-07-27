<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image',
        'userID'
    ];
    protected $appends = [
        'author_name'
    ];
    public function author()
    {
    //    $userID = $this->original['userID'];
    //    return User::find($userID)->first();

         return $this->belongsTo(User::class,'userID','id');
    }
    public function getAuthorNameAttribute(){
        // $userID = $this->original['userID'];
        // $user = User::find($userID)->first();

        // return [
        //     'id'=>$user->id,
        //     'name'=>$user->name
        // ];
        return $this->author->name;
    }



}
