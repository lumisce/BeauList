@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert-container">
			</div>
			<div class="card text-center" style="padding:40px;">
				<img src="{{$item->image}}" class="mx-auto" style="height:200px;width:200px;">
				<h2>{{$item->name}}</h2>
				<a href="{{ route('brands.show', $item->brand->id) }}"><h5>{{$item->brand->name}}</h5></a>
				<p>{{$item->description}}</p>
				<div>
					@foreach ($item->quantityprices as $qp)
						@if ($loop->first)
							<span>{{$qp->quantity}}{{$qp->unit}} / <i class="fa fa-krw" aria-hidden="true"></i>{{$qp->price}}</span>
						@else
							<span> | {{$qp->quantity}}{{$qp->unit}} / <i class="fa fa-krw" aria-hidden="true"></i>{{$qp->price}}</span>
						@endif
					@endforeach
				</div>
				<span class="avg-rating"><i class="rating-icon rating-icon-star fa fa-star"></i> <span>{{ number_format($rating[0], 2)}} ({{$rating[1]}})</span></span>
				<a href="{{ route('categories.show', $item->category->id) }}"><h5>{{$item->category->name}}</h5></a>
	

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

				@guest
				<p class="sub-info">Login to Rate</p>
				@else
				<div class="rating-group">
					<form id="rating-form">
						@csrf
						<input type="hidden" name="product" value="{{$item->id}}">

						<input class="rating-input rating-input-none" name="rating" id="rating-none" value="0" type="radio" checked="checked"/>
						<label for="rating-none" aria-label="No Rating" class="rating-label"><i class="rating-icon rating-icon-none fa fa-times"></i></label>

						<label for="rating-1" aria-label="1 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
						<input class="rating-input" name="rating" id="rating-1" value="1" type="radio" />

						<label for="rating-2" aria-label="2 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
						<input class="rating-input" name="rating" id="rating-2" value="2" type="radio" />

						<label for="rating-3" aria-label="3 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
						<input class="rating-input" name="rating" id="rating-3" value="3" type="radio" />

						<label for="rating-4" aria-label="4 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
						<input class="rating-input" name="rating" id="rating-4" value="4" type="radio" />

						<label for="rating-5" aria-label="5 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
						<input class="rating-input" name="rating" id="rating-5" value="5" type="radio" />
					</form>
				</div>
				@endguest
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
@auth
$("#rating-{{$myscore}}").click();
@endauth

$('.rating-input').change(function() {
	console.log($('#rating-form').serialize());
	$.post("{{ route('products.rate')}}", $('#rating-form').serialize(), function(data) {
		bootstrapAlert("Successfully Rated!", data.status);
		$('.alert').delay(2000).slideUp(500, function() {
			$(this).alert('close');
		});
		$('.avg-rating span').text(data.rating.toFixed(2)+" ("+data.raters+")");
	});
});

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