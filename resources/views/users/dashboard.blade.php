@extends('layout')

@section('main')

    <h1 class="title">Welcome {{ auth()->user()->username }} you have {{$posts->total()}} posts</h1>
 
    <!-- create post form  -->
    <div class="card mb-4">
       <h2 class="font-bold mb-4">Create a new post</h2> 
        
        <!-- Session Messages -->
        @if(session('success'))
       <div class="bg-green-500">
           <p class="text-white-900"> {{session('success')}} </p>
       </div>
       @elseif(session('delete'))
       <div class="bg-red-500">
           <p class="text-white-900"> {{session('delete')}} </p>
       </div>
       @endif

        <form action="{{ route('posts.store' )}}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Post title -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
            <div class="mt-2">
                <input type="text" name="title" id="title" value="{{old('title')}}" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                @error('title') ring-red-500 @enderror">

                @error('title')
                  <p class="error">{{ $message }}</p>
                @enderror
            </div>
          </div>

          <!-- Post Body -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Post Content</label>
            <div class="mt-2">
                <textarea name="body" rows="5" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                @error('title') ring-red-500 @enderror">{{old('body')}}</textarea>

                @error('body')
                  <p class="error">{{ $message }}</p>
                @enderror
            </div>
          </div>

          <!-- Post image -->
          <div class="mb-4">
            <label for="image">Cover photo</label>
            <input type="file" name="image" id="image">

              @error('image')
                <p class="error">{{ $message }}</p>
              @enderror
          </div>

          <button class="btn">create</button>
        </form>
    </div>

    <!-- User Posts -->
    <h2 class="font-bold mb-4">Your Latest Posts</h2>
    <div class="grid grid-cols-2 gap-6">
      @foreach($posts as $post)
      <div class="card">

        <!-- Cover photo -->
        <div class="h-52 rounded-md mb-4 w-full object-cover overflow-hidden">
          @if($post->image)
          <img src="{{asset('storage/'.$post->image)}}" alt="">
        @else
        <img src="{{asset('storage/posts_images/default.jpeg')}}" alt="">
        </div>
        @endif
        
      </div>
        

        <!-- Title -->
      <h2 class="font-bold text-xl">{{ $post->title }}</h2>
      <!-- Author and Date -->
      <div class="text-xs font-light mb-4">
          <span>Posted {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}} by</span>

          <a href="{{route('posts.user', $post->id)}}" class="text-blue-500 font-medium">{{$post->username}}</a>
      </div>
      <!-- Body -->
      <div class="text-sm">
        <p>{{ Str::words($post->body, 25) }}</p>
      </div>

        <a href="{{route('posts.edit', $post->id)}}" class="bg-green-500 text-white px-2 puy-1 text-xs rounded-md">Update</a>

        <div class="flex items-center justify-end gap-4 mt-6">
          <form action="{{route('posts.destroy', $post->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-2 puy-1 text-xs rounded-md">Delete</button>
          </form>
        </div>
      </div>
    @endforeach
    </div>
      {{$posts->render()}}
    <div>
        
    </div>

@endsection