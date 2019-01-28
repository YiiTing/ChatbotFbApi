$(function() {
	//確認FB貼文
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

// 留言列表
function list_post_by_url(post_url){
	console.log("post_url: " + post_url);
	$.ajax({
		type : 'POST',
		url : '/lotteryList',
		data : {
			post_url : post_url,
		},
		datatype : 'json',
		beforeSend : function(jqXHR, settings){
			$( '#lotteryList' ).find('tbody').html('');
		},
		success : function(res){
			console.log("Log: "+ res.message);
			$( ".lotteryListBar" ).show();
			res.message.forEach(function(element, i) {
				$('#lotteryList').find('tbody').append( '<tr><th scope="row">'+i+'</td><td>'+element.from.name+'</td><td>'+element.message+'</td><td>'+(new Date(element.created_time)).toLocaleString('zh-TW')+'</td></tr>' );
			});
			$('#lotteryListPrevious').attr('onclick', 'list_post_by_url("'+res.previous+'")');
			$('#lotteryListNext').attr('onclick', 'list_post_by_url("'+res.next+'")');
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

//用網址確認貼文
function search_post_by_url(post_url){
	console.log("post_url: " + post_url);
	$.ajax({
		type : 'POST',
		url : '/lotteryCheckFeed',
		data : {
			post_url : post_url,
		},
		datatype : 'json',
		beforeSend : function(jqXHR, settings){
			$( "#btn_search_check" ).hide();
			$( "#btn_search_times" ).hide();
			$( '#lotteryList' ).find('tbody').html('');
		},
		success : function(res){
			console.log("Log: "+ res.message);
			$( "#btn_search_check" ).show();
			$( ".lotteryListBar" ).show();
			res.message.forEach(function(element, i) {
				$('#lotteryList').find('tbody').append( '<tr><th scope="row">'+i+'</td><td>'+element.from.name+'</td><td>'+element.message+'</td><td>'+(new Date(element.created_time)).toLocaleString('zh-TW')+'</td></tr>' );
			});
			$('#lotteryListPrevious').attr('onclick', 'list_post_by_url("'+res.previous+'")');
			$('#lotteryListNext').attr('onclick', 'list_post_by_url("'+res.next+'")');
		},
		error : function(jqXHR, textStatus, errorThrown){
			$( "#btn_search_times" ).show();
			$( ".lotteryListBar" ).hide();
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

// function timeformat(date1) {
  // var date=new Date(date1);
  // var month = date.toLocaleString('zh-TW', { month: 'long' });
  // var mdate  =date.getDate();
  // var year  =date.getFullYear();
  // var hours = date.getHours();
  // var minutes = date.getMinutes();
  // var ampm = hours >= 12 ? 'pm' : 'am';
  // hours = hours % 12;
  // hours = hours ? hours : 12; // the hour '0' should be '12'
  // minutes = minutes < 10 ? '0'+minutes : minutes;
  // var strTime = mdate+"-"+month+"-"+year+" "+hours + ':' + minutes + ' ' + ampm;
  // return strTime;
// }

function starting_lottery(){
	var filter = new lottery_filter();

	console.log(filter.begin_date);
	
	$.ajax({
		type : 'POST',
		url : '/lotteryStart',
		data : {
			post_url : $("#input_post_url").val(),
			begin_date : $("#begin_date").val(),
			begin_time_hour : $("#begin_time_hour").val(),
			begin_time_minute : $("#begin_time_minute").val(),
			end_date : $("#end_date").val(),
			end_time_hour : $("#end_time_hour").val(),
			end_time_minute : $("#end_time_minute").val(),
			draw_count : $("#draw_count").val(),
			user_id : $("#user_id").val(),
			spec_message : $("#spec_message").val()
		},
		datatype : 'json',
		beforeSend : function(jqXHR, settings){
			$('#startLottery').hide();	
			$('#lotteryResult').find('tbody').html('');
			$('#lotteryResultZoom').find('tbody').html('');
		},
		success : function(res){
			console.log("Log: "+ res);
			res.message.forEach(function(element, i) {
				$('#lotteryResult').find('tbody').append( '<tr><td>'+i+'</td><td>'+element.from.name+'</td><td>'+element.message+'</td><td>'+element.likes.summary.total_count+'</td><td>'+(new Date(element.created_time)).toLocaleString('zh-TW')+'</td></tr>' );
				$('#lotteryResultZoom').find('tbody').append( '<tr><th scope="row">'+i+'</th><td>'+element.from.name+'</td><td>'+element.message+'</td><td>'+element.likes.summary.total_count+'</td><td>'+(new Date(element.created_time)).toLocaleString('zh-TW')+'</td></tr>' );
			});
			$('#lotteryImgZoom').attr('src', res.info.picture.data.url);
			$('#lotteryNameZoom').html(res.info.name);
			$('#lotteryMessageZoom').html(res.info.message);
			$('#lotteryTimeZoom').html((new Date(res.info.createdtime)));
			
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
		complete : function(jqXHR, textStatus){
			$('#startLottery').show();
		}
	});
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