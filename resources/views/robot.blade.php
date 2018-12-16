@extends('layouts.header')

<style>
.card img {
	width: 50%;
	margin: 20% 25%;
}
</style>

@section('content')
<div class="container">
	<h3 class="mt-5">我的機器人</h3>
    <div class="row justify-content-center mt-5">
        <div class="card-deck col-md-12">
		<!--
			<div class="card col-md-3">
				<a href="{{ url('/admin') }}">
					<img class="card-img-top rounded-circle img-fluid" src="{{ 'images/fb-flag.png' }}" alt="">
				</a>
				<div class="card-body border-top">
					<h5 class="card-title">Admin</h5>
				</div>
			</div>
		-->
			<div class="card col-md-3">
				<a href="{{ url('/createRobot') }}">
					<img class="card-img-top rounded-circle img-fluid" src="{{ 'images/fb-flag.png' }}" alt="">
				</a>
				<div class="card-body border-top">
					<h5 class="card-title">新增機器人</h5>
				</div>
			</div>
			@forelse ($arr as $a)
				<div class="card col-md-3">
					<a href="{{ url('/', [$a['id']]) }}">
					<!--<a href="{{ url('/test', [$a['id']]) }}">-->
						<img class="card-img-top rounded-circle img-fluid" src="{{ $a['picture']['data']['url'] }}" alt="">
					</a>
					<div class="card-body border-top">
						<h5 class="card-title">{{ $a['name'] }}</h5>
					</div>
				</div>
			@empty
				
			@endforelse
        </div>
    </div>
</div>
@endsection
