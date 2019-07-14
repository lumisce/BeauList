@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert-container">
			</div>
			<div class="card">
				<div class="card-header">{{ __('Favorite Brands') }} (<span class="count">{{ Auth::user()->favoriteBrands->count() }}</span>)</div>
					<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
						@foreach (Auth::user()->favoriteBrands as $item)
						@if ($loop->first)
								<a href="/brands/{{$item->id}}" class="list-group-item"><img src="">{{$item->name}}</a>
						@else
							<a href="/brands/{{$item->id}}" class="list-group-item"><img src="">{{$item->name}}</a>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
