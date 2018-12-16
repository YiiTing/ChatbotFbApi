<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	
	<!-- Styles -->
	<link href="{{ asset('fontawesome-free-5.2.0-web/css/all.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap4/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/my-css.css') }}" rel="stylesheet">
	
	<!-- Scripts -->
	<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>
	
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <a class="navbar-brand" href="{{ url('/robot') }}"><i class="fas fa-robot" style="font-size: 34px;color: #ffffff;"></i></a>
		@auth
			@if (Request::path() != 'createRobot' && Request::path() != 'robot' && Request::path() != 'admin')
			<ul class="navbar-nav main-nav">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/', [Auth::user()->nowfbpage_id]) }}"><i class="fas fa-tachometer-alt"></i><br/>主選單</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('customer') }}"><i class="fas fa-heart"></i><br/>訂閱戶</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('lottery') }}"><i class="fas fa-award"></i><br/>抽獎活動</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('message') }}"><i class="fas fa-comments"></i><br/>自動回應</a>
				</li>
				<li class="nav-item dropdown">             
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-broadcast-tower" style="font-size: 18px;"></i><br/>
					推播訊息
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="#">發送訊息</a>
						<a class="dropdown-item" href="{{ url('history') }}">所有訊息</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('keyword') }}"><i class="fas fa-key"></i><br/>關鍵字</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('feed') }}"><i class="fas fa-comment-alt"></i><br/>貼文回覆</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('setting') }}"><i class="fas fa-cog"></i><br/>bot設定</a>
				</li>
			</ul>
			@else
				<ul class="navbar-nav main-nav">
				</ul>
			@endif
			<div class="dropdown">
				<a href="#" class="dropdown-toggle fab fa-facebook-square" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;font-size: 24px;text-decoration: none;">
					{{ Auth::user()->name }} <span class="caret"></span>
				</a>

				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="{{ route('logout') }}"
						onclick="event.preventDefault();
								 document.getElementById('logout-form').submit();">
						Logout
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</div>
			</div>
		@endauth
		<!--
        <div style="color: #ffffff;">
            <i class="far fa-check-circle" style="font-size: 38px;"></i>&nbsp;
            <span style="line-height: 39px;vertical-align: bottom;">AA</span>
        </div>
		-->
    </nav>
	
	@yield('content')
</body>

</html>