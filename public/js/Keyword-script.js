$(function() {
    // global parameter
    card_append_target = "";

    // 開啟對話方塊Modal
    // 並且設定在選擇對話方塊後，要回傳顯示的關鍵字card
    $(document).on('click', '.btn-add-card', function() {
        card_append_target = $(this).attr("append-target");
        $("#modal_feedback_card").modal('show');
    });

    // 勾選或取消要移除的對話方塊
    $(document).on('change', '.uncheck', function() {
        var checkboxes = $(".uncheck");
        var is_any_check = false;
        $("#btn_remove_checkbox").attr("disabled", !is_any_check);

        for (var i = 0; i < checkboxes.length; i++) {
            if ($(checkboxes[i]).prop("checked")) {
                is_any_check = true;
                break;
            }
        }

        console.log(is_any_check);

        $("#btn_remove_checkbox").attr("disabled", !is_any_check);
    });

    // 移除對話方塊
    $("#btn_remove_checkbox").click(function() {
    	var boxes = $("#tbl_uncheck .uncheck:checked");
		// 更新table
 		delete_table(boxes);
 		// 取得勾選的boxes值後，更新資料庫
 		// boxes[i].value;
		var boxesArr = [];
		for (var i = 0; i < boxes.length; i++) {
			boxesArr.push(boxes[i].value);
        }
		
		$.ajax({
			type : 'POST',
			url : '/keywordDefaultDelete',
			data : {
				boxes : boxesArr
			},
			datatype : 'text',
			success : function(res){
				console.log("Log: "+ res);
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
			},
			complete : function(){
				default_list();
			}
		});
    });

    // 勾選或取消要添加的對話方塊
    $(document).on('change', '.check', function() {
        var checkboxes = $(".check");
        var is_any_check = false;
        $("#btn_add_checkbox").attr("disabled", !is_any_check);

        for (var i = 0; i < checkboxes.length; i++) {
            if ($(checkboxes[i]).prop("checked")) {
                is_any_check = true;
                break;
            }
        }

        console.log(is_any_check);

        $("#btn_add_checkbox").attr("disabled", !is_any_check);
    });

    // 添加對話方塊
    $("#btn_add_checkbox").click(function() {
    	var boxes = $("#tbl_check .check:checked");
		// 更新table
 		add_table(boxes);
 		// 取得勾選的boxes值後，更新資料庫
 		// boxes[i].value;
		var boxesArr = [];
		for (var i = 0; i < boxes.length; i++) {
			boxesArr.push(boxes[i].value);
        }
		
		$.ajax({
			type : 'POST',
			url : '/keywordDefaultAdd',
			data : {
				boxes : boxesArr
			},
			datatype : 'text',
			success : function(res){
				console.log("Log: "+ res);
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
			},
			complete : function(){
				default_list();
			}
		});
    });

    // 儲存變更後，更新指定的呼叫方塊
    // $("#btn_save_card_change").click(function(){
    	// $(card_append_target).empty();
    	// var card_list = new Array();
    	// var btn_html = "";  // 作為產生button的html

    	// $.each(card_list, function(index, item){
    		// btn_html = "<button type='button' class='btn btn-info'>" + item.btn_text + "</button>";

    		// $(card_append_target).append(btn_html);
    	// });
    // });

    // 新增關鍵字
    // 動態取得更新區域的第二種做法
    $(document).on('click', '.add-keyword', function(){
    	let neighbor_textbox = $(this).siblings("input");
    	let father_td = $(this).parent("div").parent("td");

    	// 取得關鍵字
    	// console.log($(neighbor_textbox).val());
		
    	// ajax回傳
		$.ajax({
			type : 'POST',
			url : '/keywordCustomAdd',
			data : {
				neighbor : $(neighbor_textbox).val()
			},
			datatype : 'json',
			success : function(res){
				console.log("Log: "+ res);
				// let all_keyword = JSON.parse(res);
				// father_td.empty();
				// for(let i = 0; i < all_keyword.length; i++){
					// father_td.append("<button type='button' class='btn btn-outline-dark delete-keyword' value=" + all_keyword[i] + " style='margin: 0 10px 0 0;'>" + all_keyword[i] + "</button>");
				// }
				// 最後一個關鍵字後補上新增視窗
				// father_td.append('<div class="add-keyword-group">' +
					// '<input  type="text" class="form-control" placeholder="輸入關鍵字">' +
					// '<button type="button" class="btn btn-primary add-keyword"><i class="fas fa-plus"></i></button></div>');
				father_td.append("<button type='button' class='btn btn-outline-dark delete-keyword' value=" + $(neighbor_textbox).val() + " style='margin: 0 10px 0 0;'>" + $(neighbor_textbox).val() + "</button>");
				
				// 清空input
				neighbor_textbox.val('');
						
			},
			error : function(jqXHR, textStatus, errorThrown){
				if(jqXHR.status == 422){
					console.log("Errors: " + jqXHR.responseJSON.message);
					console.log("Status: " + jqXHR.status);
					console.log("TextStatus: " + textStatus);
					console.log("ErrorThrown: " + errorThrown);
				}
			}
		});

    	// 更新關鍵字td
    	// 取得該設定的所有關鍵字，這邊先用一個示範
    	// var all_keyword = [$(neighbor_textbox).val()];
    	// console.log("father_td: " + father_td.length);
    	// father_td.empty();
    	// $.each(all_keyword, function(index, item){
    		// console.log("all_keyword: " + all_keyword);
    		// father_td.append("<button type='button' class='btn btn-outline-dark' style='margin: -3px 10px 0 0;'>" + item + "</button>");
    	// });
    	// 最後一個關鍵字後補上新增視窗
    	// father_td.append('<div class="add-keyword-group">' +
			// '<input  type="text" class="form-control" placeholder="輸入關鍵字">' +
			// '<button type="button" class="btn btn-primary add-keyword"><i class="fas fa-plus"></i></button></div>');
    });
	
	$(document).on('click', '.delete-keyword', function(){
		
		// 取得關鍵字
		// console.log("Log: "+ this.value);
		
		let thisremove = this;
		// ajax回傳
		$.ajax({
			type : 'POST',
			url : '/keywordCustomDelete',
			data : {
				neighbor : this.value
			},
			datatype : 'json',
			success : function(res){
				console.log("Log: "+ res);	
				// 移除關鍵字
				thisremove.remove();
			},
			error : function(jqXHR, textStatus, errorThrown){
				if(jqXHR.status == 404){
					console.log("Errors: " + jqXHR.responseJSON.message);
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
	});
	
	$(document).on('click', '.save-keyword', function(){
		// ajax回傳
		$.ajax({
			type : 'POST',
			url : '/keywordCustomSave',
			data : {
				options : document.querySelector('input[name="options"]:checked').value,
				keywordcustom : document.getElementById("keywordcustom").value
			},
			datatype : 'json',
			success : function(res){
				location.reload();
			},
			error : function(jqXHR, textStatus, errorThrown){
				if(jqXHR.status == 401){
					console.log("Errors: " + jqXHR.responseJSON.message);
					console.log("Status: " + jqXHR.status);
					console.log("TextStatus: " + textStatus);
					console.log("ErrorThrown: " + errorThrown);
				}
				if(jqXHR.status == 404){
					console.log("Errors: " + jqXHR.responseJSON.message);
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
	});

	$(document).on('click', '.cancel-keyword', function(){	
		// ajax回傳
		$.ajax({
			type : 'POST',
			url : '/keywordCustomCancel',
			data : {
				id : this.value
			},
			datatype : 'json',
			success : function(res){
				location.reload();
			},
			error : function(jqXHR, textStatus, errorThrown){
				if(jqXHR.status == 401){
					console.log("Errors: " + jqXHR.responseJSON.message);
					console.log("Status: " + jqXHR.status);
					console.log("TextStatus: " + textStatus);
					console.log("ErrorThrown: " + errorThrown);
				}
				if(jqXHR.status == 404){
					console.log("Errors: " + jqXHR.responseJSON.message);
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
	});
});

// 更新table
// 假設已經取得相關資料
function add_table(boxes) {
	var check_cards = boxes;

	// 更新已選擇的對話方塊
	$.each(check_cards, function(index, item){
		$("#" + item.value).remove();
		$("#tbl_uncheck tbody").append(
			'<tr id="'+item.value+'"><td><input type="checkbox" class="check" value="'+item.value+'" id="'+item.value+'"></td><td>'+item.id+'</td></tr>'
		);
	});
}
function delete_table(boxes) {
	var uncheck_cards = boxes;
	var check_cards = new Array();

	// 更新已選擇的對話方塊
	$.each(uncheck_cards, function(index, item){
		$("#" + item.value).remove();
		$("#tbl_check tbody").append(
			'<tr id="'+item.value+'"><td><input type="checkbox" class="check" value="'+item.value+'" id="'+item.value+'"></td><td>'+item.id+'</td></tr>'
		);
	});
}
function default_list() {
	$.ajax({
		type : 'POST',
		url : '/keywordDefaultList',
		data : null,
		datatype : 'json',
		success : function(res){
			$("#keyword-default-list").empty();
			var card_list = JSON.stringify(res);
			var btn_html = "";  // 作為產生button的html
			
			$.each(res, function(index, item){
				btn_html = "<button type='button' class='btn btn-outline-dark'>" +item.mkw_request+ "</button>";
				$("#keyword-default-list").append(btn_html);
			});
		},
		error : function(jqXHR, textStatus, errorThrown){
			if(jqXHR.status == 404){
				$("#keyword-default-list").empty();
				console.log("Errors: 找不到資料");
				console.log("Status: " + jqXHR.status);
				console.log("TextStatus: " + textStatus);
				console.log("ErrorThrown: " + errorThrown);
			}
		}
	});
}