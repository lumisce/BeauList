@extends('base')

@section('main')
	<h2>Brands</h2>
	<div class="row">
		<div class="col-6">
			<div class="list-group" id="list-tab" role="tablist">

				@foreach ($items as $item)
				@if ($loop->first)
					<a href="brands/{{$item->id}}" class="list-group-item">{{$item->name}}</a>
				@else
					<a href="brands/{{$item->id}}" class="list-group-item">{{$item->name}}</a>
				@endif
				@endforeach
			</div>
		</div>
	</div>
@endsection
