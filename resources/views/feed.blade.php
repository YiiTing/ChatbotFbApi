@extends('layouts.header')

@section('content')
    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-2" style="padding-top: 5px;">
                <h5>輸入FB貼文網址</h5>
            </div>
            <div class="col-md-8">
                <input type="text" name="" class="form-control" placeholder="輸入粉絲團網址">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp;搜尋</button>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-12">
                <h5>貼文列表</h5>
                <table class="table table-hover" style="text-align: center;">
                    <thead style="background-color: #bee5eb;">
                        <tr>
                            <th scope="col">貼文註解</th>
                            <th scope="col">留言回復數</th>
                            <th scope="col">私訊回復數</th>
                            <th scope="col">健康度</th>
                            <th scope="col">狀態</th>
                            <th scope="col">建立時間</th>
                            <th scope="col">功能</th>
                        </tr>
                    </thead>
                    <tbody>
						@if ($responseList != null)
							@foreach ($responseList as $response)
								<tr>
									@if (isset($response->message))
										<th>貼文： {{ $response->message }}</th>
									@else
										<th>貼文： </th>	
									@endif
									<td>8</td>
									<td>8</td>
									<td><i class="fas fa-check-circle" style="color: #28a745;"></i></td>
									<td><i class="fas fa-circle" style="color: #dc3545;"></i></td>
									@php
										// 更改時區
										date_default_timezone_set('Asia/Taipei');
									@endphp
									<td>{{ date('Y-m-d H:i:s', strtotime($response->created_time)) }}</td>
									<td><button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></button></td>
								</tr>
							@endforeach
						@endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection