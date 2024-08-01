@extends('layout')

@section('main')
    <h1 class="title">Single Posts</h1>
    <div class="grid grid-cols-2 gap-6">
      <div class="card">
        <!-- Title -->
        <h2 class="font-bold text-xl">{{ $post->title }}</h2>
        <!-- Author and Date -->
        <div class="text-xs font-light mb-4">
            <span>Posted {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}} by</span>
            <a href="{{route('posts.user', $post->user_id)}}" class="text-blue-500 font-medium">{{$post->username}}</a>
        </div>
        <!-- Body -->
        <div class="text-sm">
          <span>{{ $post->body }}</span>
        </div>
      </div>
    </div>
    
@endsection