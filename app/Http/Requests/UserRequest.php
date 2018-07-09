<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		switch($this->method()) {
			case 'GET':
			case 'DELETE':
				return [];
			case 'POST':
				if ( !$this->ajax() ){
					return [
						'fullname'  => 'required|regex:/^[\pL\s]+$/u|min:3',
						'email' => 'required|email|min:8|unique:users',
						'phone' => 'required|numeric',
						'password' => 'required|min:8',
					];
				} else {
					return [
						'fullname'  => 'required|regex:/^[\pL\s]+$/u|min:3',
						'phone' => 'required|numeric',
						'email' => 'required|email|unique:users',
						'password' => 'required|min:8',
					];
				}
			case 'PUT':
				if ( !$this->ajax() ){
					return [
						'fullname' => 'required|regex:/^[\pL\s]+$/u|min:3',
						'email' => 'required|email|unique:users,email, '.$this->route('id'),
						'phone' => 'required|numeric',
						'password' => 'sometimes|min:8',
					];
				} else {
					return [
						'fullname' => 'required|regex:/^[\pL\s]+$/u|min:3',
						'phone' => 'required|numeric',
						'email' => 'required|email|unique:users,email, '.$this->route('id'),
						'password' => 'sometimes|min:8',
					];
				}
			default:break;
		}
	}

	/**
	* Get the error messages for the defined validation rules.
	*
	* @return array
	*/
	public function messages()
	{
		return [
			'unique' => ':attribute ya esta siendo usado.',
			'required' => ':attribute es requerido.',
			'password.required' => 'La contraseña es requerido.',
			'min' => ':attribute debe tener minímo :min caracteres.',
			'regex' => 'El formato del campo :attribute no es válido'
		];
	}

	/**
	* Customize the name of the attributes
	*
	* @return array
	*/
	public function attributes()
	{
		return [
			'fullname' => 'Nombre completo',
			'phone' => 'Teléfono',
			'email' => 'Correo electrónico',
			'password' => 'Contraseña',
		];
	}

	public function response(array $errors)
	{
		if ($this->expectsJson() || $this->ajax()) {
			return new JsonResponse($errors, 422);
		}

		return $this->redirector->to($this->getRedirectUrl())
				->withInput()
				->withErrors($errors, 'user');
	}
}
