@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<h2>My Profile</h2>
			<div class="card">
				<div class="card-header">
					<ul class="nav nav-pills card-header-pills justify-content-right" style="margin-bottom:-1rem;">
						<li class="nav-item" style=""><p class="nav-link">{{__('Lists')}}</p></li>
						<li class="nav-item ml-auto">
							<a class="nav-link active" href="{{route('lists.create')}}">Add</a>
						</li>
					</ul>
				</div>
					<div class="list-group list-group-flush" id="list-tab" role="tablist">
						@foreach (Auth::user()->blists as $item)
						@if ($loop->first)
								<a href="/lists/{{$item->id}}" class="list-group-item"><img src="" style="height:32px;width:32px;display:inline-block; margin-right:10px;">{{$item->name}}</a>
						@else
							<a href="/lists/{{$item->id}}" class="list-group-item"><img src="" style="height:32px;width:32px;display:inline-block; margin-right:10px;">{{$item->name}}</a>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
