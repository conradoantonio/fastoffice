<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Auth;
use Redirect;

class LoginController extends Controller
{
	public function login(Request $req)
	{
		if ( Auth::attempt(['email' => $req->email, 'password' => $req->password, 'status' => 1])){
				if ( auth()->user()->role_id == 2 ){
					$this->logout();
				}
				return Redirect::to('/dashboard');
		} else {
			$exist = DB::table('users')->where('email', $req->email)->first();
			if ( !$exist ) {
				session()->forget('account');
				$msg = [ 'email' => 'No hay ningun usuario registrado con este correo'];
			} else {
				if ( !$exist->status ) {
					$msg = [ 'status' => 'No tienes acceso al panel'];
					session(['account' => $req->email]);
				} elseif( $exist->role_id == 3){
					$msg = [ 'role' => 'No eres socio o administrador de ezcarro'];
					session(['account' => $req->email]);
				} else {
					$msg = [ 'password' => 'Contraseña incorrecta'];
					session(['account' => $req->email]);
				}
			}

			return Redirect::back()->withErrors($msg);
		}
	}

	public function logout(){
		Auth::logout();
		session()->forget('account');
		return Redirect::to('/login');
	}
}
