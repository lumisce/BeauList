@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert-container">
			</div>
			<div class="card">
				<div class="card-header">{{ __('Saved Lists') }} (<span class="count">{{Auth::user()->savedBlists->count()}}</span>)</div>
				<div class="list-group list-group-flush rank-list" id="list-tab" role="tablist">
					@foreach (Auth::user()->savedBlists as $item)
						@if ($loop->first)
							<a href="/lists/{{$item->id}}" class="list-group-item">{{$item->name}}<img src=""></a>
						@else
							<a href="/lists/{{$item->id}}" class="list-group-item">{{$item->name}}<img src=""></a>
						@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
