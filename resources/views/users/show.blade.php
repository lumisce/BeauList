@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<h2>{{$user->name}}'s Profile</h2>
			<div class="card">
				<div class="card-header">
					{{$user->name}}
				</div>
				<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
					<a href="{{route('users.currentproducts', $user->id)}}" class="list-group-item">Currently Using Products</a>
					<a href="{{route('users.ratedproducts', $user->id)}}" class="list-group-item">Rated Products</a>
					<a href="{{route('users.favproducts', $user->id)}}" class="list-group-item">Favorite Products</a>
					<a href="{{route('users.favbrands', $user->id)}}" class="list-group-item">Favorite Brands</a>
					<a href="{{route('users.savedlists', $user->id)}}" class="list-group-item">Saved Lists</a>
				</div>
			</div>

			<div class="card mt-2">
				<div class="card-header">
					<ul class="nav nav-pills card-header-pills justify-content-right" style="margin-bottom:-1rem;">
						<li class="nav-item" style=""><p class="nav-link">{{__('Lists')}}</p></li>
					</ul>
				</div>
				<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
					@foreach ($user->blists as $item)
					@if ($loop->first)
						<a href="/lists/{{$item->id}}" class="list-group-item">{{$item->name}}</a>
					@else
						<a href="/lists/{{$item->id}}" class="list-group-item">{{$item->name}}</a>
					@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
