<h1>Hello {{$user->username}}</h1>

<div>
	<h2>You created {{$latest_post->title}}</h2>
	<p>{{$latest_post->body}}

	@if($latest_post->image!==null)
	<img width="300" src="{{$message->embed('storage/'.$latest_post->image)}}" alt="">
	@endif
</div>

