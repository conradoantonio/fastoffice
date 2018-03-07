<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewRequest extends FormRequest
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
					'title'  => 'required|unique:news',
					'content' => 'required',
					'photo' => 'required',
				];
			case 'PUT':
				return [
					'title' => 'required|unique:news,title,'.$this->route('id'),
					'content' => 'required'
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
			'title.required' => 'El título es requerido.',
			'content.required' => 'El contenido es requerido.',
			'photo.required' => 'La imagen es requerida.',
			'title.unique' => 'El título ya esta siendo usado.',
			'title.exists' => 'El título ya esta siendo usado.',
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
				'title' => 'Título',
				'content' => 'Contenido',
				'photo' => 'Imagen'
		];
	}

	public function response(array $errors)
	{
		if ($this->expectsJson()) {
			return new JsonResponse($errors, 422);
		}

		return $this->redirector->to($this->getRedirectUrl())
				->withInput()
				->withErrors($errors, 'new');
	}
}
