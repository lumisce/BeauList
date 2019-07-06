@extends('base')

@section('main')
	<h2>Categories</h2>
	<div class="row">
		<div class="col-4">
			<div class="list-group" id="list-tab" role="tablist">

				@foreach ($items as $item)
				@if ($loop->first)
					<a href="#parent-{{$item->id}}" class="list-group-item list-group-item-action active" data-toggle="list" role="tab">{{$item->name}}</a>
				@else
					<a href="#parent-{{$item->id}}" class="list-group-item list-group-item-action" data-toggle="list" role="tab">{{$item->name}}</a>
				@endif
				@endforeach
			</div>
		</div>
		<div class="col-4">
			<div class="tab-content">
				@foreach ($children as $parent => $items)
					@if ($loop->first)
						<div class="tab-pane active" id="parent-{{$parent}}" role="tabpanel">
							@foreach ($items as $item)
								<a href="categories/{{$item->id}}" class="list-group-item" >{{$item->name}}</a>
							@endforeach
						</div>
					@else
						<div class="tab-pane" id="parent-{{$parent}}" role="tabpanel">
							@foreach ($items as $item)
								<a href="categories/{{$item->id}}" class="list-group-item" >{{$item->name}}</a>
							@endforeach
						</div>
					@endif
				@endforeach
				<br>
				<br>
				
			</div>
		</div>
	</div>
@endsection
