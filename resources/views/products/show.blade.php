@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center" style="padding:40px;">
				<img src="{{$item->image}}" class="mx-auto" style="height:200px;width:200px;">
				<h2>{{$item->name}}</h2>
				<h4>{{$item->brand->name}}</h4>
				<p>{{$item->description}}</p>
				<p>{{$item->users}}</p>
			</div>
		</div>
	</div>
</div>
@endsection
