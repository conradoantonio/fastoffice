<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req)
	{
		$roles_id = [];
		if ( Route::currentRouteName() == 'User.index1' ){
			$roles_id = [1,4,5,6];
		} else {
			$roles_id = [2,3];
		}

		$users = User::whereIn('role_id',$roles_id)->get();
		$roles = Role::all()->pluck('name','id')->prepend('Todos los roles', 0)->except(['id', '4']);

		if ($req->ajax()) {
			return view('users.table',compact('users'))->render();
		}
		return view('users.index',compact('users', 'roles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function form($id = null){
		if ( $id ){
			$user = User::findOrFail($id);
		} else {
			$user = new User();
		}
		$roles = Role::whereNotIn('id',[2,3])->pluck('name','id');
		return view('users.form', compact('user', 'roles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $req)
	{
		$user = new User();
		$user->fill($req->all());
		$user->password = bcrypt($req->password);

		if ($user->save()){
			$params = array();
			$params['subject'] = "Nuevo usuario de sistema";
			$params['title'] = "Accesos al sistema";
			$params['content']['message'] = "Has sido dado de alta como usuario de sistema de ".env('APP_NAME').", estos son tus accesos para tu cuenta:<br>";
			$params['content']['email'] = $user->email
			$params['content']['password'] = $req->password;
			$params['email'] = $user->email;
			$params['view'] = 'mails.credentials';

			if ( $this->mail($params) ){
				return redirect()->route('User.index1')->with(['msg' => 'Administrdor creado', 'class' => 'alert-success']);
			}
			return redirect()->route('User.index1')->with([ 'msg' => 'Administrador creado, ocurrió un problema al enviar el correo', 'class' => 'alert-warning' ]);

		} else {
			return back()->with([ 'msg' => 'Error al crear el usuario', 'class' => 'alert-danger' ]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $req, $id)
	{
		$user = User::find($id);
		$user->fill($req->except('password', 'email'));
		$pass = $req->password;
		if ( $pass ) {
			$user->password = bcrypt($pass);
		}

		if ( $user->save() ){
			if ( $pass ){
				$params = array();
				$params['subject'] = "Usuario de sistema modificado";
				$params['content']['message'] = "Tu contraseña ha sido modificada, este es tu nuevo acceso:<br>";
				$params['content']['email'] = $user->email
				$params['content']['password'] = $req->password;
				$params['title'] = "Accesos al sistema";
				$params['email'] = $user->email;
				$params['view'] = 'mails.credentials';

				if ( $this->mail($params) ){
					return redirect()->route('User.index1')->with(['msg' => 'Administrador actualizado', 'class' => 'alert-success']);
				}
				return redirect()->route('User.index1')->with([ 'msg' => 'Administrador actualizado, ocurrió un problema al enviar el correo', 'class' => 'alert-warning' ]);
			}
			return redirect()->route('User.index1')->with(['msg' => 'Administrador actualizado', 'class' => 'alert-success']);
		} else {
			return back()->with([ 'msg' => 'Error al actualizar usuario', 'class' => 'alert-danger' ]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		if ( User::destroy($id) ) {
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function status($id)
	{
		$user = User::find($id);
		$user->status = $user->status?0:1;

		if ( $user->save() ) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}

	/**
	 * Función para cambiar la foto de perfil
	 *
	 * @return Arreglo con el usuario modificado
	 */
	public function updatePhotoProfile(Request $req, $id){
		$user = User::find($id);

		if ( $req->hasFile('photo') ){
			if ($req->base64) {
				$encoded_data = $req->base64;
				$binary_data = base64_decode( $encoded_data );

				File::makeDirectory(public_path()."/img/profiles/".$user->id, 0777, true, true);

				if ( File::exists(public_path()."/img/profiles/".$user->id) ){
					File::cleanDirectory(public_path()."/img/profiles/".$user->id."/");
				}
				$filename = time().'.jpg';

				$user->photo = '/img/profiles/'.$user->id.'/'.$filename;
				$ruta_foto = 'img/profiles/'.$user->id.'/'.$filename;

				$result = file_put_contents( $ruta_foto, $binary_data );
			}
		}

		if ( $user->save() ){
			return redirect()->back();
		}
		return redirect()->back();
	}
}
