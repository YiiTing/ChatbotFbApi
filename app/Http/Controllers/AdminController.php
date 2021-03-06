<?php

namespace App\Http\Controllers;

use App\User;
use App\UsersSocialAccounts;
use App\FbPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function admin()
    {
		return view('admin.admin');
	}
	
}
