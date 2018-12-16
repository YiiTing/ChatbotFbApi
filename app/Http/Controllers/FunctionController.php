<?php

namespace App\Http\Controllers;

use Validator;
use App\FbMessengerPersonProfile;
use Illuminate\Http\Request;

class FunctionController extends Controller
{
	
	public function customerAllBot(Request $request)
	{
		// 判斷請求格式
		Validator::make($request->all(), [
			'customer_all' => 'required|numeric',
		])->validate();
		
		// 確定至少有一個定閱戶
		FbMessengerPersonProfile::whereNull('deleted_at')->where('page_id', $request->customer_all)->firstOrFail();
		
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
			'customer_id' => 'required|integer',
		])->validate();
		
		// 尋找原始Bot狀態
		$FbMessengerPersonProfile = FbMessengerPersonProfile::whereNull('deleted_at')->where('id', $request->customer_id)->firstOrFail();
		
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
			'customer_id' => 'required|integer',
		])->validate();
		
		// 尋找原始Bot狀態
		$FbMessengerPersonProfile = FbMessengerPersonProfile::whereNull('deleted_at')->where('id', $request->customer_id)->firstOrFail();
		
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
	
}
