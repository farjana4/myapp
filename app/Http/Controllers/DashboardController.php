<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        //orm model
        /*$posts = Post::where('user_id', Auth::id())->latest()->paginate(6);*/

        //query builder
        $posts = DB::table('posts')->where('user_id', Auth::id())
                ->select('users.username', 'posts.*')
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->paginate(6);
        //dd($posts);
        return view('users.dashboard', ['posts' => $posts]);
    }

    public function userPosts(Request $request, $id){
        $userData = DB::table('users')
        ->select('users.username')
        ->where('id', $id)->first();

        $posts = DB::table('posts')
        ->select('users.username', 'posts.*')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')
        ->where('user_id', $id)->paginate(6);
        return view('users.posts', ['posts' => $posts, 'userData' => $userData]);
    }
}
