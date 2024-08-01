@extends('layout')

@section('main')
	
	<a href="{{route('dashboard')}}" class="block mb-2 text-xs text-blue-500">&larr; Go back to your dashboard</a>

	<div class="card">
		<h2 class="font-bold mb-4">Update your post</h2>

		<form action="{{ route('posts.update', $post->id )}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Post title -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
        <div class="mt-2">
            <input type="text" name="title" id="title" value="{{$post->title}}" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
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
            @error('title') ring-red-500 @enderror">{{$post->body}}</textarea>

            @error('body')
              <p class="error">{{ $message }}</p>
            @enderror
        </div>
      </div>

      <!-- Current Cover photo if exists -->
          @if($post->image)
            <div class="h-52 rounded-md mb-4 w-1/4 object-cover overflow-hidden">
              <label>Current Cover Photo</label>
              <img src="{{asset('storage/'.$post->image)}}" alt="">
            </div>
          @endif

          <!-- Post image -->
          <div class="mb-4">
            <label for="image">Cover photo</label>
            <input type="file" name="image" id="image">

              @error('image')
                <p class="error">{{ $message }}</p>
              @enderror
          </div>
        

      <!-- submit button -->
      <button class="btn">Update</button>
    </form>
</div>
	
@endsection