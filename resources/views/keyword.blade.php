@extends('layouts.header')

@section('content')
	<script src="{{ asset('js/Keyword-script.js') }}"></script>
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
					<!--
                    <h5>開啟推播</h5>
					-->
                    <table class="table">
                        <tr>
                            <td style="width: 150px;line-height: 38px;">粉絲訊息</td>
                            <td>
                                <button type="button" class="btn btn-secondary" style="width: 200px;"><i class="far fa-dot-circle"></i>&nbsp;&nbsp;完全符合</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">關鍵字</td>
                            <td id="keyword-default-list">
								@if (count($defaultKeyWord) >0)
									@foreach ($defaultKeyWord as $default)
										@if ($default->open == 1)
										<button type="button" class="btn btn-outline-dark">
											{{ $default->mkw_request }}
										</button>
										@endif
									@endforeach
								@endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">呼叫關鍵字</td>
                            <td id="keyword-card1-list">
                                <button type="button" class="btn btn-primary btn-add-card" append-target="#keyword-card1-list">
                                    <i class="fas fa-plus"></i>&nbsp;新增預設關鍵字
                                </button>
                            </td>
                        </tr>
                    </table>
					<!--
                    <button type="button" class="btn btn-success" style="position: absolute;top: 0px;right: 0px;border-radius: 0;"><i class="far fa-save"></i></button>
					-->
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
					<!--
                    <h5>開啟推播</h5>
					-->
                    <table class="table">
                        <tr>
                            <td style="width: 150px;line-height: 38px;">粉絲訊息</td>
                            <td>
                                <div class="btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info active">
                                        <input type="radio" name="options" id="option1" value="0" autocomplete="off" checked> <i class="far fa-dot-circle"></i>&nbsp;&nbsp;完全符合
                                    </label>
									<!--
                                    <label class="btn btn-info">
                                        <input type="radio" name="options" id="option2" value="1" autocomplete="off">
                                        <i class="far fa-dot-circle"></i>&nbsp;&nbsp;部分符合
                                    </label>
									-->
                                    <label class="btn btn-info">
                                        <input type="radio" name="options" id="option3" value="1" autocomplete="off">
                                        <i class="far fa-dot-circle"></i>&nbsp;&nbsp;包含
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">關鍵字</td>
                            <td>
                                <div class='add-keyword-group'>
                                    <input style="" type="text" class="form-control" placeholder="輸入關鍵字">
                                    <button type="button" class="btn btn-primary add-keyword"><i class="fas fa-plus"></i></button>
                                </div>
								@if (Session::has('neighbor'))
									@foreach (Session::get('neighbor') as $neighbor)
									<button type='button' class='btn btn-outline-dark delete-keyword' value="{{ $neighbor }}" style='margin: 0 10px 0 0;'>{{ $neighbor }}</button>
									@endforeach
								@endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;line-height: 38px;">關鍵字回覆</td>
							<td>
                                <input type="text" class="form-control" name="keywordcustom" id="keywordcustom" placeholder="輸入關鍵字回覆">
                            </td>
                        </tr>
                    </table>
                    <div class="btn-group" role="group" aria-label="Basic example" style="position: absolute;right: 0px;top: 0px;">
						<!--
                        <button type="button" class="btn btn-warning" style="border-top-left-radius: 0;"><i class="fas fa-trash-alt"></i></button>
						-->
                        <button type="button" class="btn btn-success save-keyword" style="border-top-right-radius: 0;border-bottom-right-radius: 0;"><i class="far fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
		@isset ($customKeyWord)
		<div style="height: 20px;"></div>
		@foreach ($customKeyWord as $custom)
			<div class="row" id="cancel_{{ $custom->id }}">
				<div class="col-md-12">
					<div style="padding: 20px 60px;border: 1px solid #343a40;position: relative;">
						<table class="table">
							<tr>
								<td style="width: 150px;line-height: 38px;">粉絲訊息</td>
								<td>
									@if ($custom->match == 0)
									<button type="button" class="btn btn-secondary" style="width: 200px;"><i class="far fa-dot-circle"></i>&nbsp;&nbsp;完全符合</button>
									@elseif ($custom->match == 1)
									<button type="button" class="btn btn-secondary" style="width: 200px;"><i class="far fa-dot-circle"></i>&nbsp;&nbsp;包含</button>
									@else
									@endif
								</td>
							</tr>
							<tr>
								<td style="width: 150px;line-height: 38px;">關鍵字</td>
								<td id="keyword-default-list">
									@foreach ($customKeyWords as $customs)
										@if (strcmp($customs->mkw_response, $custom->mkw_response) == 0)
										<button type="button" class="btn btn-outline-dark">
											{{ $customs->mkw_request }}
										</button>
										@endif
									@endforeach
								</td>
							</tr>
							<tr>
								<td style="width: 150px;line-height: 38px;">呼叫關鍵字</td>
								<td>{{ $custom->mkw_response }}</td>
							</tr>
						</table>
						<div class="btn-group" role="group" aria-label="Basic example" style="position: absolute;right: 0px;top: 0px;">
							<button type="button" class="btn btn-warning cancel-keyword" value="cancel_{{ $custom->id }}" style="border-top-left-radius: 0;"><i class="fas fa-trash-alt"></i></button>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		@endisset
		<div style="height: 60px;"></div>
    </div>
    <div class="modal fade" id="modal_feedback_card" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">關鍵字列表</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>已選擇的關鍵字</h5>
                            <button id="btn_remove_checkbox" type="button" class="btn btn-info" disabled><i class="fas fa-minus-square"></i>&nbsp;移除關鍵字</button>
                            <div style="height: 20px;"></div>
                            <table id="tbl_uncheck" class="table table-hover table-first-center">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">操作</th>
                                        <th>關鍵字</th>
                                    </tr>
                                </thead>
                                <tbody>
									@if (count($defaultKeyWord) >0)
										@foreach ($defaultKeyWord as $default)
											@if ($default->open == 1)
											<tr id="{{ $default->id }}">
												<td>
													<input type="checkbox" class="uncheck" value="{{ $default->id }}" id="{{ $default->mkw_request }}">
												</td>
												<td>
													{{ $default->mkw_request }}
												</td>
											</tr>
											@endif
										@endforeach
									@endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>未選擇的關鍵字</h5>
                            <button type="button" id="btn_add_checkbox" class="btn btn-info" disabled><i class="fas fa-plus-square"></i>&nbsp;添加關鍵字</button>
                            <div style="height: 20px;"></div>
                            <table id="tbl_check" class="table table-hover table-first-center">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">操作</th>
                                        <th>關鍵字</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($defaultKeyWord) >0)
										@foreach ($defaultKeyWord as $default)
											@if ($default->open == 0)
											<tr id="{{ $default->id }}">
												<td>
													<input type="checkbox" class="check" value="{{ $default->id }}" id="{{ $default->mkw_request }}">
												</td>
												<td>
													{{ $default->mkw_request }}
												</td>
											</tr>
											@endif
										@endforeach
									@endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">完成</button>
					<!--
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" id="btn_save_card_change" class="btn btn-warning">儲存變更</button>
					-->
                </div>
            </div>
        </div>
    </div>
@endsection