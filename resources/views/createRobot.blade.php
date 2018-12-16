@extends('layouts.header')

@section('content')
<link href="{{ asset('SmartWizard-master/dist/css/smart_wizard.css') }}" rel="stylesheet">
<link href="{{ asset('SmartWizard-master/dist/css/smart_wizard_theme_dots.css') }}" rel="stylesheet">

<script src="{{ asset('SmartWizard-master/dist/js/jquery.smartWizard.min.js') }}" defer></script>
<script type="text/javascript">
$(document).ready(function() {
	// Initialize the showStep event
	$("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
		if($('button.sw-btn-next').hasClass('disabled')){
			$('button.sw-btn-reset').show();
            $('button.sw-btn-finish').show();
        }else{
			$('button.sw-btn-reset').hide();
            $('button.sw-btn-finish').hide();                
        }
		if(stepNumber == 1){
			var page_id = new Array();
			$('input[name="pageid[]"]:checked').each(function(i) { page_id[i] = this.value; });
			if(page_id.length <= 0){
				location.href = "{{ url('/createRobot') }}" 
			}
		}
	});
	$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
		if(stepNumber == 0){
			var isStepValid = true;
			var page_id = new Array();
			$('input[name="pageid[]"]:checked').each(function(i) { page_id[i] = this.value; });
			if(page_id.length > 0){
				$.ajax({
					type: 'PUT',     
					url: '{{ url()->current() }}', 
					cache: false, 
					dataType: 'html',	
					data: {
						page_id : page_id,
					}, 
					success: function(data){
						$("#step2").html(data);
					},
					error : function(jqXHR, textStatus, errorThrown){
						isStepValid = false;
					}
				});
			}else{
				alert('選一個粉絲團或者更多');
				isStepValid = false;
			}
		}
		
		return isStepValid;
	});
	
	// Smart Wizard
	$('#smartwizard').smartWizard({
		selected: 0,  // Initial selected step, 0 = first step 
		keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
		autoAdjustHeight: true, // Automatically adjust content height
		cycleSteps: false, // Allows to cycle the navigation of steps
		backButtonSupport: false, // Enable the back button support
		useURLhash: true, // Enable selection of the step based on url hash
		lang: {  // Language variables
			next: '下一步',
			previous: '上一步',
		},
		toolbarSettings: {
			toolbarPosition: 'bottom', // none, top, bottom, both
			toolbarButtonPosition: 'left', // left, right
			showNextButton: true, // show/hide a Next button
			showPreviousButton: true, // show/hide a Previous button
			toolbarExtraButtons: [
				$('<button></button>').text('取消')
							.addClass('btn btn-danger sw-btn-cancel')
							.on('click', function(){ 
								location.href="{{ url('/robot') }}"                           
							}),		
				$('<button></button>').text('完成')
							.addClass('btn btn-info sw-btn-finish')
							.on('click', function(){ 
								$.ajax({
									type: 'POST',     
									url: '{{ url("saveRobot") }}', 
									cache: false, 
									dataType: 'text',	
									data: {
										all_page_id: $('#all_page_id').text()
									}, 
									success: function(data){
										if(data == 1){
											location.href="{{ url('/robot') }}";   
										}else{
											console.log(data);
											alert('建立失敗請重新整理，如不行請聯絡管理人員');
										}
									},
									error : function(jqXHR, textStatus, errorThrown){
										alert('系統異常,');
									}
								});                       
							}),		
			]
		}, 
		anchorSettings: {
			anchorClickable: false, // Enable/Disable anchor navigation
			enableAllAnchors: true, // Activates all anchors clickable all times
			markDoneStep: true, // add done css
			enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
		},            
		contentURL: '{{ url()->current() }}', // content url, Enables Ajax content loading. can set as data data-content-url on anchor
		contentCache: false,
		disabledSteps: [],    // Array Steps disabled
		errorSteps: [],    // Highlight step with errors
		hiddenSteps: [],  // Hidden steps
		theme: 'dots',
		transitionEffect: 'fade', // Effect on navigation, none/slide/fade
		transitionSpeed: '400'
	});
      
  }); 
</script>

<div class="container">
    <div class="row justify-content-center mt-5">
		<div id="smartwizard" style="width: 60%;">
			<ul>
				<li style="width: 30%;"><a href="#step1">Step 1<br /><small>連接粉絲團</small></a></li>
				<li style="width: 30%;"><a href="#step2">Step 2<br /><small>新增機器人</small></a></li>
			</ul>
	 
			<div class="mt-5">
				<div id="step1" class="">
					<h2 class="text-success">選擇要連結的粉絲頁</h2>
					<h5 class="text-muted">機器人將會在您選擇連結的粉絲團上運作，別擔心，您可隨時在設定頁取消連結</h5>
					@if (count($arr) > 0)
						<form class="mt-5 ml-5">
						@for ($i=0; $i<count($arr); $i++)
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="{{ $arr[$i]['id'] }}" id="pageid_{{ $arr[$i]['id'] }}" name="pageid[]" style="margin-top: 30px;width: 20px;height: 20px;">
								<label class="form-check-label container" for="pageid_{{ $arr[$i]['id'] }}">
									<div class="card">
										<div class="row">
											<div class="col-md-2">
												<img src="{{ $arr[$i]['picture']['data']['url'] }}" class="img-fluid" alt="{{ $arr[$i]['name'] }}">
											</div>
											<div class="col-md-10">
												<div class="card-block">
													<h4 class="card-title">{{ $arr[$i]['name'] }}</h4>
													<a class="card-text" href="{{ $arr[$i]['link'] }}" target="_blank">{{ $arr[$i]['link'] }}</a>
												</div>
											</div>
										</div>
									</div>
								</label>
							</div>
						@endfor
						<form>
					@else
						<h2 class="text-danger">目前尚無粉絲團</h2>
					@endif
				</div>
				<div id="step2" class="">
					<h2 class="text-danger">請重新設定</h2>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
