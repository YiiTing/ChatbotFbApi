@extends('layouts.header')

@section('content')
    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-8">
                <h5>機器人狀態</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <div style="display: flex;justify-content: space-between;">
                    <p style="color: #dc3545;margin: auto 0;">休眠：所有機器人功能停止（包含排程中推播）</p>
                    <button type="button" class="btn btn-secondary">開啟Bot</button>
                </div>
            </div>
            <div class="col-4">
                <h5>使用語系</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <button type="button" class="btn btn-primary">中</button>
                <button type="button" class="btn btn-primary">EN</button>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-12">
                <h5>連接粉絲頁</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <div style="display: flex;justify-content: space-between;">
                    <div>
                        <img src="{{ 'images/fb-flag.png' }}" style="height: 100px;margin-right: 20px;">
                        <a href="#">粉絲團</a>
                    </div>
                    <div style="margin: auto 0;">
                        <span>AA</span>&nbsp;
						<button type="button" class="btn btn-danger" id="btnDelFbPage">解除連結</button>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-6">
                <h5>常設功能表</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>私訊的對話框左下角預設有主選單，至多可設定五個基本連結，請在以下設定。</p>
                <div style="text-align: center;">
                    <p style="color: #007bff;">啟用：查詢訂單功能開啟</p>
                    <button type="button" class="btn btn-danger">關閉查詢訂單</button>
                </div>
            </div>
            <div class="col-6">
                <h5>設定管理員</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>可增減管理員，每個機器人至多可設定5位管理員(企業方案可設定10位)。</p>
                <button type="button" class="btn btn-primary">邀請管理員</button>
                <div style="height: 20px;"></div>
                <h5 style="color: #212529;">目前管理員</h5>
                <div style="height: 20px;"></div>
                <div>
                    <img src="{{ 'images/fb-flag.png' }}" style="height: 50px;border-radius: 50%;margin-right: 20px;display: inline-block;">
                    <p style="margin: auto 0;display: inline-block;">Nian Bao Zou (擁有者)</p>
                </div>
                <div style="height: 20px;"></div>
                <div style="display: flex;justify-content: space-between;">
                    <div>
                        <img src="{{ 'images/fb-flag.png' }}" style="height: 50px;border-radius: 50%;margin-right: 20px;display: inline-block;">
                        <p style="margin: auto 0;display: inline-block;">Nian Bao Zou (擁有者)</p>
                    </div>
                    <div style="margin: auto 0;">
                        <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-6">
                <h5>時區設定</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>發送推播訊息時，以此時區設定為準。</p>
                <select class="form-control">
                    <option>123</option>
                </select>
            </div>
            <div class="col-6">
                <h5>設定客服人員</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>可增減被通知人員，每個機器人至多可設定5位客服。</p>
                <button type="button" class="btn btn-primary">邀請客服人員</button>
            </div>
        </div>
        <div style="height: 40px;"></div>
        <div class="row">
            <div class="col-6">
                <h5>自動開啟BOT狀態</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>可設定多久時間後，訂閱戶的BOT狀態會自動開啟</p>
                <input type="text" name="" class="form-control" style="width: initial;display: inline-block;">
                <span>分鐘後</span>
                <button type="button" class="btn btn-primary">確定</button>
            </div>
            <div class="col-6">
                <h5>設定上班時間</h5>
                <div style="border-top: 1px solid #343a40;"></div>
                <div style="height: 20px;"></div>
                <p>你可以另行設定一個方塊，用來當作下班時間的預設回應</p>
                <input type="text" name="" class="form-control">
                <div style="height: 20px;"></div>
                <p>上班時間</p>
                <select style="width: 80px;">
                    <option>11</option>
                </select>
                :
                <select style="width: 80px;">
                    <option>11</option>
                </select>到
                <select style="width: 80px;">
                    <option>11</option>
                </select>
                :
                <select style="width: 80px;">
                    <option>11</option>
                </select>
                <div style="height: 20px;"></div>
                <p>非上班時間回應內容</p>
                <input type="text" name="" class="form-control">
            </div>
        </div>
        <div style="height: 40px;"></div>
    </div>
@endsection