<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use App\UsersSocialAccounts;
use App\FbPagesToken;
use App\FbMessengerPersonProfile;
use App\FbMessengerKeyWord;
use App\FbMessengerPersistentMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class BotController extends Controller
{

	public function accounts(){
	
		$getuseridtoken = Cache::get('user_id_token');

		$url = 'https://graph.facebook.com/v3.1/';
		$url_add_user_id = $url.$getuseridtoken['id'].'/accounts?access_token=';
		$url_finally_add_user_token = $url_add_user_id.$getuseridtoken['token'];

		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);
#		dd( $output['data'][0] );

		Cache::forever('fans_info', $output);

	}

	public function getfanskey(){

		$getfansinfo = Cache::get('fans_info')['data'][0];

		$url = 'https://graph.facebook.com/';
		$url_add_fans_id = $url.$getfansinfo['id'].'?fields=access_token&access_token=';
		$url_finally_add_user_token = $url_add_fans_id.$getfansinfo['access_token'];
		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);

		$this->fanskey = $output['access_token'];

		Cache::forever('fans_id_token', $output);	
		
#		dd($output);
	}

	public function fanswrite(){
		$getfansidtoken = Cache::get('fans_id_token');	
	
		$url_add_fans_id_token = 'https://graph.facebook.com/243534566448762_292651058203779/comments';
		
		$fans = [
			"message" => "Nian 測試",
			"access_token" => $getfansidtoken['access_token'] 
		];

		$ch = curl_init($url_add_fans_id_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fans));
		$output	= json_decode( curl_exec($ch) );
		curl_close($ch);

		dd( $output );	
	}


	public function pushfansarticle(){

		$getfansidtoken = Cache::get('fans_id_token');	
	
		$url_add_fans_id_token = 'https://graph.facebook.com/'.$getfansidtoken['id'].'/feed?access_token='.$getfansidtoken['access_token'];
		
		$fans = [
			"message" => "Test Push"
		];

		$ch = curl_init($url_add_fans_id_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fans));
		$output	= json_decode( curl_exec($ch) );
		curl_close($ch);	

		dd( $output );

	}

	public function setmessengerprofile(){
		
		$getfansidtoken = Cache::get('fans_id_token');	

		$messengerprofile = [
			"get_started" => [
				"payload" => "GoBot"
			],
			"greeting" => [
				[
					"locale"=>"default",
					"text" => "Hello"
				]
			],
			"whitelisted_domains" => [
			]
		];

#		$messengerprofile['whitelisted_domains'] = array('https://jnadtechmqtt.com/');

//Get get_started,greeting,whitelisted_domains

		$url = 'https://graph.facebook.com/v3.1/me/messenger_profile?fields=';
		$url_add_fields = $url.'get_started,greeting,whitelisted_domains&access_token=';
		$url_add_page_token = $url_add_fields.$getfansidtoken['access_token'];

		$ch = curl_init($url_add_page_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);

		dd($output);

//
		$messengerprofile['whitelisted_domains'] = $output['data'][0]['whitelisted_domains'];

		$url = 'https://graph.facebook.com/v3.1/me/messenger_profile?access_token=';
		$url_add_token = $url.$getfansidtoken['access_token'];

		$ch = curl_init($url_add_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messengerprofile));
		$output	= json_decode( curl_exec($ch) );
		curl_close($ch);		
	
		dd($output);

	}

	public function getmentionsfeed(){

		$getfansinfo = Cache::get('fans_info')['data'][0];

		$url = 'https://graph.facebook.com/v3.1/'.$getfansinfo['id'].'/feed?access_token=';

		$url_finally_add_user_token = $url.$getfansinfo['access_token'];

		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);
			
		dd( $output );

		Cache::forever('fans_post_infos', $output);

	}

	public function getmentionscomments(){

		$getfanspostinfos = Cache::get('fans_post_infos')['data'][0];
		$getfansidtoken = Cache::get('fans_id_token');	

		$url = 'https://graph.facebook.com/v3.1/'.$getfanspostinfos['id'].'/comments?field=from&access_token=';

		$url_finally_add_user_token = $url.$getfansidtoken['access_token'];


		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);

		Cache::forever('fans_post_comments', $output);

