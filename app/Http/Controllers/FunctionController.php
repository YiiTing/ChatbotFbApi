<?php

namespace App\Http\Controllers;

use Validator;
use App\FbPagesToken;
use App\FbMessengerPersonProfile;
use App\FbMessengerKeyWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\FbApiService;

class FunctionController extends Controller
{
	
	public function customerAllBot(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'customer_all' => 'required|numeric'
		])->validate();
		
		// 確定至少有一個定閱戶
		FbMessengerPersonProfile::whereNull('deleted_at')->where('page_id', $request->customer_all)->where('page_id', Auth::user()->nowfbpage_id)->firstOrFail();
		
		try{
			FbMessengerPersonProfile::whereNull('deleted_at')
				->where('page_id', $request->customer_all)
				->where('bot', 0)
				->update(
					[
						'bot' => 1
					]
				);
		}catch (\Exception $e){
			return $e->errorInfo;
		}
		
		return 'all';
	}

	public function customerBot(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'customer_id' => 'required|integer'
		])->validate();
		
		// 尋找原始Bot狀態
		$FbMessengerPersonProfile = FbMessengerPersonProfile::whereNull('deleted_at')->where('id', $request->customer_id)->where('page_id', Auth::user()->nowfbpage_id)->firstOrFail();
		
		// 更改Bot狀態
		if ($FbMessengerPersonProfile->bot == 1){
			try{
				FbMessengerPersonProfile::whereNull('deleted_at')
					->where('id', $request->customer_id)
					->update(
						[
							'bot' => 0
						]
					);
			}catch (\Exception $e){
				return $e->errorInfo;
			}
		}else{
			try{
				FbMessengerPersonProfile::whereNull('deleted_at')
					->where('id', $request->customer_id)
					->update(
						[
							'bot' => 1
						]
					);
			}catch (\Exception $e){
				return $e->errorInfo;
			}
		}
		
		return $request->customer_id;
	}
	
	public function customerBlock(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'customer_id' => 'required|integer'
		])->validate();
		
		// 尋找原始Bot狀態
		$FbMessengerPersonProfile = FbMessengerPersonProfile::whereNull('deleted_at')->where('id', $request->customer_id)->where('page_id', Auth::user()->nowfbpage_id)->firstOrFail();
		
		// 更改Bot狀態
		if ($FbMessengerPersonProfile->block == 1){
			try{
				FbMessengerPersonProfile::whereNull('deleted_at')
					->where('id', $request->customer_id)
					->update(
						[
							'block' => 0
						]
					);
			}catch (\Exception $e){
				return $e->errorInfo;
			}
		}else{
			try{
				FbMessengerPersonProfile::whereNull('deleted_at')
					->where('id', $request->customer_id)
					->update(
						[
							'block' => 1
						]
					);
			}catch (\Exception $e){
				return $e->errorInfo;
			}
		}
		
		return $request->customer_id;
	}
	
	public function keywordDefaultAdd(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'boxes' => 'required|array'
		])->validate();
		
		// 尋找預設關鍵字
		foreach($request->boxes as $id){
			$FbMessengerKeyWord = FbMessengerKeyWord::whereNull('deleted_at')->where('id', $id)->where('page_id', Auth::user()->nowfbpage_id)->firstOrFail();
		}
		
		foreach($request->boxes as $id){
			try{
				FbMessengerKeyWord::whereNull('deleted_at')
					->where('id', $id)
					->update(
						[
							'open' => 1
						]
					);
			}catch (\Exception $e){
				return $e->errorInfo;
			}
		}
		
		return $request->all();
	}
	
	public function keywordDefaultDelete(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'boxes' => 'required|array'
		])->validate();
		
		// 尋找預設關鍵字
		foreach($request->boxes as $id){
			$FbMessengerKeyWord = FbMessengerKeyWord::whereNull('deleted_at')->where('id', $id)->where('page_id', Auth::user()->nowfbpage_id)->firstOrFail();
		}
		
		foreach($request->boxes as $id){
			try{
				FbMessengerKeyWord::whereNull('deleted_at')
					->where('id', $id)
					->update(
						[
							'open' => 0
						]
					);
			}catch (\Exception $e){
				return $e->errorInfo;
			}
		}
		
		return $request->all();
		
	}
	
	public function keywordDefaultList(Request $request)
	{
		// 尋找預設關鍵字
		FbMessengerKeyWord::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->where('defcus', 0)->where('open', 1)->firstOrFail();
		
		// 預設關鍵字
		$defaultKeyWord = FbMessengerKeyWord::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->where('defcus', 0)->where('open', 1)->select('mkw_request')->get();
		
		return $defaultKeyWord;
		
	}
	
	public function keywordCustomAdd(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'neighbor' => 'required|string'
		])->validate();
	
		// session存取使用者關鍵字
		if ($request->session()->has('neighbor')) {
		
			$neighbors = session('neighbor');
			array_push($neighbors, $request->neighbor);
			$request->session()->put('neighbor', $neighbors);
			
		}else{
			
			$request->session()->put('neighbor', [$request->neighbor]);
			
		}
		
		return json_encode(session('neighbor'));
		
	}
	
	public function keywordCustomDelete(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'neighbor' => 'required|string'
		])->validate();
	
		// session存取使用者關鍵字
		if ($request->session()->has('neighbor')) {
		
			$neighbors = session('neighbor');
			$key = array_search($request->neighbor, $neighbors);
			if (false !== $key) {
				unset($neighbors[$key]);
			}
			$request->session()->put('neighbor', $neighbors);
			
			return json_encode(session('neighbor'));
			
		}
		
		return response()->json([
			'message' => 'Record not found',
		], 404);
		
	}
	
	public function keywordCustomSave(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'options' => 'required|integer',
			'keywordcustom' => 'required|string'
		])->validate();
		
		if ($request->session()->has('neighbor')) {
			
			// 存入資料庫
			try {
				$neighbors = session('neighbor');
				foreach($neighbors as $neighbor){
					$customKeyWord = FbMessengerKeyWord::updateOrCreate(
						[
							'page_id' => Auth::user()->nowfbpage_id,
							'mkw_request' => $neighbor
						],
						[
							'page_id' => Auth::user()->nowfbpage_id,
							'mkw_request' => $neighbor,
							'mkw_response' => $request->keywordcustom,
							'defcus' => 1,
							'match' => $request->options
						]
					);
				}
				
				FbMessengerKeyWord::whereNull('deleted_at')
					->where('page_id', Auth::user()->nowfbpage_id)
					->where('mkw_response', $request->keywordcustom)
					->update(
						[
							'match' => $request->options
						]
				);
				
				// 忘記session
				$request->session()->forget('neighbor');
				
				return $customKeyWord;
				
			} catch (\Exception $e) {
				
				return response()->json([
					'message' => $e->errorInfo,
				], 401);
				
			}
		}
		
		return response()->json([
			'message' => 'Record not found',
		], 404);
		
	}
	
	public function keywordCustomCancel(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'id' => 'required|string'
		])->validate();
		
		// 字串切割
		$str = explode('_', $request->id);
		
		// 取得資料
		$customKeyWord = FbMessengerKeyWord::whereNull('deleted_at')
							->where('id', $str[1])
							->where('page_id', Auth::user()->nowfbpage_id)
							->firstOrFail();
		
		// 刪除資料
		try {
			
			FbMessengerKeyWord::where('mkw_response', $customKeyWord->mkw_response)->where('page_id', Auth::user()->nowfbpage_id)->delete();
			
			return response()->json([
				'message' => $request->id,
			], 200);
			
		} catch (\Exception $e) {
				
			return response()->json([
				'message' => $e->errorInfo,
			], 401);
			
		}	
		
		return response()->json([
			'message' => 'Record not found',
		], 404);
	}
	
	public function lotteryCheckFeed(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'post_url' => 'required|url'
		])->validate();
		
		// 網址擷取
		preg_match('/story_fbid=[\w\-]+/m', $request->post_url, $matches);
		$story_fbid = explode('=', $matches[0]);
		
		// FB token
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		$url = 'https://graph.facebook.com/v3.2/'.Auth::user()->nowfbpage_id.'_'.$story_fbid[1].'/comments?summary=1&order=chronological&limit=25&access_token=';
		$url = $url.$FbPagesToken->long_provider_token;
	
		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		
		if($http_status == 200){
			
			$datas = json_decode($output);	
			// print_r($datas);die();
			
			if(property_exists($datas->paging, 'next')){
				$next = $datas->paging->next;
			}else{
				$next = 0;
			}
			if(property_exists($datas->paging, 'previous')){
				$previous = $datas->paging->previous;
			}else{
				$previous = 0;
			}
			
			return response()->json([
				'message' => $datas->data,
				'next' => $next,
				'previous' => $previous
			], 200);
		}else{
			return response()->json([
				'message' => 'Record not found',
			], 404);
		}
		
	}
	
	public function lotteryList(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'post_url' => 'required|url'
		])->validate();
		
		$ch = curl_init($request->post_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		
		if($http_status == 200){
			
			$datas = json_decode($output);	
			// print_r($datas);die();
			
			if(property_exists($datas->paging, 'next')){
				$next = $datas->paging->next;
			}else{
				$next = 0;
			}
			if(property_exists($datas->paging, 'previous')){
				$previous = $datas->paging->previous;
			}else{
				$previous = 0;
			}
			
			return response()->json([
				'message' => $datas->data,
				'next' => $next,
				'previous' => $previous
			], 200);
		}else{
			return response()->json([
				'message' => 'Record not found',
			], 404);
		}
		
	}
	
	public function lotteryStart(Request $request)
	{
		// https://www.facebook.com/permalink.php?story_fbid=322250975243787&id=243534566448762&__tn__=-R
		// 判斷請求格式
		Validator::make($request->all(), [
			'post_url' => 'required|url',
			'begin_date' => 'required|date',
			'begin_time_hour' => 'required|digits_between:0,23',
			'begin_time_minute' => 'required|digits_between:0,59',
			'end_date' => 'required|date',
			'end_time_hour' => 'required|digits_between:0,23',
			'end_time_minute' => 'required|digits_between:0,59',
			'draw_count' => 'required|integer|min:1',
			'user_id' => 'nullable|string',
			'spec_message' => 'nullable|string'
		])->validate();
		
		// 網址擷取
		preg_match('/story_fbid=[\w\-]+/i', $request->post_url, $matches);
		$story_fbid = explode('=', $matches[0]);
		
		// FB token
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		
		## 取得粉絲團資訊
		$url = 'https://graph.facebook.com/v3.2/'.Auth::user()->nowfbpage_id.'?fields=id,name,picture.type(large)&access_token=';
		$url = $url.$FbPagesToken->long_provider_token;
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($http_status == 200){
			$info = json_decode($output);
		}
		
		// 取得貼文內容
		$url = 'https://graph.facebook.com/v3.2/'.Auth::user()->nowfbpage_id.'_'.$story_fbid[1].'?access_token=';
		$url = $url.$FbPagesToken->long_provider_token;
		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		if($http_status == 200){
			$info->message = json_decode($output)->message;
			$info->createdtime = json_decode($output)->created_time;
		}
		
		// print_r($info);die();
		
		// 取得貼文回文
		$url = 'https://graph.facebook.com/v3.2/'.Auth::user()->nowfbpage_id.'_'.$story_fbid[1].'/comments?order=chronological&access_token=';
		$url = $url.$FbPagesToken->long_provider_token;
		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		
		if($http_status == 200){
			
			// 更改時區
			date_default_timezone_set('Asia/Taipei');
			// 資料處理
			$begin_date = strtotime($request->begin_date) + $request->begin_time_hour*3600 + $request->begin_time_minute*60;
			$end_date = strtotime($request->end_date) + $request->end_time_hour*3600 + $request->end_time_minute*60;
			$arrId = [];
			$datas = json_decode($output);
			
			foreach($datas->data as $data){
				// print_r(strtotime($data->created_time));
				$checkId = true;
				if(strtotime($data->created_time) < $begin_date || strtotime($data->created_time) > $end_date){
					$checkId = false;
				}
				
				if(!empty($request->user_id)){
					if(!preg_match('/'.trim($request->user_id).'/i', $data->from->name)){
						$checkId = false;
					}
				}
				if(!empty($request->spec_message)){
					if(!preg_match('/'.trim($request->spec_message).'/i', $data->message)){
						$checkId = false;
					}
				}
				
				if($checkId){
					array_push($arrId, $data->id);
				}
			}
			
			while(property_exists($datas->paging, 'next')){
				$ch = curl_init($datas->paging->next);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_POST, false);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				$output = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($http_status == 200){
					$datas = json_decode($output);
					foreach($datas->data as $data){
						$checkId = true;
						if(strtotime($data->created_time) < $begin_date || strtotime($data->created_time) > $end_date){
							$checkId = false;
						}
						
						if(!empty($request->user_id)){
							if(!preg_match('/'.trim($request->user_id).'/i', $data->from->name)){
								$checkId = false;
							}
						}
						if(!empty($request->spec_message)){
							if(!preg_match('/'.trim($request->spec_message).'/i', $data->message)){
								$checkId = false;
							}
						}
						
						if($checkId){
							array_push($arrId, $data->id);
						}
					}
				}else{
					return response()->json([
						'message' => 'Record not found',
					], 404);
				}
			}
			
			// 隨機抽籤
			if(count($arrId) < $request->draw_count){
				$arrRandoms = array_rand($arrId, count($arrId));
			}else{
				$arrRandoms = array_rand($arrId, $request->draw_count);
			}
			
			$arrResult = [];
			if($request->draw_count == 1 || count($arrId) == 1){
				// 取得中獎的貼文資訊
				$url = 'https://graph.facebook.com/v3.2/'.$arrId[$arrRandoms].'?fields=created_time,from,message,likes.summary(1)&access_token=';
				$url = $url.$FbPagesToken->long_provider_token;
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_POST, false);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				$output = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($http_status == 200){
					array_push($arrResult, json_decode($output));
				}else{
					return response()->json([
						'message' => 'Record not found',
					], 404);
				}
			}else{
				foreach($arrRandoms as $arrRandom){
					// 取得中獎的貼文資訊
					$url = 'https://graph.facebook.com/v3.2/'.$arrId[$arrRandom].'?fields=created_time,from,message,likes.summary(1)&access_token=';
					$url = $url.$FbPagesToken->long_provider_token;
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
					curl_setopt($ch, CURLOPT_POST, false);
					// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($markseen));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_FAILONERROR, true);
					$output = curl_exec($ch);
					$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);
					if($http_status == 200){
						array_push($arrResult, json_decode($output));
					}else{
						return response()->json([
							'message' => 'Record not found',
						], 404);
					}
				}
			}
			
			return response()->json([
				'message' => $arrResult,
				'info' => $info
			], 200);
			
		}else{
			return response()->json([
				'message' => 'Record not found',
			], 404);
		}
		
	}
	
	public function settingsubscribedappson(Request $request, FbApiService $fbapiservice)
	{
		if ($request->isMethod('post')) {
			
			$arr = ['feed', 'mention', 'name'];
			
			$data = [
				'subscribed_fields' => $arr
			];
			$data = json_encode($data);
			
			$response = $fbapiservice->postfbapiresponse('/subscribed_apps?access_token=', $data);
			// print_r($response);
			
		}
		
		// if ($request->isMethod('delete')) {
			
			// $url = 'https://graph.facebook.com/v3.1/'.$page_detail['id'].'/subscribed_apps?access_token=';
			// $url_finally_add_fans_token = $url.$page_detail['access_token'];
		
			// $ch = curl_init($url_finally_add_fans_token);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			// curl_setopt($ch, CURLOPT_POSTFIELDS, true);
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// $output = json_decode( curl_exec($ch) );
			// curl_close($ch);
			
		// }

	}
	
}
