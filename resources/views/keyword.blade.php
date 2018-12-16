@extends('layouts.header')

<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/Keyword-script.js') }}"></script>

@section('content')
	<div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-12">
                <h5>系統預設關鍵字</h5>
                <div style="border-top: 1px solid #343a40;"></div>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-12">
                <div style="padding: 20px 60px;border: 1px solid #343a40;position: relative;">
                    <h5>開啟推播</h5>
                    <table class="table">
                        <tr>
                            <td style="width: 150px;line-height: 38px;">粉絲訊息</td>
                            <td>
                                <button type="button" class="btn btn-secondary" style="width: 200px;"><i class="far fa-dot-circle"></i>&nbsp;&nbsp;完全符合</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">關鍵字</td>
                            <td>
                                <button type="button" class="btn btn-info">
                                    開啟推播
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">呼叫方塊</td>
                            <td id="keyword-card1-list">
                                <button type="button" class="btn btn-primary btn-add-card" append-target="#keyword-card1-list">
                                    <i class="fas fa-plus"></i>&nbsp;新增方塊
                                </button>
                            </td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-success" style="position: absolute;top: 0px;right: 0px;border-radius: 0;"><i class="far fa-save"></i></button>
                </div>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-12">
                <div style="padding: 20px 60px;border: 1px solid #343a40;position: relative;">
                    <h5>關閉推播</h5>
                    <table class="table">
                        <tr>
                            <td style="width: 150px;line-height: 38px;">粉絲訊息</td>
                            <td>
                                <button type="button" class="btn btn-secondary" style="width: 200px;"><i class="far fa-dot-circle"></i>&nbsp;&nbsp;完全符合</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">關鍵字</td>
                            <td>
                                <button type="button" class="btn btn-info">
                                    關閉推播
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">呼叫方塊</td>
                            <td id="keyword-card2-list">
                                <button type="button" class="btn btn-primary btn-add-card" append-target="#keyword-card2-list">
                                    <i class="fas fa-plus"></i>&nbsp;新增方塊
                                </button>
                            </td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-success" style="position: absolute;top: 0px;right: 0px;border-radius: 0;"><i class="far fa-save"></i></button>
                </div>
            </div>
        </div>
        <div style="height: 60px;"></div>
        <div class="row">
            <div class="col-md-12">
                <h5>關鍵字設定</h5>
                <div style="border-top: 1px solid #343a40;"></div>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="row">
            <div class="col-md-12">
                <div style="padding: 20px 60px;border: 1px solid #343a40;position: relative;">
                    <h5>開啟推播</h5>
                    <table class="table">
                        <tr>
                            <td style="width: 150px;line-height: 38px;">粉絲訊息</td>
                            <td>
                                <div class="btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> <i class="far fa-dot-circle"></i>&nbsp;&nbsp;完全符合
                                    </label>
                                    <label class="btn btn-info">
                                        <input type="radio" name="options" id="option2" autocomplete="off">
                                        <i class="far fa-dot-circle"></i>&nbsp;&nbsp;部分符合
                                    </label>
                                    <label class="btn btn-info">
                                        <input type="radio" name="options" id="option3" autocomplete="off">
                                        <i class="far fa-dot-circle"></i>&nbsp;&nbsp;包含
                                    </label>
                                </div>
                                (或是用select option)
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">關鍵字</td>
                            <td>
                                <div class='add-keyword-group'>
                                    <input style="" type="text" class="form-control" placeholder="輸入關鍵字">
                                    <button type="button" class="btn btn-primary add-keyword"><i class="fas fa-plus"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">呼叫方塊</td>
                            <td id="keyword-card3-list">
                                <button type="button" class="btn btn-primary btn-add-card" append-target="#keyword-card3-list">
                                    <i class="fas fa-plus"></i>&nbsp;新增方塊
                                </button>
                            </td>
                        </tr>
                    </table>
                    <div class="btn-group" role="group" aria-label="Basic example" style="position: absolute;right: 0px;top: 0px;">
                        <button type="button" class="btn btn-warning" style="border-top-left-radius: 0;"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-success" style="border-top-right-radius: 0;border-bottom-right-radius: 0;"><i class="far fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 60px;"></div>
    </div>
    <div class="modal fade" id="modal_feedback_card" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">方塊列表</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>已選擇的對話方塊</h5>
                            <button id="btn_remove_checkbox" type="button" class="btn btn-info" disabled><i class="fas fa-minus-square"></i>&nbsp;移除對話方塊</button>
                            <div style="height: 20px;"></div>
                            <table id="tbl_uncheck" class="table table-hover table-first-center">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">操作</th>
                                        <th>方塊名稱</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="uncheck" value="aaaaa" id="aa">
                                        </td>
                                        <td>
                                            aaaaa
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="uncheck" value="bbbbb" id="bb">
                                        </td>
                                        <td>
                                            bbbbb
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="uncheck" value="ccccc" id="cc">
                                        </td>
                                        <td>
                                            ccccc
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>未選擇的對話方塊</h5>
                            <button type="button" id="btn_add_checkbox" class="btn btn-info" disabled><i class="fas fa-plus-square"></i>&nbsp;添加對話方塊</button>
                            <div style="height: 20px;"></div>
                            <table id="tbl_check" class="table table-hover table-first-center">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">操作</th>
                                        <th>方塊名稱</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="check" value="11111" id="11">
                                        </td>
                                        <td>
                                            11111
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="check" value="22222" id="22">
                                        </td>
                                        <td>
                                            22222
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="check" value="33333" id="33">
                                        </td>
                                        <td>
                                            33333
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" id="btn_save_card_change" class="btn btn-warning">儲存變更</button>
                </div>
            </div>
        </div>
    </div>
@endsection