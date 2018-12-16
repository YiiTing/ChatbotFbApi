$(function() {
	//搜尋FB貼文
	$("#btn_search_post").click(function(){
		search_post_by_url($("#input_post_url").val());
	});

    // datepicker設定
    $(".datepicker").datepicker({
        dateFormat: "yy/mm/dd"
    });

    //設定小時和分鐘的select option
    initial_time_selector();

    //開始抽獎
    $("#btn_start_lottery").click(function(){
		starting_lottery();
    });

})

//用網址搜尋貼文
function search_post_by_url(post_url){
	console.log("post_url: " + post_url);
}

//由系統產生小時和分鐘
//因為我懶得打這麼多option(?
function initial_time_selector() {
    // 設定時
    var hour_seletors = $(".hour-selector");
    $.each(hour_seletors, function(index, selector) {
        $(selector).empty();

        for (var h = 0; h < 24; h++) {
            var hour_text = "x" + h;

            //個位數時間顯示時補0
            if (parseInt(h / 10) == 0) {
                hour_text = hour_text.replace("x", "0");
            } else {
                hour_text = hour_text.replace("x", "");
            }
            $(selector).append("<option value='" + h + "'>" + hour_text + "</option>");
        }
    });

    //設定分
    var minute_selectors = $(".minute-selector");
    $.each(minute_selectors, function(index, selector){
    	$(selector).empty();

		for (var m = 0; m < 60; m++) {
            var minute_text = "x" + m;

            //個位數時間顯示時補0
            if (parseInt(m / 10) == 0) {
                minute_text = minute_text.replace("x", "0");
            } else {
                minute_text = minute_text.replace("x", "");
            }
            $(selector).append("<option value='" + m + "'>" + minute_text + "</option>");
        }
    });
}

function starting_lottery(){
	var filter = new lottery_filter();

	console.log(filter.begin_date);
}

// constructor
function lottery_filter(){
	this.begin_date = $("#begin_date").val() | "1995/01/01";
	this.begin_time_hour = $("#begin_time_hour").val() | "0";
	this.begin_time_minute = $("#begin_time_minute").val() | "0";
	this.end_date = $("#end_date").val() | "1995/01/01";
	this.end_time_hour = $("#end_time_hour").val() | "0";
	this.end_time_minute = $("#end_time_minute").val() | "0";
	this.input_draw_count = $("#draw_count").val() | 0;
	this.user_id = $("#user_id").val() | "";
	this.spec_message = $("#spec_message").val() | "";
}