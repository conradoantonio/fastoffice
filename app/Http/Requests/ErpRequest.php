<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErpRequest extends FormRequest
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
				return [
					'concept' => 'required',
					'amount' => 'required',
					'type' => 'required',
					'category_id' => 'required',
					'office_id' => 'required',
				];
			case 'PUT':
				return [
					'concept' => 'required',
					'amount' => 'required',
					'type' => 'required',
					'category_id' => 'required',
					'office_id' => 'required',
				];
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
			'required' => ':attribute es requerido.'
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
			'user_id' => 'Usuario',
			'office_id' => 'Oficina',
			'title' => 'Título',
			'description' => 'Descripción',
			'datetime_start' => 'Fecha y hora de inicio',
			'datetime_end' => 'Fecha y hora de término',
		];
	}

	public function response(array $errors)
	{
		if ($this->expectsJson()) {
			return new JsonResponse($errors, 422);
		}

		return $this->redirector->to($this->getRedirectUrl())
			->withInput()
			->withErrors($errors, 'meeting');
	}
}
