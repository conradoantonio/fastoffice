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
						'fullname'  => 'required|min:3',
						'email' => 'required|email|min:8|unique:users,email',
						'phone' => 'required|numeric',
						'address' => 'nullable|max:200',
						'business_activity' => 'nullable|max:200',
						'identification_type' => 'nullable|max:200',
						'identification_num' => 'nullable|max:200',
						'password' => 'required|min:8',
						#'regime' => 'sometimes',
						'rfc' => [
							'nullable',
							#'unique:users,rfc',
							'min:12',
							'max:13',
							'regex:/^([A-Z a-z,Ñ ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z a-z|\d]{3})$/'
						],
					];
				} else {
					return [
						'fullname'  => 'required|min:3',
						'phone' => 'required|numeric',
						'email' => 'required|email|unique:users',
						'address' => 'nullable|max:200',
						'business_activity' => 'nullable|max:200',
						'identification_type' => 'nullable|max:200',
						'identification_num' => 'nullable|max:200',
						'password' => 'required|min:8',
					];
				}
			case 'PUT':
				if ( !$this->ajax() ){
					return [
						'fullname' => 'required|min:3',
						'email' => 'required|email|unique:users,email, '.$this->route('id'),
						'phone' => 'required|numeric',
						'address' => 'nullable|max:200',
						'business_activity' => 'nullable|max:200',
						'identification_type' => 'nullable|max:200',
						'identification_num' => 'nullable|max:200',
						'password' => 'sometimes|nullable|min:8',
						#'regime' => 'sometimes',
						'rfc' => [
							'nullable',
							#'unique:users,rfc, '.$this->route('id'),
							'min:12',
							'max:13',
							'regex:/^([A-Z a-z,Ñ ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z a-z|\d]{3})$/'
						],
					];
				} else {
					return [
						'fullname' => 'required|min:3',
						'phone' => 'required|numeric',
						'email' => 'required|email|unique:users,email, '.$this->route('id'),
						'address' => 'nullable|max:200',
						'business_activity' => 'nullable|max:200',
						'identification_type' => 'nullable|max:200',
						'identification_num' => 'nullable|max:200',
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
			'password.required' => 'La contraseña es requerida.',
			'min' => ':attribute debe tener minímo :min caracteres.',
			'max' => ':attribute debe tener máximo :max caracteres.',
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
			'address' => 'Dirección',
			'business_activity' => 'Giro empresarial',
			'identification_type' => 'Tipo de identificación',
			'identification_num' => 'Número de identificación',
			'rfc' => 'RFC'
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