#		dd( $output );

	}

	public function getmentionscomments_message(){

		$getfanspostinfos = Cache::get('fans_post_infos')['data'][0];
		$getfanspostcomments = Cache::get('fans_post_comments')['data'][1];
		$getfansidtoken = Cache::get('fans_id_token');	

		$url = 'https://graph.facebook.com/'.$getfanspostinfos['id'].'/comments?access_token=';
		$url_add_fans_id_token = $url.$getfansidtoken['access_token'];

		$commentsmessage = [
			"message" => "Happy Friday! @[".$getfanspostcomments['from']['id']."]"
		];

		$ch = curl_init($url_add_fans_id_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($commentsmessage));
		$output	= json_decode( curl_exec($ch) );
		curl_close($ch);		

#		dd( $output );

	}

	public function getsubscribedapps(){
		
		## 取得粉絲團access_token
		$url = 'https://graph.facebook.com/v3.1/';
		$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=id,access_token&access_token=';

		$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
		
		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$page_detail = json_decode($output, true);
		
		// $getfansidtoken = Cache::get('fans_id_token');

		$url = 'https://graph.facebook.com/v3.1/'.Auth::user()->nowfbpage_id.'/subscriptions?access_token=';
		$url_finally_add_fans_token = $url.$page_detail['access_token'];
		$ch = curl_init($url_finally_add_fans_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);	

		dd( $output );

	}

	public function postsubscribedapps(){
		
		$getfansidtoken = Cache::get('fans_id_token');

		$url = 'https://graph.facebook.com/v3.1/'.$getfansidtoken['id'].'/subscribed_apps?access_token=';
		$url_finally_add_fans_token = $url.$getfansidtoken['access_token'];
	
		$ch = curl_init($url_finally_add_fans_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, true);
		$output = json_decode( curl_exec($ch) );
		curl_close($ch);

#		dd( $output );

	}

	public function delsubscribedapps(){
		
		// $getfansidtoken = Cache::get('fans_id_token');

		$url = 'https://graph.facebook.com/v3.1/'.Auth::user()->nowfbpage_id.'/subscribed_apps?access_token=';
		$url_finally_add_fans_token = $url.$page_detail['access_token'];
	
		$ch = curl_init($url_finally_add_fans_token);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch) );
		curl_close($ch);

