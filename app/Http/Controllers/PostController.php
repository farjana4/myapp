<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Mail\WelcomeMail;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware():array{
        return[
            //new Middleware('auth', only:['store', 'update']),
            new Middleware(['auth', 'verified'], except:['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //orm model
        /*$posts = Post::orderBy('created_at', 'desc')->get();*/
        //$posts = Post::latest()->paginate(6);
        //query builder
        $posts = DB::table('posts')
                ->select('users.username', 'posts.*')
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->paginate(6);
        //dd($posts);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {   
        try {
            //store image if exists
            $path = null;
            //store image if exists
            if($request->hasFile('image')){
                $path = Storage::disk('public')->put('posts_images', $request->image);
            }

            // number one style insertion
            /*$Post = new Post();
            $Post->user_id = Auth::user()->id;
            $Post->title = $request->title;
            $Post->body = $request->body;
            $Post->created_at = now();
            $Post->save();*/

            //number 2 style insertion
            $last_id = DB::table('posts')->insertGetId([
                'user_id' => Auth::user()->id, 
                'title' => $request->title,
                'body' => $request->body,
                'image' => $path,
                'created_at' => now()
            ]);

            //getting user latest post
            $latest_post = DB::table('posts')
                ->where('user_id', Auth::user()->id)
                ->where('id', $last_id)->first();

            //sending emails
            Mail::to(Auth::user()->email)->send(new WelcomeMail(Auth::user(), $latest_post));

            return back()->with('success', 'Your post was created');

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage);
            return redirect()->back();
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = DB::table('posts')
        ->select('users.username', 'posts.*')
        ->leftJoin('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.id', $id)->first();

        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = DB::table('posts')
        ->where('id', $id)->first();
//dd($post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        //path if exists
        //get image path
        $post = DB::table('posts')->select('image')->where('id', '=', $id)->first();

        //store image if exists
        $path = $post->image ?? null;
        //store image if exists
        if($request->hasFile('image')){
            if($post->image){
                Storage::disk('public')->delete($post->image);
            }

            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        DB::table('posts')
            ->where('id', $id)
            ->update([
                'title' => $request->title,
                'body' => $request->body,
                'image' => $path,
                'updated_at' => now()
            ]);
        return redirect()->route('dashboard')->with('success', 'Your post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //get image path
        $path = DB::table('posts')->select('image')->where('id', '=', $id)->first();

        //delete post if image exists
        if($path->image){
            Storage::disk('public')->delete($path->image);
        }

        //orm eluquent
        //Post::where('id',$id)->delete();
        //db query build
        DB::table('posts')->where('id', '=', $id)->delete(); 
        //redirect back to the dashboard
        return back()->with('delete', 'Your post was deleted!');
    }
}
