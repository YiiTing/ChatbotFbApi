@extends('layouts.header')

@section('content')
	<script src="{{ asset('js/setting-script.js') }}"></script>
	<script>
	$(document).ready(function(){
		$("#btn_add_func_button").click(function(){
			$.ajax({
				type:'POST',
				url:'{{ url("bot/persistentmenubtn") }}',
				dataType:'text',
				data:{
					text_func_btn_title : $('#text_func_btn_title').val(),
					text_func_url : $('#text_func_url').val()
				},
				success:function(data){
					// console.log(data);
					if(data){
						location.reload();
					}else{
						alert('三個基本連結');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				}
			});
		});
		$(".btn_del_func").click(function(){
			$.ajax({
				type:'DELETE',
				url:'{{ url("bot/persistentmenubtn") }}',
				dataType:'text',
				data:{
					id: this.id
				},
				success:function(data){
					// console.log(data);
					if(data){
						location.reload();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				}
			});
		});
		$("#btn_enable_search_order").click(function(){
			$.ajax({
				type:'POST',
				url:'{{ url("bot/persistentmenu") }}',
				dataType:'text',
				data:{},
				success:function(data){
					console.log(data);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				}
			});
		});
		$("#btn_disable_search_order").click(function(){
			$.ajax({
				type:'DELETE',
				url:'{{ url("bot/persistentmenu") }}',
				dataType:'text',
				data:{},
				success:function(data){
					console.log(data);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				}
			});
		});
		
		// $("#btnPostFbPersistent").click(function(){
			// var fbPersistentwebtitle = [];
			// $('.fbPersistentwebtitle').each(function(){
				// fbPersistentwebtitle.push(this.value); 
			// });
			// var fbPersistentweburl = [];
			// $('.fbPersistentweburl').each(function(){
				// fbPersistentweburl.push(this.value); 
			// });
			// $.ajax({
				// type:'POST',
				// url:'{{ url("bot/persistentmenu") }}',
				// dataType:'text',
				// data:{
					// fbPersistentwebtitle : fbPersistentwebtitle,
					// fbPersistentweburl :　fbPersistentweburl
				// },
				// success:function(data){
					// console.log(data);
					// if(data){
						// location.reload();
					// }
				// },
				// error: function(xhr, ajaxOptions, thrownError) {
					// console.log(xhr.responseText);
				// }
			// });
		// });
	});

	</script>
    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-8">
                <h5>機器人狀態</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <div style="display: flex;justify-content: space-between;">
                    <p style="color: #dc3545;margin: auto 0;">休眠：所有機器人功能停止（包含排程中推播）</p>
                    <button id="btn_enable_bot" type="button" class="btn btn-danger">關閉BOT</button>
                    <button id="btn_disable_bot" type="button" class="btn btn-info" style="display: none;">開啟BOT</button>
                </div>
            </div>
            <div class="col-4">
                <h5>使用語系</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <label class="radio-container">繁中
                    <input type="radio" checked="checked" name="language" value="traditional_chinese">
                    <span class="checkmark"></span>
                </label>
                <label class="radio-container">英
                    <input type="radio" name="language" value="english">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <div style="height: 40px;"></div>
      ` <div class="row">
            <div class="col-12">
                <h5>連接粉絲頁</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <div style="display: flex;justify-content: space-between;">
                    <div>
                        <img src="{{ $page_detail->picture->data->url }}" style="height: 100px;margin-right: 20px;">
                        <a href="{{ $page_detail->link }}">{{ $page_detail->name }}</a>
                    </div>
                    <div style="margin: auto 0;">
                        <span>{{ Auth::user()->name }}</span>&nbsp;
						@if ($page_detail->is_webhooks_subscribed)
							<button type="button" class="btn btn-danger" id="btn_disable_link_with_post">解除連結</button>
						@else
							<button type="button" class="btn btn-primary" id="btnPostFbPage">新增連結</button>
						@endif
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-6">
                <h5>常設功能表</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>私訊的對話框左下角預設有主選單，至多可設定三個基本連結，請在以下設定。</p>
				<!--
				<div style="display: flex;justify-content: space-between;">
					<div>
						<p style="margin-right: 20px;display: inline-block;">連結設定一</p>
						<p style="margin: auto 0;display: inline-block;">
							<input type="text" class="form-control fbPersistentwebtitle" placeholder="標題">
						</p>
						<p style="margin: auto 0;display: inline-block;">
							<input type="text" class="form-control fbPersistentweburl" placeholder="網址">
						</p>
					</div>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<div>
						<p style="margin-right: 20px;display: inline-block;">連結設定二</p>
						<p style="margin: auto 0;display: inline-block;">
							<input type="text" class="form-control fbPersistentwebtitle" placeholder="標題">
						</p>
						<p style="margin: auto 0;display: inline-block;">
							<input type="text" class="form-control fbPersistentweburl" placeholder="網址">
						</p>
					</div>
				</div>
				<div style="text-align: center;">
                    <button type="button" class="btn btn-danger" id="btnPostFbPersistent">開啟連結</button>
                </div>
				-->
				<div style="text-align: center;">
                    <p style="color: #007bff;">啟用：按鈕功能開啟</p>
					@if ($countfbMessengerPersistentMenu < 1)
						<button id="btn_enable_search_order" type="button" class="btn btn-info">開起按鈕</button>
						<button id="btn_disable_search_order" type="button" class="btn btn-danger" style="display: none;">關閉按鈕</button>
					@else
						<button id="btn_enable_search_order" type="button" class="btn btn-info" style="display: none;">開起按鈕</button>
						<button id="btn_disable_search_order" type="button" class="btn btn-danger">關閉按鈕</button>
					@endif
                    <button id="open_add_func_modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;新增按鈕</button>
                    <div style="height: 10px;"></div>
                    <ul class="list-group">
						@forelse ($fbMessengerPersistentMenu as $persistentMenu)
							<li class="list-group-item flex-between">
								<div>
									<span style="vertical-align: middle;">{{ $persistentMenu->mpm_title }}</span>
								</div>
								<div>
									<button type="button" class="btn btn-danger btn-sm btn_del_func" func-id="1" id="{{ $persistentMenu->id }}" title="刪除">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</li>
						@empty
						@endforelse
                    </ul>
                </div>
            </div>
			<div class="col-6">
                <h5>設定管理員</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>可增減管理員，每個機器人至多可設定5位管理員(企業方案可設定10位)。</p>
                <button id="open_invite_admin_modal" type="button" class="btn btn-primary" id="btnPostFbAdmin">邀請管理員</button>
                <div style="height: 20px;"></div>
                <h5 style="color: #212529;">目前管理員</h5>
                <div style="height: 20px;"></div>
                <div>
                    <img src="{{ 'images/fb-flag.png' }}" style="height: 50px;border-radius: 50%;margin-right: 20px;display: inline-block;">
                    <p style="margin: auto 0;display: inline-block;">Nian Bao Zou (擁有者)</p>
                </div>
                <div style="height: 20px;"></div>
				@foreach ($admin_lists as $admin_list)	
                <div style="display: flex;justify-content: space-between;">
                    <div>
                        <img src="{{ 'images/fb-flag.png' }}" style="height: 50px;border-radius: 50%;margin-right: 20px;display: inline-block;">
                        <p style="margin: auto 0;display: inline-block;">{{ $admin_list->name }} (擁有者)</p>
                    </div>
                    <div style="margin: auto 0;">
                        <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></button>
                    </div>
                </div>
				@endforeach
            </div>
           
        </div>
		<div style="height: 40px;"></div>
        <div class="row">
            <div class="col-6">
                <h5>時區設定</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>發送推播訊息時，以此時區設定為準。</p>
                <select class="form-control">
                    <option>Taipei (UTC+8)</option>
                </select>
            </div>
            <div class="col-6">
                <h5>設定客服人員</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>可增減被通知人員，每個機器人至多可設定5位客服。</p>
                <button id="open_invite_service_modal" type="button" class="btn btn-primary">邀請客服人員</button>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-6">
                <h5>自動開啟BOT狀態</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>可設定多久時間後，訂閱戶的BOT狀態會自動開啟</p>
                <input type="text" name="" class="form-control" style="width: initial;display: inline-block;" placeholder="輸入分鐘數">
                <span>分鐘後</span>
                <button type="button" class="btn btn-primary">確定</button>
            </div>
            <div class="col-6">
                <h5>設定上班時間</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>你可以另行設定一個方塊，用來當作下班時間的預設回應</p>
                <select class="form-control">
                    <option>星期一</option>
                    <option>星期二</option>
                    <option>星期三</option>
                    <option>星期四</option>
                    <option>星期五</option>
                    <option>星期六</option>
                    <option>星期日</option>
                </select>
                <div style="height: 20px;"></div>
                <p>上班時間</p>
                <select style="width: 80px;">
                    <option>11</option>
                </select>
                :
                <select style="width: 80px;">
                    <option>11</option>
                </select>到
                <select style="width: 80px;">
                    <option>11</option>
                </select>
                :
                <select style="width: 80px;">
                    <option>11</option>
                </select>
                <div style="height: 20px;"></div>
                <p>非上班時間回應內容</p>
                <p style="margin: 0" id="not_worktime_feed_text">(尚未選擇)</p>
                <button id="choose_feed_after_worktime" type="button" class="btn btn-primary">
                    選擇回應內容
                </button>
            </div>
        </div>
        <div style="height: 40px;"></div>
    </div>
	<!-- modal -->
    <!-- 新增功能按鈕 -->
    <div class="modal fade" id="modal_add_new_func" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增功能</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <span style="margin-top: 7px;display: block;">按鈕標題</span>
                        </div>
                        <div class="col-md-8">
                            <input id="text_func_btn_title" type="text" name="" placeholder="輸入按鈕標題" class="form-control">
                        </div>
                    </div>
                    <div style="height: 10px;"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <span style="margin-top: 7px;display: block;">應對的回答</span>
                        </div>
                        <div class="col-md-8 flex-between">
                            <span id="feed_card_text" style="margin-top: 7px;display: block;">(如果要使用外部網址不需設定)</span>
                            <button id="choose_feed_card" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>選擇回答</button>
                        </div>
                    </div>
                    <div style="height: 10px;"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <span style="margin-top: 7px;display: block;">網址</span>
                        </div>
                        <div class="col-md-8">
                            <input id="text_func_url" type="url" name="" placeholder="輸入網址" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <button id="btn_add_func_button" type="button" class="btn btn-warning">新增按鈕</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 選擇要回答的方塊 -->
    <div class="modal fade" id="modal_choose_card" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">選擇回答</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item flex-between">
                            <div>
                                <span style="vertical-align: middle;">功能三</span>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm btn_add_card_text" card-text="功能三" title="選擇回答">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </li>
                        <li class="list-group-item flex-between">
                            <div>
                                <span style="vertical-align: middle;">功能四</span>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm btn_add_card_text" card-text="功能四" title="選擇回答">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 邀請管理員的連結 -->
    <div class="modal fade" id="modal_invite_admin" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">邀請管理員</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>複製並傳送以下程式碼來邀請管理員。
                        <br/>
                        （以下連結為24小時之內有效）
                    </p>
                    <input type="text" name="" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 設定客服人員的連結 -->
    <div class="modal fade" id="modal_invite_service" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">邀請客服人員</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>複製並傳送以下程式碼來邀請客服員。
                        <br/>
                        （以下連結為24小時之內有效）
                    </p>
                    <input type="text" name="" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>    
@endsection