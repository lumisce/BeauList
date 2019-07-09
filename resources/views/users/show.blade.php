@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<h2>{{$item->name}}</h2>
			<h4>{{$item->description}}</h4>
			<div class="card">
	            <div class="card-header">{{ __('Products') }}</div>
					<div class="list-group list-group-flush" id="list-tab" role="tablist">

						@foreach ($item->products as $item)
						@if ($loop->first)
								<a href="/products/{{$item->id}}" class="list-group-item"><img src="{{$item->image}}" style="height:100px;width:100px;display:inline-block; margin-right:10px;">{{$item->name}}</a>
						@else
							<a href="/products/{{$item->id}}" class="list-group-item"><img src="{{$item->image}}" style="height:100px;width:100px;display:inline-block; margin-right:10px;">{{$item->name}}</a>
						@endif
						@endforeach
					</div>
			</div>
		</div>
	</div>
@endsection
