@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<h2>{{$item->name}}</h2>
			<h4>{{$item->description}}</h4>
			<div class="card">
	            <div class="card-header">{{ __('Products') }}</div>
					<div class="list-group list-group-flush rank-list" id="list-tab" role="tablist">
						@foreach ($products as $item)
						@if ($loop->first)
							<div class="product-list-item list-group-item">
								<i class="fa fa-certificate rank-bg rank-bg-1"></i>
								<span class="rank rank-top">{{$loop->iteration}}</span>
								<a href="/products/{{$item->id}}">
									<img src="{{$item->image}}" style="height:100px;width:100px;display:inline-block; margin-right:10px;">
									<div class="product-info">
										<p class="name"><b>{{$item->name}}</b></p>
										<p class="sub-info">Quantity/Price</p>
										<p class="sub-info"><span class="avg-rating"><i class="rating-icon rating-icon-star fa fa-star"></i> <span>{{ number_format($ratings[$loop->index][0], 2)}} ({{$ratings[$loop->index][1]}})</span></span></p>
									</div>
								</a>
								<div class="product-other">
								</div>
							</div>
						@else
							<div class="product-list-item list-group-item">
								@if ($loop->iteration == 2)
									<i class="fa fa-certificate rank-bg rank-bg-2"></i>
								<span class="rank rank-top">{{$loop->iteration}}</span>
								@elseif ($loop->iteration == 3)
									<i class="fa fa-certificate rank-bg rank-bg-3"></i>
									<span class="rank rank-top">{{$loop->iteration}}</span>
								@else
									<span class="rank">{{$loop->iteration}}</span>
								@endif
								<a href="/products/{{$item->id}}">
									<img src="{{$item->image}}" style="height:100px;width:100px;display:inline-block; margin-right:10px;">
									<div class="product-info">
										<p class="name"><b>{{$item->name}}</b></p>
										<p class="sub-info">Quantity/Price</p>
										<p class="sub-info"><span class="avg-rating"><i class="rating-icon rating-icon-star fa fa-star"></i> <span>{{ number_format($ratings[$loop->index][0], 2)}} ({{$ratings[$loop->index][1]}})</span></span></p>
									</div>
								</a>
								<div class="product-other">
								</div>
							</div>
						@endif
						@endforeach
					</div>
			</div>
		</div>
	</div>
@endsection