#		dd( $output );

	}


	public function getfanslike(){

		$getfanspostinfos = Cache::get('fans_post_infos')['data'][0];
		$getfansidtoken = Cache::get('fans_id_token');	

#		dd( $getfanspostinfos );

		$url = 'https://graph.facebook.com/v3.1/'.$getfanspostinfos['id'].'/likes?access_token=';
		$url_finally_add_fans_token = $url.$getfansidtoken['access_token'];
		$ch = curl_init($url_finally_add_fans_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);	

#		dd( $output );

	}

	public function getcomments(){
		$getfanspostinfos = Cache::get('fans_post_infos')['data'][0];
		$getfansidtoken = Cache::get('fans_id_token');	

		$url = 'https://graph.facebook.com/v3.1/'.$getfanspostinfos['id'].'/comments?access_token=';
		$url_finally_add_fans_token = $url.$getfansidtoken['access_token'];
		$ch = curl_init($url_finally_add_fans_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode( curl_exec($ch), 1);
		curl_close($ch);	

#		dd( $output );

		Cache::forever('fans_comments_info', $output);
	}


	public function pushsubcomments(){

		$getfanscommentsinfo = Cache::get('fans_comments_info')['data'][1];
		$getfansidtoken = Cache::get('fans_id_token');	

		$url = 'https://graph.facebook.com/v3.1/'.$getfanscommentsinfo['id'].'/comments?access_token=';
		$url_finally_add_fans_token = $url.$getfansidtoken['access_token'];

		$subcomments = [
			"message" => "我是自動貼回回覆"
		];

		$ch = curl_init($url_finally_add_fans_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($subcomments));
		$output = json_decode( curl_exec($ch) );
		curl_close($ch);

		dd( $getfanscommentsinfo );

	}


	public function bot(Request $request)
    {

		Log::info($request->all());

/*
		if ($request->isMethod('get')) {
			$data = $request->all();

			Log::info($request->all());

			$id            = $data["entry"][0]["messaging"][0]["sender"]["id"];
			$senderMessage = $data["entry"][0]["messaging"][0]['message'];

			if (!empty($senderMessage)) {
				$this->sendTextMessage($id, "you pass");
			}
		}
		
		if ($request->isMethod('post')) {
		
			$data = $request->all();
			
			// $challenge = $_REQUEST['hub_challenge'];
			
			print_r(data);die();
			
		}
 */

    }

    private function sendTextMessage($recipientId, $messageText)
    {

		$messageData = [
			"messaging_type" => "RESPONSE",
            "recipient" => [
				"id" => $recipientId,
            ],
            "message"   => [
				"text" => $messageText,
			],
        ];

#		Log::info($messageData);

        $ch = curl_init('https://graph.facebook.com/v3.1/me/messages?access_token=' . env("PAGE_ACCESS_TOKEN"));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_exec($ch);
        curl_close($ch);
    }
	
	
	public function subscribedapps(Request $request)
	{
		## 取得粉絲團access_token
		$url = 'https://graph.facebook.com/v3.1/';
		$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=id,access_token&access_token=';

		$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
		
		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$page_detail = json_decode($output, true);
		
		if ($request->isMethod('post')) {
			
			$url = 'https://graph.facebook.com/v3.1/'.$page_detail['id'].'/subscribed_apps?access_token=';
			$url_finally_add_fans_token = $url.$page_detail['access_token'];
		
			$ch = curl_init($url_finally_add_fans_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = json_decode( curl_exec($ch) );
			curl_close($ch);
			
		}
		
		if ($request->isMethod('delete')) {
			
			$url = 'https://graph.facebook.com/v3.1/'.$page_detail['id'].'/subscribed_apps?access_token=';
			$url_finally_add_fans_token = $url.$page_detail['access_token'];
		
			$ch = curl_init($url_finally_add_fans_token);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = json_decode( curl_exec($ch) );
			curl_close($ch);
			
		}

	}
	
	public function deltest(Request $request)
    {
		$url = 'https://graph.facebook.com/v3.1/243534566448762/roles?admin_id=2219392691464570&access_token=';
		$url_finally_add_fans_token = $url.'EAADTUbcYAuABAFDUDaokpXZB8NqeclSOoBNnZC4q3P5rcmXnonZATrjCut4ErcKKbIX0l725v06VBfGJu7XM91Hf14AYKXeZA4Ad2bBIZAHEkUHr4d8Ea4ZBh5IpWFM1DPpic8stefj1J9b9fhHJRYzrpUeAtZBZAq4Aq7Q1veQwEXKZBd8ahFiY4qlLGhAAlaiwKo2jpzjzlqQZDZD';
	
		$ch = curl_init('https://graph.facebook.com/v3.1/243534566448762/roles?admin_id=2219392691464570&access_token=EAADTUbcYAuABAFDUDaokpXZB8NqeclSOoBNnZC4q3P5rcmXnonZATrjCut4ErcKKbIX0l725v06VBfGJu7XM91Hf14AYKXeZA4Ad2bBIZAHEkUHr4d8Ea4ZBh5IpWFM1DPpic8stefj1J9b9fhHJRYzrpUeAtZBZAq4Aq7Q1veQwEXKZBd8ahFiY4qlLGhAAlaiwKo2jpzjzlqQZDZD');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if($http_status == 200){
			print_r($output);
		}
		
		print_r($output);
		
	}
	
	public function persistentmenubtn(Request $request)
	{
		if ($request->isMethod('post')) {
		
			Validator::make($request->all(), [
				'text_func_btn_title' => 'required|string|max:255',
				'text_func_url' => 'url'
			])->validate();
			
			$count = FbMessengerPersistentMenu::whereNull('deleted_at')
												->where('page_id', Auth::user()->nowfbpage_id)
												->count();
			if($count < 3){
					
				$messengerPersistentMenu = new FbMessengerPersistentMenu([
											'page_id' => Auth::user()->nowfbpage_id,
											'mpm_title' => $request->text_func_btn_title,
											'mpm_url' => $request->text_func_url,
										]);

				$user = User::find(Auth::id());
				
				// print_r($request->text_func_url);
				
				$messengerPersistentMenu->user()->associate($user);
				$messengerPersistentMenu->save();
				
				
				echo true;
				
			}else{
			
				echo false;
				
			}
			
		}
		
		if ($request->isMethod('delete')) {
			
			// print_r($request->id);
			$deletedRows = FbMessengerPersistentMenu::where('id', $request->id)->where('page_id', Auth::user()->nowfbpage_id)->delete();
			
			if($deletedRows){
			
				echo true;
				
			}else{
			
				echo false;
				
			}
			
		}
		
	}
	
	
	public function persistentmenu(Request $request)
	{
		## 取得粉絲團access_token
		$url = 'https://graph.facebook.com/v3.1/';
		$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=id,access_token&access_token=';

		$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
		
		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$page_detail = json_decode($output, true);
		
		if ($request->isMethod('post')) {
			
			// print_r($request->fbPersistentwebtitle);
			// $fbPersistentwebtitle = $request->fbPersistentwebtitle;
			// $fbPersistentweburl = $request->fbPersistentweburl;
			$fbMessengerPersistentMenu = FbMessengerPersistentMenu::whereNull('deleted_at')
																	->where('page_id', Auth::user()->nowfbpage_id)
																	->get();
																	
			FbMessengerPersistentMenu::whereNull('deleted_at')
									  ->where('page_id', Auth::user()->nowfbpage_id)
									  ->update(['posted' => 1]);														
																	
																	
			// print_r($fbMessengerPersistentMenu);
			$arr = array();
			// for($i=0; $i<count($fbPersistentwebtitle); $i++){
				// if(!empty($fbPersistentwebtitle[$i]) && !empty($fbPersistentweburl[$i])){
					// $myObj = [
							  // 'type' => 'web_url',
							  // 'title' => $fbPersistentwebtitle[$i],
							  // 'url' => $fbPersistentweburl[$i],
							// ];
					// array_push($arr, $myObj);
				// }
			// }
			foreach($fbMessengerPersistentMenu as $persistentMenu){
				$myObj = [
						  'type' => 'web_url',
						  'title' => $persistentMenu->mpm_title,
						  'url' => $persistentMenu->mpm_url,
						];
				array_push($arr, $myObj);
			}

			// print_r(json_encode($arr));
			$arrr = array();
			$myObj = [
					  'locale' => 'default',
					  'composer_input_disabled' => false,
					  'call_to_actions' => $arr
					];
			array_push($arrr, $myObj);		

			$messageData = [
				"persistent_menu" => $arrr
			];
			$messageData = json_encode($messageData);	
			
			
			$url = 'https://graph.facebook.com/v3.1/me/messenger_profile?access_token=';
			$url_finally_add_fans_token = $url.$page_detail['access_token'];
		
			$ch = curl_init($url_finally_add_fans_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $messageData);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = json_decode( curl_exec($ch) );
			curl_close($ch);
			
			if(isset($output->result)){
				echo true;
			}
			// print_r($output);
			// return json_decode($output, true);
			
		}
		
		if ($request->isMethod('delete')) {
		
			FbMessengerPersistentMenu::whereNull('deleted_at')
									  ->where('page_id', Auth::user()->nowfbpage_id)
									  ->update(['posted' => 0]);		
		
			$arr = array();
			array_push($arr, "persistent_menu");	
			
			$messageData = [
				"fields" => $arr
			];
			
			$url = 'https://graph.facebook.com/v3.1/me/messenger_profile?access_token=';
			$url_finally_add_fans_token = $url.$page_detail['access_token'];
		
			$ch = curl_init($url_finally_add_fans_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = json_decode( curl_exec($ch) );
			curl_close($ch);
			
			// print_r($output);
			if(isset($output->result)){
				echo true;
			}
			
		}
		
	}

	public function webhook(Request $request)
    {

		if ($request->isMethod('get')) {

				$mode  = $request->get('hub_mode');
				$token = $request->get('hub_verify_token');

				if ($mode === "subscribe" && env('BOT_VERIFY_TOKEN') and $token === env('BOT_VERIFY_TOKEN')) {
					return response($request->get('hub_challenge'), 200);
				}

				return response("Invalid token!", 400);
		}
		
		if ($request->isMethod('post')) {

			$data = $request->all();
			Log::info($data);
			// die();
		
			// Messenger
			if(array_key_exists('messaging', $data["entry"][0])){
				
				if(array_key_exists('delivery', $data["entry"][0]["messaging"][0])){
					return response("", 200);
				}
				if(array_key_exists('read', $data["entry"][0]["messaging"][0])){
					return response("", 200);
				}
				if(array_key_exists('message', $data["entry"][0]["messaging"][0])){
					
					// text
					if(array_key_exists('text', $data["entry"][0]["messaging"][0]['message'])){
						Log::info('測試messengere');
						$page_id = $data["entry"][0]["id"];
						
						$sender_id = $data["entry"][0]["messaging"][0]['sender']['id'];
						$senderMessage = $data["entry"][0]["messaging"][0]['message']['text'];
						if ($page_id != $sender_id) {
							
							// 儲存使用者
							$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', $page_id)->first();
							$url = 'https://graph.facebook.com/v3.2/'.$sender_id.'?fields=first_name,last_name,profile_pic,gender&access_token=';
							$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
							
							$ch = curl_init($url_finally_add_fans_token);
							curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_FAILONERROR, true);
							$output = curl_exec($ch);
							$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							
							Log::info($output);
							if($http_status == 200){
								$json = json_decode($output, true);
								if(isset($json['locale'])){
									$mpp_locale = $json['locale'];
								}else{
									$mpp_locale = null;
								}
								if(isset($json['gender'])){
									$mpp_gender = $json['gender'];
								}else{
									$mpp_gender = null;
								}
								FbMessengerPersonProfile::updateOrCreate(
									[
										'page_id' => $page_id,
										'psid' => $sender_id
									],
									[
										'page_id' => $page_id,
										'psid' => $json['id'],
										'mpp_first_name' => $json['first_name'],
										'mpp_last_name' => $json['last_name'],
										'mpp_profile_pic' => $json['profile_pic'],
										'mpp_locale' => $mpp_locale,
										'mpp_gender' => $mpp_gender,
										'interaction' => strtotime('now')
									]
								);
							}else{
								$json = json_decode($output, true);
								Log::info($output);
								Log::info(json_decode($json['error'], true));
								// dd($json['error']);
								// $error = json_decode($json['error'], true);
								// Log::info($json['error']['message']);
							}
							$this->sendTextType($sender_id, $senderMessage, $page_id);
							// $this->sendCardMessenger($sender_id, $page_id);
						}
					}
				}
				// postback
				if(array_key_exists('postback', $data["entry"][0]["messaging"][0])){
					Log::info('測試postback');
					$page_id = $data["entry"][0]["id"];
					
					$sender_id = $data["entry"][0]["messaging"][0]['sender']['id'];
					$postback_payload = $data["entry"][0]["messaging"][0]['postback']['payload'];
					if($postback_payload == 'postback_payload'){
						$this->sendTextType($sender_id, $postback_payload, $page_id);
					}
				}
			}
			
			// Feed
			if(array_key_exists('changes', $data["entry"][0])){
				if(array_key_exists('from', $data["entry"][0]["changes"][0]["value"])){
					$item = $data["entry"][0]["changes"][0]["value"]["item"];
				
					// 文章點讚
					if($item == 'like'){
						Log::info('測試文章點讚');
						$page_id = $data["entry"][0]["id"];
						
						$sender_id = $data["entry"][0]["changes"][0]["value"]["from"]['id'];
						$verb = $data["entry"][0]["changes"][0]["value"]["verb"];
						
						if($verb == 'add'){
							$this->sendLikeMessenger($sender_id, $page_id);
						}
					}
					
					// 文章回覆
					if($item == 'comment'){
						Log::info('測試文章回覆');
						$page_id = $data["entry"][0]["id"];
						
						$sender_id = $data["entry"][0]["changes"][0]["value"]["from"]['id'];
						$comment_id = $data["entry"][0]["changes"][0]["value"]["comment_id"];
						$verb = $data["entry"][0]["changes"][0]["value"]["verb"];
						
						if($verb == 'add' && $page_id != $sender_id){
							$this->sendCommentMessenger($sender_id, $page_id, $comment_id);
						}
					}
				}
			
			
			}
			
			return response("", 200);
		
		}
		
    }
	
	private function sendCardMessenger($sender_id, $page_id)
    {
		$myObj = [
			[
				'type' => 'web_url',
				'url' => 'https://www.youtube.com/',
				'title' => 'web_url',
				'webview_height_ratio' => 'full'
			],
			[
				'type' => 'postback',
				'title' => 'postback_title',
				'payload' => 'postback_payload'
			] 
		];
		$buttons = json_encode($myObj);
		
		$myObj = [
			[
				'title' => '測試卡片標題',
				'image_url' => 'http://1.bp.blogspot.com/-vUixQD62Zus/VNI2kGHF4mI/AAAAAAAAF14/W_L4Fv2O930/s1600/SUPERdoraemon.gif',
				'subtitle' => '測試卡片副標題',
				'default_action' => [
					'type' => 'web_url',
					'url' => 'https://www.youtube.com/',
					'webview_height_ratio' => 'full'
				],
				'buttons' => $buttons
			],
		];
		$elements = json_encode($myObj);
		
		$messageData = [
			"recipient" => [
				'id' => $sender_id
			],
			"message" => [
				'attachment' => [
					'type' => 'template',
					'payload' => [
						'template_type' => 'generic',
						'sharable' => false,
						'image_aspect_ratio' => 'horizontal',
						'elements' => $elements
					]
				]
			]
		];
		
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', $page_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_exec($ch);
        curl_close($ch);
		
	}
	
	private function sendCommentMessenger($sender_id, $page_id, $comment_id)
    {
		$messageData = [
				"messaging_type" => "RESPONSE",
			"recipient" => [
				"id" => $sender_id,
			],
			"message"   => [
				"text" => '有什麼想詢問？',
			],
		];
		
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', $page_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_exec($ch);
        curl_close($ch);
		
		$messageData = [
			"message" => "有什麼想詢問？"
		];

		$url = 'https://graph.facebook.com/v3.1/'.$comment_id.'/comments?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_exec($ch);
        curl_close($ch);
		
	}
	
	private function sendLikeMessenger($sender_id, $page_id)
    {
		$messageData = [
				"messaging_type" => "RESPONSE",
			"recipient" => [
				"id" => $sender_id,
			],
			"message"   => [
				"text" => '有什麼想詢問？',
			],
		];
		
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', $page_id)->first();
		
		$url = 'https://graph.facebook.com/v3.1/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        curl_exec($ch);
        curl_close($ch);
		
	}
	
	private function sendTextType($sender_id, $senderMessage, $page_id)
    {
		
		$myObj = [
			'id' => $sender_id
		];
		$arrr = json_encode($myObj);		

		$markseen = [
			"recipient" => $arrr,
			"sender_action"   => 'mark_seen',
		];
		
		$typingon = [
			"recipient" => $arrr,
			"sender_action"   => 'typing_on',
		];
		
		$retrunText = '說出您的問題';
		
		$keyWords = FbMessengerKeyWord::whereNull('deleted_at')->where('page_id', $page_id)->get();
		if(count($keyWords) > 0){
			
			foreach($keyWords as $keyWord){
				if($keyWord->match == 1){
					if(strpos($keyWord->mkw_request, $senderMessage) !== false){
						$retrunText = $keyWord->mkw_response;
					}
				}
				if($keyWord->match == 0){
					if(strcmp($keyWord->mkw_request, $senderMessage) == 0){
						$retrunText = $keyWord->mkw_response;
					}
				}
			}
			
		}
		
		$messageData = [
			"messaging_type" => "RESPONSE",
			"recipient" => [
				"id" => $sender_id,
			],
			"message"   => [
				"text" => $retrunText
			],
			
		];
		
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', $page_id)->first();
		
		$url = 'https://graph.facebook.com/v3.2/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		if($http_status != 200){
			Log::info($output);
		}
		
		$url = 'https://graph.facebook.com/v3.2/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($typingon));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		if($http_status != 200){
			Log::info($output);
		}
		
		$url = 'https://graph.facebook.com/v3.2/me/messages?access_token=';
		$url_finally_add_fans_token = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url_finally_add_fans_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		if($http_status != 200){
			Log::info($output);
		}
		
		Log::info('傳送完成');
		
    }
	
	public function test(Request $request)
    {
		## 取得粉絲團access_token
		$url = 'https://graph.facebook.com/v3.1/';
		$url_add_user_id = $url.Auth::user()->nowfbpage_id.'?fields=id,access_token&access_token=';

		$url_finally_add_user_token = $url_add_user_id.Auth::user()->UsersSocialAccounts->provider_token;
		
		$ch = curl_init($url_finally_add_user_token);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$page_detail = json_decode($output, true);
		
		if ($request->isMethod('get')) {
			
			$url = 'https://graph.facebook.com/v3.1/'.Auth::user()->nowfbpage_id.'/subscriptions?access_token=';
			$url_finally_add_fans_token = $url.'232347917615840|Xa5JZLBRuqBynQDjTd-zNBnn4Uw';
		
			$commentsmessage = '{
			  "object": "page",
			  "callback_url": "https://jnadtechmqtt.com/webhook",
			  "fields": [
				"messages",
				"messaging_postbacks",
				"message_reads",
				"message_deliveries",
				"conversations",
				"feed",
				"birthday",
			  ],
			  "verify_token": "chatbotfbapi"
			}';
			

			$ch = curl_init($url_finally_add_fans_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $commentsmessage);
			$output	= json_decode( curl_exec($ch) );
			curl_close($ch);		
		
			// $ch = curl_init($url_finally_add_fans_token);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			// curl_setopt($ch, CURLOPT_POST, true);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, true);
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// $output = json_decode( curl_exec($ch) );
			// curl_close($ch);
			
			dd ($output);
			
			
		}
		
	}
	
}
