<!DOCTYPE html>
<html>

<head>
    <title>Chatisfy Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="my-css.css">
    <script type="text/javascript" src="bootstrap4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="fontawesome-free-5.2.0-web/css/all.css">
    <script type="text/javascript" src="scripts/feed-edit-script.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <a class="navbar-brand" href="#"><i class="fas fa-robot" style="font-size: 34px;color: #ffffff;"></i></a>
        <ul class="navbar-nav main-nav">
            <li class="nav-item">
                <a class="nav-link" href="Dashboard.html"><i class="fas fa-tachometer-alt"></i><br/>主選單</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Customer.html"><i class="fas fa-heart"></i><br/>訂閱戶</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Lottery.html"><i class="fas fa-award"></i><br/>抽獎活動</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Message.html"><i class="fas fa-comments"></i><br/>自動回應</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-broadcast-tower" style="font-size: 18px;"></i><br/>
                推播訊息
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">發送訊息</a>
                    <a class="dropdown-item" href="History.html">所有訊息</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Keyword.html"><i class="fas fa-key"></i><br/>關鍵字</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Feed.html"><i class="fas fa-comment-alt"></i><br/>貼文回覆</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Setting.html"><i class="fas fa-cog"></i><br/>bot設定</a>
            </li>
        </ul>
        <div style="color: #ffffff;">
            <i class="far fa-check-circle" style="font-size: 38px;"></i>&nbsp;
            <span style="line-height: 39px;vertical-align: bottom;">AA</span>
        </div>
    </nav>
    <div class="container" style="margin-top: 40px;margin-bottom: 60px;">
        <div class="row">
            <div class="col-md-12">
                <h5>貼文設定</h5>
                <div style="border-top: 1px solid #343a40;"></div>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-2" style="padding-top: 5px;">
                <p>選擇貼文方式</p>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="select_post_type">
                    <option value="url">使用貼文清單</option>
                    <option value="number">貼上貼文編號</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2" style="padding-top: 5px;">
                <p>輸入FB貼文網址</p>
            </div>
            <div class="col-md-10" id="input_post_url">
                <div class="row">
                    <div class="col-md-10">
                        <select class="form-control">
                            <option>請選擇需要設定的貼文</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary">檢視貼文</button>
                    </div>
                </div>
            </div>
            <div class="col-md-10" id="input_post_number" style="display: none;">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="" class="form-control" placeholder="請在此輸入你的貼文編號">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary">提交貼文</button>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div style="border-top: 1px solid #343a40;"></div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-2" style="padding-top: 5px;">
                <p>貼文註解</p>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control">
            </div>
            <div class="col-md-12">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">自動對留言按讚</label>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-md-12">
                <h5>回覆內容設定</h5>
                <div style="border-top: 1px solid #343a40;"></div>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-12" style="text-align: center;padding: 1rem 0;">
                <i id="btn_create_feed" class="fas fa-plus-circle gray-icon-btn" style="font-size: 40px;"></i>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div id="feed_container">
            
        </div>
    </div>
</body>

</html>