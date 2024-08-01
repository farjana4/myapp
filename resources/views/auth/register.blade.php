@extends('layout')

@section('main')
  <h1 class="title">Register a new account</h1>
  <div class="mx-auto max-w-screen-sm card">
    <form action="{{route('register')}}" method="post" x-data="formSubmit" @submit.prevent="submit">
      @csrf
      <!-- username -->
      <div class="mb-4">
        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
        <div class="mt-2">
            <input type="text" name="username" id="username" value="{{old('username')}}" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 
            @error('username') ring-red-500 @enderror">

            @error('username')
              <p class="error">{{ $message }}</p>
            @enderror
        </div>
      </div>
      <!-- email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
        <div class="mt-2">
            <input type="text" name="email" id="email" value="{{old('email')}}" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
            @error('email') ring-red-500 @enderror">

            @error('email')
              <p class="error">{{ $message }}</p>
            @enderror
        </div>
      </div>
      <!-- password -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
        <div class="mt-2">
            <input type="password" name="password" id="password" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
            @error('password') ring-red-500 @enderror">

            @error('password')
              <p class="error">{{ $message }}</p>
            @enderror
        </div>
      </div>
      <!-- Confirm password -->
      <div class="mb-8">
        <label for="conform password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
        <div class="mt-2">
            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
            @error('password') ring-red-500 @enderror">
        </div>
      </div>

      <div class="mb-4">
        <input type="checkbox" name="subscribe" id="subscribe">
        <label for="subscribe">Subscribe to our newsletter</label>
      </div>

      <!-- submit Button -->
      <button x-ref="btn" class="btn">Register</button>
    </form>
  </div>
  
@endsection