@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
	            <div class="card-header">{{ __('Brands') }}</div>
					<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
						@foreach ($items as $item)
						@if ($loop->first)
								<a href="/brands/{{$item->id}}" class="list-group-item"><img src="/images/{{$item->image}}">{{$item->name}}</a>
						@else
							<a href="/brands/{{$item->id}}" class="list-group-item"><img src="/images/{{$item->image}}">{{$item->name}}</a>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
