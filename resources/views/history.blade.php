@extends('layouts.header')

@section('content')
    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-12">
                <h5>所有訊息</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <table class="table table-hover" style="text-align: center;">
                    <thead class="thead-dark">
                        <tr>
                            <th>發布狀態</th>
                            <th>訊息內容</th>
                            <th>發佈時間</th>
                            <th>發佈次數</th>
                            <th>閱讀次數</th>
                            <th>點擊次數</th>
                            <th>功能</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>已發佈</td>
                            <td>我是推播訊息測試</td>
                            <td>2018-08-17 20:11:09</td>
                            <td>2</td>
                            <td>2</td>
                            <td>1</td>
                            <td><i class="far fa-eye"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
@endsection