$(function(){
	//global
	card_text_return_id="";

	// BOT的開啟關閉
	$("#btn_disable_bot").click(function(){
		bot_status_trigger(true);
	});

	$("#btn_enable_bot").click(function(){
		bot_status_trigger(false);
	});
	//	

	// 使用語系
	$("input[type='radio'][name='language']").click(function(){
		change_language($(this).val());
	});
	//

	//連接粉絲頁 > 解除連結
	$("#btn_disable_link_with_post").click(function(){
		console.log("已解除連結");
	});
	//

	//訂單查詢的開啟關閉
	$("#btn_enable_search_order").click(function(){
		search_order_trigger(true);
	});
	$("#btn_disable_search_order").click(function(){
		search_order_trigger(false);
	});
	//

	//新增功能按鈕
	$("#open_add_func_modal").click(function(){
		$("#modal_add_new_func").modal('show');
	});

	$("#modal_add_new_func").on('show.bs.modal', function(e){
		console.log("初始化可用的功能列表");
	});
	//

	//打開回答選擇modal
	$("#choose_feed_card").click(function(){
		$("#modal_choose_card").modal('show');
		card_text_return_id = "#feed_card_text";
	});	

	//選擇應對的回答
	$(".btn_add_card_text").click(function(){
		$(card_text_return_id).text($(this).attr("card-text"));
		$("#modal_choose_card").modal('hide');
	});
	//

	//確定新增的功能按鈕
	$("#btn_add_func_button").click(function(){
		$("#modal_add_new_func").modal('hide');
		console.log("新增了功能!!\n" + 
			"功能標題：" + $("#text_func_btn_title").val() + "\n" + 
			"應對的回答：" + $("#feed_card_text").text() + "\n" + 
			"網址：" + $("#text_func_url").val());
	});

	// 刪除常用功能
	$(".btn_del_func").click(function(){
		remove_function($(this).attr("func-id"));
	});
	//

	//邀請管理員
	$("#open_invite_admin_modal").click(function(){
		$("#modal_invite_admin").modal('show');
	});

	//邀請客服人員
	$("#open_invite_service_modal").click(function(){
		$("#modal_invite_service").modal('show');
	});

	//非上班時間回應內容
	$("#choose_feed_after_worktime").click(function(){
		card_text_return_id = "#not_worktime_feed_text";
		$("#modal_choose_card").modal('show');
	});
})

function bot_status_trigger(status){
	$("#btn_disable_bot").toggle(!status);
	$("#btn_enable_bot").toggle(status);

	if(status){
		console.log("開啟了BOT");
	}
	else{
		console.log("關閉了BOT");
	}
}

function change_language(language){
	console.log("選擇語系：" + language);
}

function search_order_trigger(status){
	$("#btn_enable_search_order").toggle(!status);
	$("#btn_disable_search_order").toggle(status);

	if(status){
		console.log("開啟了訂單查詢");
	}
	else{
		console.log("關閉了訂單查詢");
	}
}

function remove_function(remove_func_id){
	console.log("刪除常用功能id: " + remove_func_id);
}

