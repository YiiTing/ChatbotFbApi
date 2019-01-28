<?php

namespace App\Services;

use App\FbPagesToken;
use Illuminate\Support\Facades\Auth;

Class FbApiService
{
	protected $fbPagesToken;
	protected $url;
    protected $headers;
	
	public function __construct()
    {
		// FB token
		$FbPagesToken = FbPagesToken::whereNull('deleted_at')->where('page_id', Auth::user()->nowfbpage_id)->first();
		$this->fbPagesToken = $FbPagesToken->long_provider_token;
		
		// url
        $this->url = 'https://graph.facebook.com/v3.1';
        $this->headers = ["Content-Type: application/json"];
    }
	
	private function getfbapi(String $middleurl = null)
    {
		// 全部網址
		$fullurl = $this->url.$middleurl.$this->fbPagesToken;
		
		$ch = curl_init($fullurl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if($output && $http_status === 200){
			return $output; 
		}else{
			// 錯誤處理
			return null;
		}
    }
	
	private function getpnfbapi(String $pnurl)
    {
		// 全部網址
		$fullurl = trim($pnurl);
		
		$ch = curl_init($fullurl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if($output && $http_status === 200){
			return $output; 
		}else{
			// 錯誤處理
			return null;
		}
	}
	
	private function postfbapi(String $middleurl, $data)
    {
		// 全部網址
		$fullurl = $this->url.$middleurl.$this->fbPagesToken;
		
		$ch = curl_init($fullurl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		print_r($output);die();
		
		// if($output && $http_status === 200){
			// return $output; 
		// }else{
			// 錯誤處理
			// return null;
		// }
    }
	
	public function getfbapiresponse(String $middleurl = null)
    {
        return $this->getfbapi($middleurl);
    }
	
	public function getpnfbapiresponse(String $pnurl)
    {
        return $this->getpnfbapi($pnurl);
    }
	
	public function postfbapiresponse(String $middleurl, $data)
    {
        return $this->postfbapi($middleurl, $data);
    }
	
}
?>