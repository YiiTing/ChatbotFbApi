$(function() {
    //此JS給Customer頁面
    //因為table的資料動態產生，使用on才能綁定元素
	// CSRF
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    //搜尋訂閱戶
    $("#btn_search_customer").click(function(){
    	search_customer_by_name($("#input_customer_name").val());
    });

    // BOT狀態
    $(document).on('click', '[bot-status]', function() {
        bot_status_change($(this).attr("customer-id"), $(this).attr("bot-status"));
    });

    //推播黑名單
    $(document).on('click', '[black-list-status]', function() {
        black_list_status_change($(this).attr("customer-id"), $(this).attr("black-list-status"));
    });

    //開啟所有BOT
    $("#btn_enable_all_bot").click(function(){
    	enable_all_bot($(this).attr("customer-all"));
    });
});

//搜尋訂閱戶
function search_customer_by_name(customer_name){
	// console.log("customer_name: " + customer_name);
	var filter = customer_name.toUpperCase();
	var table = document.getElementById('fbMessengerPersonProfile');
	var tr = table.getElementsByTagName('tr');
	for (i = 0; i < tr.length; i++) {
		var td = tr[i].getElementsByTagName('td')[1];
		if (td) {
			var txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = '';
			} else {
				tr[i].style.display = 'none';
			}
		}       
	}
}

// 改變BOT狀態
function bot_status_change(customer_id, bot_status) {
    console.log("customer_id: " + customer_id);
    console.log("bot_status: " + bot_status);
	$.ajax({
		type : 'POST',
		url : '/customerBot',
		data : {
			customer_id : customer_id,
		},
		datatype : 'text',
		success : function(res){
			console.log("Log: "+ res);
			var enable_btn = $("[customer-id='" + customer_id + "'][bot-status='enable']");
			var disable_btn = $("[customer-id='" + customer_id + "'][bot-status='disable']");

			if (bot_status == "enable") {
				$(enable_btn).hide();
				$(disable_btn).show();
			} else {
				$(enable_btn).show();
				$(disable_btn).hide();
			}
		},
		error : function(jqXHR, textStatus, errorThrown){
			if(jqXHR.status == 404){
				console.log("Errors: 找不到資料");
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
			if(jqXHR.status == 422){
				console.log("Errors: " + jqXHR.responseJSON.message);
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
		}
	});
}

//改變推播黑名單狀態
function black_list_status_change(customer_id, black_list_status) {
    console.log("customer_id: " + customer_id);
    console.log("black_list_status: " + black_list_status);
	$.ajax({
		type : 'POST',
		url : '/customerBlock',
		data : {
			customer_id : customer_id,
		},
		datatype : 'text',
		success : function(res){
			console.log("Log: "+ res);
			var enable_btn = $("[customer-id='" + customer_id + "'][black-list-status='enable']");
			var disable_btn = $("[customer-id='" + customer_id + "'][black-list-status='disable']");

			if (black_list_status == "enable") {
				$(disable_btn).show();
				$(enable_btn).hide();
			} else {
				$(disable_btn).hide();
				$(enable_btn).show();
			}
		},
		error : function(jqXHR, textStatus, errorThrown){
			if(jqXHR.status == 404){
				console.log("Errors: 找不到資料");
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
			if(jqXHR.status == 422){
				console.log("Errors: " + jqXHR.responseJSON.message);
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
		}
	});
}

//開啟所有BOT
function enable_all_bot(customer_all){
	$.ajax({
		type : 'POST',
		url : '/customerAllBot',
		data : {
			customer_all : customer_all
		},
		datatype : 'text',
		success : function(res){
			console.log("Log: "+ res);
			var all_enable_btn = $('[bot-status="enable"]');
			var all_disable_btn = $('[bot-status="disable"]');

			$(all_enable_btn).show();
			$(all_disable_btn).hide();
		},
		error : function(jqXHR, textStatus, errorThrown){
			if(jqXHR.status == 404){
				console.log("Errors: 找不到資料");
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
			if(jqXHR.status == 422){
				console.log("Errors: " + jqXHR.responseJSON.message);
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
		}
	});
}