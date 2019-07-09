@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert-container">
			</div>
			<div class="card text-center" style="padding:40px;">
				<img src="{{$item->image}}" class="mx-auto" style="height:200px;width:200px;">
				<h2>{{$item->name}}</h2>
				<h4>{{$item->brand->name}}</h4>
				<p>{{$item->description}}</p>
				<span class="avg-rating"><i class="rating-icon rating-icon-star fa fa-star"></i> <span>{{ number_format($rating, 2)}} ({{$item->users->count()}})</span></span>
	
				@guest
				@else
				<div class="rating-group">
					<form action="{{ route('users.rating')}}" method="post" id="rating-form">
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
@endsection

@section('js')
<script>
@guest
@else
$("#rating-{{$myscore}}").click();
@endguest

$('.rating-input').change(function(){
	console.log($('#rating-form').serialize());
	$.post("{{ route('users.rating')}}", $('#rating-form').serialize(), function(data) {
		bootstrapAlert("Successfully Rated!", data.status);
		$('.alert').delay(2000).slideUp(500, function() {
			$(this).alert('close');
		});
		$('.avg-rating span').text(data.rating.toFixed(2)+" ("+data.raters+")");
	});
});
</script>
@endsection