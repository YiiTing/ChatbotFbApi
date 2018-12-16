@extends('layouts.header')

<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/lottery-script.js') }}"></script>

@section('content')
	<div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-12">
                <h5>粉絲團抽獎</h5>
                <div style="border-top: 1px solid #343a40;"></div>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-2" style="padding-top: 5px;">
                <h5>輸入FB網址</h5>
            </div>
            <div class="col-md-8">
                <input type="text" name="" id="input_post_url" class="form-control" placeholder="輸入貼文網址">
            </div>
            <div class="col-md-2">
                <button type="button" id="btn_search_post" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp;搜尋貼文</button>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-md-12">
                <h5>篩選條件</h5>
                <div style="padding: 20px 60px;border: 1px solid #343a40;position: relative;">
                    <div class="row" style="margin: 0;">
                        <div class="col-md-12">
                            <p style="color: #007bff;font-weight: 600;font-size: 20px;">活動區間</p>
                        </div>
                    </div>
                    <div class="row" style="margin: 0;">
                        <div class="col-md-2" style="margin: auto 0;">
                            開始時間
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="" id="begin_date" placeholder="yyyy/mm/dd" class="form-control datepicker">
                        </div>
                        <div class="col-md-2" style="position: relative;">
                            <select id="begin_time_hour" class="form-control hour-selector">
                                <option>00</option>
                            </select>
                            <span class="time-select-colon">
                                :
                            </span>
                        </div>
                        <div class="col-md-2">
                            <select id="begin_time_minute" class="form-control minute-selector">
                                <option>00</option>
                            </select>
                        </div>
                    </div>
                    <div style="height: 20px;"></div>
                    <div class="row" style="margin: 0;">
                        <div class="col-md-2" style="margin: auto 0;">
                            結束時間
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="" id="end_date" placeholder="yyyy/mm/dd" class="form-control datepicker">
                        </div>
                        <div class="col-md-2" style="position: relative;">
                            <select id="end_time_hour" class="form-control hour-selector">
                                <option>00</option>
                            </select>
                            <span class="time-select-colon">
                                :
                            </span>
                        </div>
                        <div class="col-md-2">
                            <select id="id="end_time_minute" " class="form-control minute-selector">
                                <option>00</option>
                            </select>
                        </div>
                    </div>
                    <div style="height: 20px;"></div>
                    <div class="row" style="margin: 0;">
                        <div class="col-2">
                            <p style="margin-bottom: 5px;">輸入要抽出幾人</p>
                            <input type="number" name="" id="draw_count" class="form-control">
                        </div>
                        <div class="col-4">
                            <p style="margin-bottom: 5px;">搜尋特定留言者</p>
                            <input type="text" name="" id="user_id" class="form-control">
                        </div>
                        <div class="col-4">
                            <p style="margin-bottom: 5px;">搜尋特定留言</p>
                            <input type="text" name="" id="spec_message" class="form-control">
                        </div>
                        <div class="col-2">
                            <button type="button" id="btn_start_lottery" class="btn btn-success" style="width: 100%;position: absolute;bottom: 0;"><i class="far fa-list-alt"></i>&nbsp;開始抽獎</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-12" style="margin-bottom: 20px;">
                <h5 style="display: inline-block;margin-right: 20px;position: relative;top: 5px;">中獎名單</h5>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#messageZoomInModal">放大顯示</button>
            </div>
            <div class="col-12">
                <table class="table table-hover">
                    <thead style="background-color: #c3e6cb;">
                        <tr>
                            <th scope="col">序號</th>
                            <th scope="col">名字</th>
                            <th scope="col">留言內容</th>
                            <th scope="col">讚數</th>
                            <th scope="col">留言時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>測試粉絲團</td>
                            <td>ASD1123</td>
                            <td>1</td>
                            <td>2018-08-11&nbsp;6:29:34</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-12">
                <h5 style="margin-bottom: 20px;">留言列表</h5>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">排除重複留言</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                    <label class="form-check-label" for="inlineCheckbox2">只顯示有TAG人的留言</label>
                </div>
                <button type="button" class="btn btn-secondary"><i class="fas fa-copy"></i>&nbsp;複製表格內容</button>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-12">
                <table class="table table-hover">
                    <thead style="background-color: #bee5eb;">
                        <tr>
                            <th scope="col">序號</th>
                            <th scope="col">名字</th>
                            <th scope="col">留言內容</th>
                            <th scope="col">讚數</th>
                            <th scope="col">留言時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>測試粉絲團</td>
                            <td>ASD1123</td>
                            <td>1</td>
                            <td>2018-08-11&nbsp;6:29:34</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>測試粉絲團</td>
                            <td>ASD1123</td>
                            <td>1</td>
                            <td>2018-08-11&nbsp;6:29:34</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-12" style="text-align: center;">
                <nav aria-label="Page navigation example" style="display: inline-block;">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div style="height: 40px;"></div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="messageZoomInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">中獎名單</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <img src="image/fb-flag.png" style="width: 100px;margin-bottom: 20px;">
                        <h5 style="color: #dc3545;margin-bottom: 10px;">測試粉絲團</h5>
                        <p style="margin-bottom: 10px;">ASD1123</p>
                        <p style="margin-bottom: 10px;">2018-08-11&nbsp;6:29:34</p>
                    </div>
                    <table class="table table-hover">
                        <thead style="background-color: #c3e6cb;">
                            <tr>
                                <th scope="col">序號</th>
                                <th scope="col">名字</th>
                                <th scope="col">留言內容</th>
                                <th scope="col">讚數</th>
                                <th scope="col">留言時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>測試粉絲團</td>
                                <td>ASD1123</td>
                                <td>1</td>
                                <td>2018-08-11&nbsp;6:29:34</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
@endsection