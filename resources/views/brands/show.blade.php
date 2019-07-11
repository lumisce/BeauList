@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert-container">
			</div>
			<h2>{{$item->name}}</h2>
			<h4>{{$item->description}}</h4>
			<div class="card">
				<div class="card-header">{{ __('Products') }} ({{$products->count()}})</div>
					<div class="list-group list-group-flush rank-list" id="list-tab" role="tablist">
						@foreach ($products as $item)
							<div class="product-list-item list-group-item">
								@if ($loop->first)
									<i class="fa fa-certificate rank-bg rank-bg-1"></i>
									<span class="rank-top">{{$loop->iteration}}</span>
								@elseif ($loop->iteration == 2)
									<i class="fa fa-certificate rank-bg rank-bg-2"></i>
									<span class="rank-top">{{$loop->iteration}}</span>
								@elseif ($loop->iteration == 3)
									<i class="fa fa-certificate rank-bg rank-bg-3"></i>
									<span class="rank-top">{{$loop->iteration}}</span>
								@else
									<span class="rank">{{$loop->iteration}}</span>
								@endif
								<a href="/products/{{$item->id}}">
									<img src="{{$item->image}}" style="height:100px;width:100px;display:inline-block; margin-right:10px;">
									<div class="product-info">
										<p class="name"><b>{{$item->name}}</b></p>
										@php
											$qp = $item->quantityprices->first();
										@endphp
										<p class="sub-info">{{$qp->quantity}}{{$qp->unit}} / <i class="fa fa-krw" aria-hidden="true"></i>{{$qp->price}}</p>
										<p class="sub-info"><span class="avg-rating"><i class="rating-icon rating-icon-star fa fa-star"></i> <span>{{ number_format($ratings[$item->id][0], 2)}} ({{$ratings[$item->id][1]}})</span></span></p>
									</div>
								</a>
								<div class="product-other">
									@guest
									<p class="sub-info">Login to Add to List</p>
									@else
									<div class="dropdown add-to-list" data-product="{{$item->id}}">
										<button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdown-menu-btn">Add to List</button>
										<div class="dropdown-menu" aria-labelledby="dropdown-menu-btn">
											@foreach (Auth::User()->blists as $blist)
												<button type="button" class="dropdown-item" value="{{$blist->id}}">
												@if ($item->blists->contains($blist->id))
													<i class="fa fa-check-square-o text-primary"></i>
												@else
													<i class="fa fa-square-o text-primary"></i>
												@endif
												 {{$blist->name}}</button>
											@endforeach
										</div>
									</div>
									@endguest
								</div>
							</div>
						@endforeach
					</div>
			</div>
		</div>
	</div>
</div>

<form id="add-to-list-form">
	@csrf
	<input type="hidden" name="product" value="" id="product-id-input">
	<input type="hidden" name="list" value="" id="list-id-input">
</form>
@endsection

@section('js')
<script>
$('.add-to-list .dropdown-item').on('click', function() {
	$('#product-id-input').val($(this).closest('.add-to-list').data('product'));
	$('#list-id-input').val(this.value);
	var name = $(this).text();
	var formdata = $('#add-to-list-form').serialize();
	var $this = $(this);
	$.post("{{ route('products.addtolist') }}", formdata, function(data) {
		var action = "Added to ";
		if (data.action == 'removed') {
			action = "Removed from ";
			$this.find('i').removeClass('fa-check-square-o').addClass('fa-square-o');
		} else {
			$this.find('i').removeClass('fa-square-o').addClass('fa-check-square-o');
		}
		bootstrapAlert(action+name+"!", data.status);
		$('.alert').delay(2000).slideUp(500, function() {
			$(this).alert('close');
		});
	});
});
</script>
@endsection