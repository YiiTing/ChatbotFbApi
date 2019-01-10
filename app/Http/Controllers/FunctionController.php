<?php

namespace App\Http\Controllers;

use Validator;
use App\FbMessengerPersonProfile;
use App\FbMessengerKeyWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
	
}
