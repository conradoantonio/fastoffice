<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Redirect;
use DB;
use Session;

class HomeController extends Controller
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

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if ( auth()->user()->role_id == 1){


			return view('dashboard');
		} else {


			return view('dashboard');
		}

	}

	public function notificaciones(){
		return view('notificaciones/index');
	}
}
