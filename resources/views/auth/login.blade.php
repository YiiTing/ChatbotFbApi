@extends('layouts.header')

@section('content')
<link href="{{ asset('bootstrap-social-gh-pages/bootstrap-social.css') }}" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center" style="margin-top: 20%;">
        <div class="col-md-4">
			<a href="{{ url('/login/facebook') }}" class="btn btn-block btn-social btn-facebook">
				<span class="fab fa-facebook-f"></span> Facebook登入
			</a>
        </div>
    </div>
</div>
@endsection
