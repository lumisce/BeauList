@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<h2>My Profile</h2>
			<div class="card">
				<div class="card-header">
					{{Auth::user()->name}}
				</div>
				<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
					<a href="{{route('users.currentproducts', Auth::user()->id)}}" class="list-group-item">Currently Using Products</a>
					<a href="{{route('users.wishlist', Auth::user()->id)}}" class="list-group-item">Wishlist</a>
					<a href="{{route('users.ratedproducts', Auth::user()->id)}}" class="list-group-item">Rated Products</a>
					<a href="{{route('users.favproducts', Auth::user()->id)}}" class="list-group-item">Favorite Products</a>
					<a href="{{route('users.favbrands', Auth::user()->id)}}" class="list-group-item">Favorite Brands</a>
					<a href="{{route('users.savedlists', Auth::user()->id)}}" class="list-group-item">Saved Lists</a>
				</div>
			</div>

			<div class="card mt-2">
				<div class="card-header">
					<ul class="nav nav-pills card-header-pills justify-content-right" style="margin-bottom:-1rem;">
						<li class="nav-item" style=""><p class="nav-link">{{__('My Lists')}}</p></li>
						<li class="nav-item ml-auto">
							<a class="nav-link active" href="{{route('lists.create')}}">Add</a>
						</li>
					</ul>
				</div>
				<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
					@foreach (Auth::user()->blists as $item)
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
