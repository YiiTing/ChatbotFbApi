$(function() {
    //global
    // init
    gmanager = new group_manager();
    gmanager.create_group();
    gmanager.create_group();
    gmanager.create_group();
    group_displaying();

    //往上移
    $(document).on('click', '.group-move-up', function() {
        var group_id = $(this).parent().parent().parent("div").attr("group-id");
        console.log(group_id + " move up"); //取得要移動的群組ID
        group_moving(group_id, "up"); //移動群組
    });

    //往下移
    $(document).on('click', '.group-move-down', function() {
        var group_id = $(this).parent().parent().parent("div").attr("group-id");
        console.log(group_id + " move down"); //取得要移動的群組ID
        group_moving(group_id, "down"); //移動群組    	
    });

    //群組內新增卡片
    $(document).on('click', '.add_new_card', function() {
        var group_id = $(this).parent().parent("div").attr("group-id");
        console.log(group_id + " 新增卡片");

        var group = gmanager.get_group_by_id(group_id);
        group.cards.push("新增的卡片");
        group_displaying();
    });

    //新增群組
    $(document).on('click', '#btn_add_group', function() {
        gmanager.create_group();
        group_displaying();
    });

    //刪除群組
    $(document).on('click', '.btn-del-group', function() {
        var group_id = $(this).parent().parent().parent("div").attr("group-id");
        alert("刪除群組：" + group_id);

        gmanager.remove_group_by_id(group_id);
        group_displaying();
    });

    //改名群組
    //step1.開啟改名視窗
    $(document).on('click', '.btn-edit-name', function() {
        var group_id = $(this).parent().parent().parent("div").attr("group-id");
        var group_name = $(this).parent().parent().find(".side-list-header").text();
        editing_group_id = group_id;

        $("#edit_gorup_name_modal").modal('show');
        $("#old_group_name").text(group_name);

        $("body").css('padding', '0'); //避免跑版

        // var group_id = $(this).parent().parent().parent("div").attr("group-id");
        // console.log("群組改名!");


    });
    //step2.輸入新名稱後儲存
    $("#btn_change_name").click(function() {
        gmanager.update_group_name(editing_group_id, $("#input_new_name").val());
        group_displaying();

        $("#edit_gorup_name_modal").modal('hide');
        editing_group_id = null;
    });


    //儲存回應
    $("#save_message").click(function() {
        alert("回應已儲存!! \n" + $("#hash_url").text());
    });
})

//param1: 要移動的群組ID
//param2: 要移動的方向(fowawrd, backward)
function group_moving(gid, direction) {
    //取得現在位置
    var move_group = gmanager.get_group_by_id(gid);
    var move_group_sequence = gmanager.get_group_by_id(gid).sequence;

    //往上移
    if (direction == "up") {
        //群組第一個固定為預設
        if (move_group_sequence == 0) {
            alert('已到最頂層，無法移動!');
            return;
        } else {
            //對調順序
            move_group.sequence -= 1;
            gmanager.groups[move_group_sequence - 1].sequence += 1;

            // 重新顯示群組列表
            group_displaying();
        }
    } else if (direction == "down") {
        //群組第一個固定為預設
        if (move_group_sequence == gmanager.groups.length - 1) {
            alert('已到最底層，無法移動!');
            return;
        } else {
            //對調順序
            move_group.sequence += 1;
            gmanager.groups[move_group_sequence + 1].sequence -= 1;

            // 重新顯示群組列表
            group_displaying();
        }
    }
}

// 重新顯示群組列表
function group_displaying() {
    //除了預設群組以外都移除
    $(".side-list-group").not("[group-id='default']").remove();

    // 重排順序
    group_resorting();

    //顯示各群組
    $.each(gmanager.groups, function(index, group) {
        //用group id藉由ajax取得資料
        //var group = get_group_by_id(group_id);
        //依序顯示物件
        var html = '<div class="side-list-group" group-id="' + group.gid + '">' +
            '<div class="side-list-header">' +
            '<h5 class="side-list-header">' + group.name + '</h5>' +
            '<div>' +
            '<i class="fas fa-arrow-up group-move-up"></i>' +
            '<i class="fas fa-arrow-down group-move-down"></i> &nbsp;' +
            '<i class="far fa-edit btn-edit-name"></i>' +
            '<i class="far fa-trash-alt btn-del-group"></i>' +
            '</div>' +
            '</div><ul class="side-list">';

        $.each(group.cards, function(index, card) {
            html += '<li class="text-hover-black">' + card + '</li>';
        });

        //新增卡片按鈕
        html += '<li class="add_new_card text-hover-black" style="text-align: center;"><i class="fas fa-plus"></i></li>' +
            '</ul></div>';

        $(".side-list-div").append(html);
    });

    //新增群組
    $(".side-list-div").append('<div id="btn_add_group" class="side-list-group" style="color: #28a745;text-align: center;cursor: pointer;">新增群組</div>');
}

function group_resorting() {
    //先排序群組
    for (var i = 0; i < gmanager.groups.length - 1; i++) {
        for (var j = i + 1; j < gmanager.groups.length; j++) {
            if (gmanager.groups[i].sequence > gmanager.groups[j].sequence) {
                var temp_group = gmanager.groups[j];
                gmanager.groups[j] = gmanager.groups[i];
                gmanager.groups[i] = temp_group;
            }
        }
    }
}

function group_manager() {
    var gid_counter = 0; //自動PK
    this.groups = []; //儲存群組
    this.create_group = function() {
        var new_group = new group();
        new_group.name = "new group " + gid_counter;
        new_group.gid = "gid" + gid_counter;
        new_group.sequence = gid_counter;

        gid_counter++;
        this.groups.push(new_group);

        return new_group;
    };

    //用id取得group
    this.get_group_by_id = function(gid) {
        for (var i = 0; i < this.groups.length; i++) {
            if (this.groups[i].gid == gid) {
                return this.groups[i];
            }
        }
    };

    //移除group
    this.remove_group_by_id = function(gid) {
        var remove_group = this.get_group_by_id(gid);

        //從陣列中移除
        this.groups.splice(remove_group.sequence, 1);

        //調整順位
        for (var i = remove_group.sequence + 1; i < this.groups.length; i++) {
            this.groups[i].sequece -= 1;
        }
    }

    //重新命名group
    this.update_group_name = function(gid, new_name) {
        var group = this.get_group_by_id(gid);
        group.name = new_name;
    }
}

// object: 群組
function group() {
    this.name = "new group";
    this.gid = 0;
    this.sequence = 0;
    this.cards = ["歡迎訊息", "預設回應", "真人客服", "繼續購物"];
}