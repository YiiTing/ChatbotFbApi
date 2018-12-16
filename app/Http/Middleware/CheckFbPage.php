<?php

namespace App\Http\Middleware;

use Closure;
use App\FbPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFbPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		
		$check = FbPages::whereNull('deleted_at')
							->where('user_id', Auth::id())
							->where('page_id', Auth::user()->nowfbpage_id)
							->first();	
		if($check){
			
			return $next($request);
			
		}else{
			
			return redirect('robot');
			
		}
							
    }
}
