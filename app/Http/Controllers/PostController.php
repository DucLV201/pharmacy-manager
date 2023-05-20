<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCate;

class PostController extends Controller
{
    public  function post(){
        $categories = Category::all();
        $postcates = PostCate::all();
        $all_post = Post::join('post_cates','posts.id_cate','=','post_cates.id')
        ->select('posts.id', 'posts.id_cate', 'posts.title', 'posts.img_title',DB::raw("SUBSTRING(posts.description, 1, 300) as description"), 'post_cates.title as cate_name')->get();
        $randomPosts1 = $all_post->random(1);
        $randomPosts5 = $all_post->random(5);


        //dd($randomPosts);
        return view('user.post', ['categories' => $categories,'postcates'=>$postcates,'all_post'=>$all_post])
        ->with('all_post1',$randomPosts1)
        ->with('all_post5',$randomPosts5);
    }
    public  function post_cate($id){
        $categories = Category::all();
        $postcates = PostCate::where('post_cates.id','=',$id)->get();
        $all_post = Post::join('post_cates','posts.id_cate','=','post_cates.id')
        ->where('posts.id_cate','=',$id)
        ->select('posts.id', 'posts.id_cate', 'posts.title', 'posts.img_title',DB::raw("SUBSTRING(posts.description, 1, 300) as description"), 'post_cates.title as cate_name')->get();
        $randomPosts1 = $all_post->random(1);
        $randomPosts5 = $all_post->random(5);
        //dd($randomPosts);
        return view('user.post_cate', ['categories' => $categories,'postcates'=>$postcates,'all_post'=>$all_post])
        ->with('all_post1',$randomPosts1)->with('all_post5',$randomPosts5);
    }
    public  function post_details($id){
        $categories = Category::all();
        $postcates = PostCate::where('post_cates.id','=',$id)->get();
        $all_post = Post::join('post_cates','posts.id_cate','=','post_cates.id')
        ->where('posts.id','=',$id)
        ->select('posts.id', 'posts.title','posts.description')->get();

        //dd($randomPosts);
        return view('user.post_details', ['categories' => $categories,'all_post'=>$all_post]);
        
    }
}
