@extends('layouts.header')

@section('content')
    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-2" style="padding-top: 5px;">
                <h5>輸入FB貼文網址</h5>
            </div>
            <div class="col-md-8">
                <input type="text" name="" class="form-control" placeholder="輸入粉絲團網址">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp;搜尋</button>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-12">
                <h5>貼文列表</h5>
                <table class="table table-hover" style="text-align: center;">
                    <thead style="background-color: #bee5eb;">
                        <tr>
                            <th scope="col">貼文註解</th>
                            <th scope="col">留言回復數</th>
                            <th scope="col">私訊回復數</th>
                            <th scope="col">健康度</th>
                            <th scope="col">狀態</th>
                            <th scope="col">建立時間</th>
                            <th scope="col">功能</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>貼文：ASDASDADDADASD</th>
                            <td>8</td>
                            <td>8</td>
                            <td><i class="fas fa-check-circle" style="color: #28a745;"></i></td>
                            <td><i class="fas fa-circle" style="color: #dc3545;"></i></td>
                            <td>2018-08-11 06:29:14</td>
                            <td><button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection