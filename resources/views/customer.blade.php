@extends('layouts.header')

@section('content')
	<script src="{{ asset('js/customer-script.js') }}"></script>
    <div class="alert alert-primary" role="alert" style="border-radius: 0;">
        【8/3系統公告】貼文回覆功能授權機制更新，詳細說明請<a href="#" class="alert-link">點此觀看</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="row">
                        <div class="col-3">
                            <i class="fas fa-rss-square" style="position: relative;top: 50%;transform: translateY(-50%);font-size: 50px;color: #343a40;"></i>
                        </div>
                        <div class="col-9" style="text-align: right;">
                            <p style="margin-bottom: 0.1rem;font-size: 34px;">{{ count($FbMessengerPersonProfiles) }}</p>
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
							@php
								$newToday = 0;
							@endphp
							@forelse ($FbMessengerPersonProfiles as $FbMessengerPersonProfile)
								 @if (strtotime(date('Y-m-d', strtotime($FbMessengerPersonProfile->created_at))) == strtotime(date('Y-m-d')))
									@php
										$newToday++;
									@endphp
								 @endif
							@empty
								@php
									$newToday = 0;
								@endphp
							@endforelse
							<p style="margin-bottom: 0.1rem;font-size: 34px;">{{ $newToday }}</p>	
                            <p style="margin-bottom: 0.1rem">個本日新增訂閱的人數</p>
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
                            <p style="margin-bottom: 0.1rem;font-size: 34px;">好像沒有取消哈哈</p>
                            <p style="margin-bottom: 0.1rem">個取消訂閱的人數</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 60px;"></div>
        <div class="row">
            <div class="col-md-12">
                <h3>訂閱戶名單</h3>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-8">
                <span style="display: inline-block;">搜尋姓名</span>
                <input type="text" name="" class="form-control" id="input_customer_name" style="display: inline-block;width: auto;">
                <button type="button" id="btn_search_customer" class="btn btn-primary" style="display: inline-block;margin-top: -3px;"><i class="fas fa-search"></i>&nbsp;搜尋</button>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <button type="button" id="btn_enable_all_bot" class="btn btn-primary" customer-all="{{ Auth::user()->nowfbpage_id }}" style="display: inline-block;margin-top: -3px;">開啟所有BOT</button>
            </div>
        </div>
        <div style="height: 20px;"></div>
		@isset($FbMessengerPersonProfiles)
        <div class="row">
            <div class="col-md-12">
                <table class="table" style="text-align: center;">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">姓名</th>
                            <th scope="col">性別</th>
                            <th scope="col">活動狀態(這要怎麼判斷勒)</th>
                            <th scope="col">上次互動時間</th>
                            <th scope="col">訂閱狀態(這是什麼意思勒)</th>
                            <th scope="col">Bot 狀態</th>
                            <th scope="col">推播黑名單</th>
                        </tr>
                    </thead>
                    <tbody id="fbMessengerPersonProfile">
						@foreach ($FbMessengerPersonProfiles as $FbMessengerPersonProfile)
						<tr>
                            <td><i class="fas fa-user-circle" style="font-size: 34px;"></i></td>
							<!--
							<td><img src="{{ $FbMessengerPersonProfile->mpp_profile_pic }}" class="img-thumbnail" alt="" width="100px" height="100px"></td>
							-->
                            <td>{{ $FbMessengerPersonProfile->mpp_last_name.$FbMessengerPersonProfile->mpp_first_name }}</td>
							@if ($FbMessengerPersonProfile->mpp_gender == 'male')
                            <td><i class="fas fa-mars" style="font-size: 24px;"></i></td>
							@elseif ($FbMessengerPersonProfile->mpp_gender == 'female')
							<td><i class="fas fa-venus" style="font-size: 24px;"></i></td>
							@else
							<td></td>
							@endif
                            <td><i class="far fa-smile" style="font-size: 24px;"></i></td>
                            <td>{{ date('Y-m-d H:i:s', $FbMessengerPersonProfile->interaction) }}</td>
							@if ($FbMessengerPersonProfile->like == 1)
                            <td>訂閱中</td>
							@else
							<td>未訂閱</td>
							@endif
                            <td>
								@if ($FbMessengerPersonProfile->bot == 1)
                                <button type="button" class="btn btn-info" customer-id="{{ $FbMessengerPersonProfile->id }}" bot-status="enable">開啟中</button>
								<button type="button" class="btn btn-danger" customer-id="{{ $FbMessengerPersonProfile->id }}" bot-status="disable" style="display: none;">關閉中</button>
								@else
								<button type="button" class="btn btn-info" customer-id="{{ $FbMessengerPersonProfile->id }}" bot-status="enable" style="display: none;">開啟中</button>
								<button type="button" class="btn btn-danger" customer-id="{{ $FbMessengerPersonProfile->id }}" bot-status="disable">關閉中</button>
								@endif
                            </td>
                            <td>
								@if ($FbMessengerPersonProfile->block == 1)
								<button type="button" class="btn btn-info" customer-id="{{ $FbMessengerPersonProfile->id }}" black-list-status="disable" style="display: none;">未封鎖</button>
                                <button type="button" class="btn btn-danger" customer-id="{{ $FbMessengerPersonProfile->id }}" black-list-status="enable">已封鎖</button>
								@else
								<button type="button" class="btn btn-info" customer-id="{{ $FbMessengerPersonProfile->id }}" black-list-status="disable">未封鎖</button>
                                <button type="button" class="btn btn-danger" customer-id="{{ $FbMessengerPersonProfile->id }}" black-list-status="enable" style="display: none;">已封鎖</button>
								@endif
                            </td>
                        </tr>
						@endforeach
                    </tbody>
                </table>
				<div class="d-flex">
					<div class="mx-auto text-center">
						{{ $FbMessengerPersonProfiles->links('pagination::bootstrap-4') }}
					</div>
				</div>
				<!--
                <div style="text-align: center;">
                    <nav aria-label="Page navigation example" style="display: inline-block;">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
				-->
            </div>
        </div>
		@endisset
    </div>
@endsection