@extends('layouts.header')

@section('content')
    <div class="alert alert-primary" role="alert" style="border-radius: 0;">
        【8/3系統公告】貼文回覆功能授權機制更新，詳細說明請<a href="#" class="alert-link">點此觀看</a>
    </div>
	@isset ($page_detail)
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-primary">
                    <img class="card-img-top" src="{{ $page_detail['picture']['data']['url'] }}" alt="粉絲團頭貼">
                    <div class="card-body">
                        <p style="margin-bottom: 0.1rem">機器人名稱</p>
                        <input type="text" name="pageName" class="form-control" placeholder="輸入機器人名稱">
                        <div style="height: 20px;"></div>
                        <p style="margin-bottom: 0.1rem">Messenger連結</p>
                        <a href="https://m.me/{{ $page_detail['id'] }}" target="_blank">https://m.me/{{ $page_detail['id'] }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-broadcast-tower" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">100</p>
                                    <p style="margin-bottom: 0.1rem">則推播訊息</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-hand-point-up" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">{{ $page_detail['checkins'] }}</p>
                                    <p style="margin-bottom: 0.1rem">Number of checkins at a place represented by a Page</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-robot" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">100</p>
                                    <p style="margin-bottom: 0.1rem">人使用機器人</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 20px;"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-rss-square" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">100</p>
                                    <p style="margin-bottom: 0.1rem">人訂閱了機器人</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-smile" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">{{ $page_detail['new_like_count'] }}</p>
                                    <p style="margin-bottom: 0.1rem">The number of people who have liked the Page, since the last login. Only visible to a page admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-frown" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">100</p>
                                    <p style="margin-bottom: 0.1rem">個取消訂閱的人數</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div style="height: 20px;"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-robot" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
									@if ($page_detail['is_webhooks_subscribed'])
										<p style="margin-bottom: 0.1rem;font-size: 34px;">是</p>
									@else
										<p style="margin-bottom: 0.1rem;font-size: 34px;">否</p>
									@endif
                                    <p style="margin-bottom: 0.1rem">whether the application is subscribed for real time updates from this page</p>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-robot" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
									@if ($page_detail['is_messenger_platform_bot'])
										<p style="margin-bottom: 0.1rem;font-size: 34px;">是</p>
									@else
										<p style="margin-bottom: 0.1rem;font-size: 34px;">否</p>
									@endif
                                    <p style="margin-bottom: 0.1rem">whether the page is a Messenger Platform Bot</p>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-smile" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">{{ $page_detail['talking_about_count'] }}</p>
                                    <p style="margin-bottom: 0.1rem">The number of people talking about this Page</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div style="height: 20px;"></div>
                <div class="row">
					<div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-smile" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">{{ $page_detail['unread_message_count'] }}</p>
                                    <p style="margin-bottom: 0.1rem">Unread message count for the Page</p>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="info-card">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-smile" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <p style="margin-bottom: 0.1rem;font-size: 34px;">{{ $page_detail['fan_count'] }}</p>
                                    <p style="margin-bottom: 0.1rem">The number of users who like the Page</p>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
    </div>
	@endisset
@endsection