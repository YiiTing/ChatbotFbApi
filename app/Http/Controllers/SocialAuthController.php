<?php

namespace App\Http\Controllers;

use Auth;
use Socialite;
use App\User;
use App\UsersSocialAccounts;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook($provider)
    {
		if ($provider == 'facebook'){
		
			$facebookFields = [
				'name',
				'email',
				'manage_pages',
				'publish_pages',
				'pages_show_list',
				'pages_messaging',
				// 'read_page_mailboxes',
				// 'read_insights'
			];
		
			return Socialite::driver($provider)->fields($facebookFields)->scopes(['manage_pages', 'publish_pages', 'pages_show_list', 'pages_messaging'])->redirect();
			
		}
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback($provider)
    {
	
		try {
		
			if ($provider == 'facebook'){
			
				$facebookFields = [
					'name',
					'email'
				];
				
				$user = $this->createOrGetUser($provider, Socialite::driver($provider)->fields($facebookFields)->user());

				auth()->login($user);

				return redirect()->to('/robot');
			}
			
        } catch (\Exception $e) {
		
             return redirect()->route('login');
			
        }
		
    }
	
	public function createOrGetUser($provider, $providerUser)
    {
	
		if ($provider == 'facebook'){
				
			// print_r(json_encode($providerUser));die();	
				
			$account = UsersSocialAccounts::whereProvider($provider)
				->whereProviderUserId($providerUser->getId())
				->first();	

			if ($account) {
				
				## 取得長期權杖
				$app_id = env('FACEBOOK_ID', '');
				$app_secret = env('FACEBOOK_SECRET', '');
				$url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id='.$app_id.'&client_secret='.$app_secret.'&fb_exchange_token='.$providerUser->token;
				
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				$output = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($http_status == 200){
					$json = json_decode($output, true);
					$long_provider_token = $json['access_token'];
				}
				
				UsersSocialAccounts::where('provider_user_id', $providerUser->getId())
					->update([
						'provider_token' => $providerUser->token,
						'long_provider_token' => $long_provider_token
				]);
					
				return $account->user;
				
			} else {
				
				## 取得長期權杖
				$app_id = env('FACEBOOK_ID', '');
				$app_secret = env('FACEBOOK_SECRET', '');
				$url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id='.$app_id.'&client_secret='.$app_secret.'&fb_exchange_token='.$providerUser->token;
				
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				$output = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($http_status == 200){
					$json = json_decode($output, true);
					$long_provider_token = $json['access_token'];
				}
				
				$account = new UsersSocialAccounts([
					'provider_user_id' => $providerUser->getId(),
					'provider' => 'facebook',
					'provider_token' => $providerUser->token,
					'long_provider_token' => $long_provider_token
				]);

				$user = User::whereEmail($providerUser->getEmail())->first();

				if (!$user) {

					$user = User::updateOrCreate(
						['email' => $providerUser->getEmail()],
						[
							'email' => $providerUser->getEmail(),
							'name' => $providerUser->getName(),
						]
					);
				}

				$account->user()->associate($user);
				$account->save();

				return $user;

			}
		}

    }
}
