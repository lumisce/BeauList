@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
             <div class="card">
	            <div class="card-header">{{ __('Categories') }}</div>
					<div class="row m-0">
						<div class="border-right" style="width:40%;">
							<div class="list-group list-group-flush" id="list-tab" role="tablist">
								@foreach ($items as $item)
								@if ($loop->first)
									<a href="#parent-{{$item->id}}" class="list-group-item list-group-item-action active" data-toggle="list" role="tab">{{$item->name}}</a>
								@else
									<a href="#parent-{{$item->id}}" class="list-group-item list-group-item-action" data-toggle="list" role="tab">{{$item->name}}</a>
								@endif
								@endforeach
							</div>
						</div>
						<div style="width:60%;">
							<div class="tab-content">
								@foreach ($children as $parent => $items)
								@if ($loop->first)
									<div class="tab-pane active list-group-flush" id="parent-{{$parent}}" role="tabpanel">
										@foreach ($items as $item)
											<a href="categories/{{$item->id}}" class="list-group-item" >{{$item->name}}</a>
										@endforeach
									</div>
								@else
									<div class="tab-pane list-group-flush" id="parent-{{$parent}}" role="tabpanel">
										@foreach ($items as $item)
										@if ($loop->first)
											<a href="categories/{{$item->id}}" class="list-group-item border-top-0" >{{$item->name}}</a>
										@else
											<a href="categories/{{$item->id}}" class="list-group-item" >{{$item->name}}</a>
										@endif
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
