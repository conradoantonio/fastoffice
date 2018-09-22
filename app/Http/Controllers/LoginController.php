<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Auth;
use App\Models\Meeting;

class LoginController extends Controller
{
	public function login(Request $req)
	{
		if ( Auth::attempt(['email' => $req->email, 'password' => $req->password, 'status' => 1])){
				if ( auth()->user()->role_id == 4 ){
					$this->logout();
				}
				if ( auth()->user()->role_id == 3 ){
				    if ( auth()->user()->belongsBranch ) {
						$today = date('Y-m-d');
						$meetings = Meeting::with(['office', 'user'])
							->where('datetime_start', '>=', $today.' 00:00:00')
							->where('datetime_start', '<=', $today.' 23:59:59')
							->where('status', '1')
							->whereHas('office', function($q){
								$q->where('branch_id', auth()->user()->branch_id);
							})->get();
					} else {
						auth()->logout();
						$msg = [ 'status' => 'Tu cuenta de recepcionista no está asociada a ninguna franquicia'];
						return back()->withErrors($msg);
					}
					session(['reminders' => $meetings]);	
				}
				return redirect('/dashboard');
		} else {
			$exist = DB::table('users')->where('email', $req->email)->first();
			if ( !$exist ) {
				session()->forget('account');
				$msg = [ 'email' => 'No hay ningun usuario registrado con este correo'];
			} else {
				if ( !$exist->status ) {
					$msg = [ 'status' => 'No tienes acceso al panel'];
					session(['account' => $req->email]);
				} elseif( $exist->role_id == 4){
					$msg = [ 'role' => 'No eres usuario del sistema'];
					session(['account' => $req->email]);
				} else {
					$msg = [ 'password' => 'Contraseña incorrecta'];
					session(['account' => $req->email]);
				}
			}

			return back()->withErrors($msg);
		}
	}

	public function logout(){
		Auth::logout();
		session()->forget('account');
		session()->forget('reminders');
		return redirect('/login');
	}
}
