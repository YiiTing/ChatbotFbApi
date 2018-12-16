$(function() {
    $("#select_post_type").change(function() {
        $("#input_post_url, #input_post_number").toggle();
    });

    manager = new obj_feed_manager();
    manager.create_feed();
    display_all_feed();

	//增加卡片
    $("#btn_create_feed").click(function() {
        manager.create_feed();
        display_all_feed();
    });
})

function display_all_feed() {
	console.log(manager.feed_list);
	$("#feed_container").empty();
    $.each(manager.feed_list, function(index, item) {
        var html =
            '<div class="row" card-pid="' + item.pid + '">' +
            '<div class="col-md-12">' +
            '<div style="padding: 20px 60px;border: 1px solid #343a40;position: relative;">' +
            '<div class="form-group form-check">' +
            '<input type="checkbox" class="form-check-input need_keyword">' +
            '<label class="form-check-label">需要關鍵字</label>' +
            '</div>' +
            '<table class="table" style="margin-bottom: 0;">' +
            '<tr>' +
            '<td style="width: 150px;line-height: 38px;padding-left: 0;">粉絲訊息</td>' +
            '<td>' +
            '<select class="form-control message_type" style="max-width: 280px;">' +
            '<option value="1">完全符合</option>' +
            '<option value="2">部分符合</option>' +
            '<option value="3">包含</option>' +
            '</select>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td style="width: 150px;line-height: 38px;padding-left: 0;">關鍵字</td>' +
            '<td>' +
            '<div class="add-keyword-group">' +
            '<input type="text" class="form-control" placeholder="輸入關鍵字">' +
            '<button type="button" class="btn btn-primary add-keyword"><i class="fas fa-plus"></i></button>' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '</table>' +
            '<div style="border-top: 1px solid #b2b2b2;"></div>' +
            '<div style="height: 20px;"></div>' +
            '<div class="form-check">' +
            '<input type="checkbox" class="form-check-input need_tag">' +
            '<label class="form-check-label">需判斷標記人數</label>' +
            '</div>' +
            '<div style="height: 20px;"></div>' +
            '<div style="border-top: 1px solid #b2b2b2;"></div>' +
            '<div style="height: 20px;"></div>' +
            '<p>留言回覆內容</p>' +
            '<textarea rows="5" class="form-control feed_text" placeholder="*輸入 {{sender_name}} 即可在回覆內容中出現使用者姓名"></textarea>' +
            '<div style="height: 20px;"></div>' +
            '<div>' +
            '<label for="exampleFormControlFile1">回覆中附加的照片</label>' +
            '<input type="file" class="form-control-file" id="exampleFormControlFile1">' +
            '</div>' +
            '<div style="height: 20px;"></div>' +
            '<p>私訊回覆內容</p>' +
            '<textarea rows="5" class="form-control confidential_text" placeholder="*輸入 {{sender_name}} 即可在回覆內容中出現使用者姓名"></textarea>' +
            '<div class="btn-group" role="group" aria-label="Basic example" style="position: absolute;right: 0px;top: 0px;">' +
            '<button type="button" class="btn btn-warning" style="border-top-left-radius: 0;" del-card="' + item.pid + '"><i class="fas fa-trash-alt"></i></button>' +
            '<button type="button" class="btn btn-success" style="border-top-right-radius: 0;border-bottom-right-radius: 0;"><i class="far fa-clone"></i></button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div style="height: 20px;"></div>';

        $("#feed_container").append(html);

        // 設定屬性
        $("[card-pid='" + item.pid + "'] .need_keyword").prop("checked", item.is_need_keyword);
        $("[card-pid='" + item.pid + "'] .message_type").val(item.message_set);

        var all_keyword = item.key_words;
        var father_td = $("[card-pid='" + item.pid + "'] .add-keyword-group").parent("td");
        // console.log(father_td.length);
        $(father_td).empty();
        $.each(all_keyword, function(word_index, word) {
            $(father_td).append("<button type='button' class='btn btn-info' style='margin: -3px 10px 0 0;'>" + word + "</button>");
        });
        $(father_td).append('<div class="add-keyword-group">' +
            '<input  type="text" class="form-control" placeholder="輸入關鍵字">' +
            '<button type="button" class="btn btn-primary add-keyword" add-pid="' + item.pid + '"><i class="fas fa-plus"></i></button></div>');

        $("[card-pid='" + item.pid + "'] .need_tag").prop("checked", item.is_need_tag);
        $("[card-pid='" + item.pid + "'] .feed_text").val(item.feed_text);
        $("[card-pid='" + item.pid + "'] .confidential_text").val(item.confidential_text);
    });
}



//增加關鍵字
$(document).on('click', '.add-keyword', function() {
    var new_word = $(this).siblings("input").val();
    var feed = manager.get_feed_by_id($(this).attr("add-pid"));

    feed.key_words.push(new_word);
    display_all_feed();
});

//刪除卡片
$(document).on('click', '[del-card]', function() {
    manager.del_feed_by_id($(this).attr("del-card"));
    display_all_feed();
});




function checked_str(flag) {
    return flag == true ? "checked='true'" : "";
}

function obj_feed_manager() {
    this.pid_counter = 1;
    this.feed_list = [];
    this.create_feed = function() {
        var new_feed = new obj_feed(this.pid_counter);
        this.pid_counter++;
        this.feed_list.push(new_feed);
    };
    this.get_feed_by_id = function(pid) {
        for (var i = 0; i < this.feed_list.length; i++) {
            if (this.feed_list[i].pid == pid)
                return this.feed_list[i];
        }
    };
    this.del_feed_by_id = function(pid) {
    	
        for (var i = 0; i < this.feed_list.length; i++) {
            if (this.feed_list[i].pid == pid) {
            	this.feed_list.splice(i, 1);
            	return;
            }

        }
    }
}

function obj_feed(new_pid) {
    this.pid = new_pid;
    this.is_need_keyword = false;
    this.message_set = 1; //粉絲訊息：1.完全 2.部分 3.包含
    this.key_words = ["阿斯"];
    this.is_need_tag = false;
    this.feed_text = "一些留言回覆內容";
    this.upload_img = "";
    this.confidential_text = "一些私訊回覆內容";
}