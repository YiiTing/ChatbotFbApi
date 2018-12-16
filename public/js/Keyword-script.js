$(function() {
    //global parameter
    card_append_target = "";

    // 開啟對話方塊Modal
    // 並且設定在選擇對話方塊後，要回傳顯示的關鍵字card
    $(document).on('click', '.btn-add-card', function() {
        card_append_target = $(this).attr("append-target");
        $("#modal_feedback_card").modal('show');
    });

    //勾選或取消要移除的對話方塊
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

    //移除對話方塊
    $("#btn_remove_checkbox").click(function() {
    	var boxes = $("#tbl_uncheck .uncheck:checked");
 		
 		//取得勾選的boxes值後，更新資料庫
 		// boxes[i].val();

 		//更新table
 		update_table();
    });

    //勾選或取消要添加的對話方塊
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

    //添加對話方塊
    $("#btn_add_checkbox").click(function() {
    	var boxes = $("#tbl_check .check:checked");
 		
 		//取得勾選的boxes值後，更新資料庫
 		// boxes[i].val();

 		//更新table
 		update_table();
    });

    //儲存變更後，更新指定的呼叫方塊
    $("#btn_save_card_change").click(function(){
    	$(card_append_target).empty();
    	var card_list = new Array();
    	var btn_html = "";  //作為產生button的html

    	$.each(card_list, function(index, item){
    		btn_html = "<button type='button' class='btn btn-info'>" + item.btn_text + "</button>";

    		$(card_append_target).append(btn_html);
    	});
    });

    //新增關鍵字
    //動態取得更新區域的第二種做法
    $(document).on('click', '.add-keyword', function(){
    	var neighbor_textbox = $(this).siblings("input");
    	var father_td = $(this).parent("div").parent("td");

    	//取得關鍵字
    	console.log($(neighbor_textbox).val());

    	//ajax回傳
    	// ajax_add_keyword();

    	//更新關鍵字td
    	//取得該設定的所有關鍵字，這邊先用一個示範
    	var all_keyword = [$(neighbor_textbox).val()];
    	console.log("father_td: " + father_td.length);
    	father_td.empty();
    	$.each(all_keyword, function(index, item){
    		console.log("all_keyword: " + all_keyword);
    		father_td.append("<button type='button' class='btn btn-info' style='margin: -3px 10px 0 0;'>" + item + "</button>");
    	});
    	//最後一個關鍵字後補上新增視窗
    	father_td.append('<div class="add-keyword-group">' +
			'<input  type="text" class="form-control" placeholder="輸入關鍵字">' +
			'<button type="button" class="btn btn-primary add-keyword"><i class="fas fa-plus"></i></button></div>');
    });
});

//更新table
//假設已經取得相關資料
function update_table() {
	var uncheck_cards = new Array();
	var check_cards = new Array();

	// 更新已選擇的對話方塊
	$("#tbl_uncheck tbody").empty();
	$.each(uncheck_cards, function(index, item){
		$("#tbl_uncheck tbody").append(
			$(document.createElement('input')).attr({
				id: item.id,
				name: item.name,
				value: item.value,
				type: 'checkbox'
			})
		);
	});

	// 更新未選擇的對話方塊
	$("#tbl_check tbody").empty();
	$.each(check_cards, function(index, item){
		$("#tbl_uncheck tbody").append(
			$(document.createElement('input')).attr({
				id: item.id,
				name: item.name,
				value: item.value,
				type: 'checkbox'
			})
		);
	});
}