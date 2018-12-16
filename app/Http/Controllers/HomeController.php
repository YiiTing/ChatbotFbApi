<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use App\UsersSocialAccounts;
use App\FbPages;
use App\FbPagesToken;
use App\FbMessengerPersonProfile;
use App\FbMessengerPersistentMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Router;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
        // $this->middleware('auth');
    // }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function robot()
    {
		
		$FbPages = FbPages::whereNull('deleted_at')
					->where('user_id', Auth::id())
					->get();
		// print_r($FbPages);die();
		
		$arr = array();
		foreach($FbPages as $FbPage){
		
			## 用粉絲團page_id，獲取粉絲團資訊
			$url = 'https://graph.facebook.com/v3.2/';
			$url_add_user_id = $url.$FbPage->page_id.'?fields=id,name,picture.type(large)&access_token=';
			$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if($http_status == 200){
				$json = json_decode($output, true);
				array_push($arr, $json);
			}
		}
		
		// print_r($arr);die();
        return view('robot', compact('arr'));
    }
	
	public function createRobot(Request $request)
    {
	
		if ($request->isMethod('get')) {
			
			## 臉書登入後，顯示粉絲團列表
			$url = 'https://graph.facebook.com/v3.2/';
			$url_add_user_id = $url.Auth::user()->UsersSocialAccounts->provider_user_id.'/accounts?access_token=';
			$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			$arr = array();
			if($http_status == 200){
			
				$json = json_decode($output, true);
				$page_lists = $json['data'];
				foreach($page_lists as $page){
					## 判斷是否有粉絲團機器人
					$checkPage = FbPages::whereNull('deleted_at')
										->where('page_id', $page['id'])
										->first();	
					
					## 判斷是否有5個權限
					if(!$checkPage && count($page['tasks']) == 5){
						## 取得粉絲團資訊
						$url = 'https://graph.facebook.com/v3.2/';
						$url_add_user_id = $url.$page['id'].'?fields=id,name,picture.type(large),link&access_token=';
						$url_finally_add_user_token = $url_add_user_id.$page['access_token'];
						
						$ch = curl_init($url_finally_add_user_token);
						curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_FAILONERROR, true);
						$output = curl_exec($ch);
						$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						curl_close($ch);
						
						if($http_status == 200){
							$json = json_decode($output, true);
							array_push($arr, $json);
						}
					}	
									
				}
			}
			
			return view('createRobot', compact('arr'));
		
		}
		
		if ($request->isMethod('post')) {
		
			$step_number = $_REQUEST["step_number"];
			
		}
		
		if ($request->isMethod('put')) {
			
			## 用粉絲團page_id，獲取粉絲團資訊
			$html = '';
			foreach ($request->page_id as $page_id){
				$url = 'https://graph.facebook.com/v3.2/';
				$url_add_user_id = $url.$page_id.'?fields=id,name,picture.type(large),link&access_token=';
				$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
				
				$ch = curl_init($url_finally_add_user_token);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				$output = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				
				if($http_status == 200){
					$json = json_decode($output, true);
					$html .= '<div class="container">
								<div class="card">
									<div class="row">
										<div class="col-md-2">
											<img src="'.$json['picture']['data']['url'].'" class="img-fluid" alt="'.$json['name'].'">
										</div>
										<div class="col-md-10">
											<div class="card-block">
												<h4 class="card-title">'.$json['name'].'</h4>
												<a class="card-text" href="'.$json['link'].'">'.$json['link'].'</a>
											</div>
										</div>
									</div>
								</div>
							</div>';
				}
			}
			
			$html .= '<div id="all_page_id" style="display: none;">'.json_encode($request->page_id).'</div>';
			
			echo $html;
			
		}
		
    }
	
	public function saveRobot(Request $request)
    {
		$all_page_id = json_decode($request->all_page_id, true);
		
		## 儲存粉絲團
		foreach($all_page_id as $page_id){
		
			## 判斷是否有粉絲團機器人
			$page = FbPages::whereNull('deleted_at')
							->where('page_id', $page_id)
							->first();	
								
			if (!$page) {
				try {
					$page = new FbPages([
						'page_id' => $page_id,
						'creator' => 1
					]);

					$user = User::find(Auth::id());
					$page->user()->associate($user);
					$page->save();
				} catch (\Illuminate\Database\QueryException $e) {
					return $e->errorInfo;
				}
			}
		}
				
		return $page_id;
    }
	
	public function dashBoard(Request $request, $pageid = 0)
    {
		## 如果只打網址會導到robot
		if($pageid == 0){
			return redirect('robot');
		}
	
		## 判斷是否屬於自己的粉絲團id
		FbPages::whereNull('deleted_at')
					->where('user_id', Auth::id())
					->where('page_id', $pageid)
					->firstOrFail();							
		$user = User::find(Auth::id());
		$user->nowfbpage_id = $pageid;
		$user->save();
		
		## 使用長期權限取得粉絲團長期access_token
		$url = 'https://graph.facebook.com/v3.2/';
		$url_add_user_id = $url.$pageid.'?fields=id,access_token&access_token=';
		$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->long_provider_token;
		
		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if($http_status == 200){
			$page_token = json_decode($output, true);
			## 更新粉絲團長期access_token
			FbPagesToken::updateOrCreate(
				[
					'page_id' => $page_token['id'],
					'deleted_at' => null
				],
				[
					'long_provider_token' => $page_token['access_token']
				]
			);
			
			## 取得粉絲團資訊
			$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', $pageid)->first();
			
			$url = 'https://graph.facebook.com/v3.2/';
			$url_add_user_id = $url.$pageid.'?fields=id,name,picture.type(large),fan_count,link,new_like_count,access_token,is_webhooks_subscribed,checkins,is_messenger_platform_bot,talking_about_count,unread_message_count&access_token=';
			$url_finally_add_user_token = $url_add_user_id.$FbPagesToken->long_provider_token;
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if($http_status == 200){
				$page_detail = json_decode($output, true);
			}
		}
		
		return view('dashBoard', compact('page_detail'));
    }
	
	public function customer(Request $request)
    {
		// 訂閱戶資料
		$FbMessengerPersonProfiles = FbMessengerPersonProfile::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->paginate(25);

        return view('customer', compact('FbMessengerPersonProfiles'));
    }
	
	public function feed()
    {
		
		if ($request->isMethod('get')) {
			## 取得粉絲團資訊
			$url = 'https://graph.facebook.com/v3.1/';
			$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=id,name,picture,link,is_webhooks_subscribed,access_token&access_token=';
			$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			$page_detail = '';
			if($http_status == 200){
				$page_detail = json_decode($output, true);
			}
			
			
		
			return view('feed');
			
		}
		
    }
	
	public function history()
    {
        return view('history');
    }
	
	public function keyword()
    {
        return view('keyword');
    }
	
	public function lottery()
    {
        return view('lottery');
    }
	
	public function message()
    {
        return view('message');
    }
	
	public function setting(Request $request)
    {
		
		if ($request->isMethod('get')) {
			## 取得粉絲團access_token
			$url = 'https://graph.facebook.com/v3.1/';
			$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=access_token&access_token=';
			$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			$page_token = '';
			if($http_status == 200){
				$page_token = json_decode($output, true);
			}
			
			## 取得粉絲團資訊
			$url = 'https://graph.facebook.com/v3.1/';
			$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=id,name,picture,link,is_webhooks_subscribed,access_token&access_token=';

			$url_finally_add_user_token = $url_add_user_id.$page_token['access_token'];
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			$page_detail = '';
			if($http_status == 200){
				$page_detail = json_decode($output, true);
			}
			
			## 創始人
			$creator = FbPages::whereNull('deleted_at')
									->where('page_id', Auth::user()->nowfbpage_id)
									->where('creator', 1)
									->first();	
			## 管理員名單
			$url = 'https://graph.facebook.com/v3.1/';
			$url_add_user_id = $url.Auth::user()->nowfbpage_id.'/roles?access_token=';

			$url_finally_add_user_token = $url_add_user_id.$page_detail['access_token'];
			
			$ch = curl_init($url_finally_add_user_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			$output = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if($http_status == 200){
				$admin_lists = json_decode($output, true);
				$admin_lists = $admin_lists['data'];
			}
			// print_r($creator);die();
			$fbMessengerPersistentMenu = FbMessengerPersistentMenu::whereNull('deleted_at')
																	->where('page_id', Auth::user()->nowfbpage_id)
																	->get();	
			$countfbMessengerPersistentMenu = FbMessengerPersistentMenu::whereNull('deleted_at')
																	->where('page_id', Auth::user()->nowfbpage_id)
																	->where('posted', 1)
																	->count();														
			
			return view('setting', compact('page_detail', 'creator', 'admin_lists', 'fbMessengerPersistentMenu', 'countfbMessengerPersistentMenu'));
		}
			
    }
	
	public function cbm(Request $request)
    {
		$myObj = [
			[
				'type' => 'web_url',
				'url' => 'https://www.youtube.com/',
				'title' => 'web_url',
				'webview_height_ratio' => 'full'
			]
		];
		$buttons = json_encode($myObj);
	
		$myObj = [
			[
				'title' => 'Welcome to Our Marketplace!',
				'image_url' => 'http://1.bp.blogspot.com/-vUixQD62Zus/VNI2kGHF4mI/AAAAAAAAF14/W_L4Fv2O930/s1600/SUPERdoraemon.gif',
				'subtitle' => 'Fresh fruits and vegetables. Yum.',
				'buttons' => $buttons
			]
		];
		$elements = json_encode($myObj);
	
	
		$messageData = [
			"messages" => [
				[
					'dynamic_text' => [
						'text' => 'Hi, {{first_name}}!  測試測試測試測試測試測試測試測試測試測試',
						'fallback_text' => 'Hello friend!'
					]
				],
				// [
					// 'attachment' => [
						// 'type' => 'template',
						// 'payload' => [
							// 'template_type' => 'generic',
							// 'elements' => $elements
						// ]
					// ]
				// ]
			],
		];
		Log::info('傳送的資料');
		Log::info($messageData);
		
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/message_creatives?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        $message_creative_id = curl_exec($ch);
        curl_close($ch);
		
		Log::info('回傳的資料');
		Log::info($message_creative_id);
		
    }
	
	public function tbm(Request $request)
    {
		$messageData = [
			"name" => 'test'
		];
	
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/custom_labels?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        $id = curl_exec($ch);
        curl_close($ch);
		
		Log::info('回傳的標籤');
		Log::info($id);
	}
	
	public function alp(Request $request)
    {
		// '2157339464339913', '1837488289667818'
		$messageData = [
			"user" => '1837488289667818'
		];
	
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/2491185250908087/label?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        $success = curl_exec($ch);
        curl_close($ch);
		
		Log::info('連結確認');
		Log::info($success);
	}
	
	public function sbm(Request $request)
    {
		$messageData = [
			"message_creative_id" => '724984311219982',
			// "message_creative_id" => '560548674391411',
			"notification_type" => 'REGULAR',
			"messaging_type" => 'MESSAGE_TAG',
			"tag" => 'NON_PROMOTIONAL_SUBSCRIPTION',
			"custom_label_id" => '2491185250908087'
		];
	
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/broadcast_messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        $broadcast_id = curl_exec($ch);
        curl_close($ch);
		
		Log::info('回傳的專屬編號');
		Log::info($broadcast_id);
	}
	
	public function smm(Request $request)
    {
		$messageData = [
				"messaging_type" => "RESPONSE",
			"recipient" => [
				"id" => '2007843769236400'
			],
			"message"   => [
				"text" => '有什麼想詢問？',
			],
		];
	
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        $broadcast_id = curl_exec($ch);
        curl_close($ch);
		
		Log::info('回傳的訊息');
		Log::info($broadcast_id);
	}
	
}
