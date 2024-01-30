<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\likesDislikes;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function deletePost(Post $post){
        if(auth()->user()->id === $post['user_id']){
            $post->delete();
        }
        return redirect('/');
    }

    public function updatePost(Post $post, Request $request){
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'nullable | mimes:jpg,jpeg,png,bmp,tiff,mp4,ogg,webm'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/users/', $filename);
            $incomingFields['image'] = $filename;
        }

        $post->update($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Post $post){
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'nullable | mimes:jpg,jpeg,png,bmp,tiff,mp4,ogg,webm'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/users/', $filename);
            $incomingFields['image'] = $filename;
        }
        $incomingFields['likes'] = 0;
        $incomingFields['dislikes'] = 0;
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);
        return redirect('/')->with('success','Post created!');
    }

    public function postLike(Request $request) {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if(!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like){
                $like->delete();
                return null;
            }
        }else{
            $like = new likesDislikes();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if($update){
            $like->update();
        }else{
            $like->save();
        }
        return null;
    }

    public function postDislike(Request $request) {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'false';
        $update = false;
        $post = Post::find($post_id);
        if(!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like){
                $like->delete();
                return null;
            }
        }else{
            $like = new likesDislikes();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if($update){
            $like->update();
        }else{
            $like->save();
        }
        return null;
    }
}
