@extends('layout')

@section('main')
  <h1 class="title">Login your account</h1>

  <!-- Session Messages -->
    @if(session('status'))
   <div class="bg-green-500">
       <p class="text-white-900"> {{session('status')}} </p>
   </div>
   @endif
   
  <div class="mx-auto max-w-screen-sm card">
    <form action="{{route('login')}}" method="post">
      @csrf
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
        <!-- remember checkbox -->
        <div class="mb-4 flex justify-between items-center">
          <div>
            <input type="checkbox" name="remember" id=rememeber>
          <label for="remember">Remember me</label>
          </div>
        
          <a class="text-blue" href="{{route('password.request')}}">Forgot your password</a>
        </div>

        @error('failed')
              <p class="error">{{ $message }}</p>
            @enderror
      </div>
      <button class="btn">Login</button>
    </form>
  </div>
  
@endsection