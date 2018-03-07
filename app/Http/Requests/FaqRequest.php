<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
					'question'  => 'required|unique:faqs,question',
					'answer' => 'required',
				];
			case 'PUT':
				return [
					'question' => "required|unique:faqs,question, ".$this->route('id'),
					'answer' => 'required',
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
			'question.required' => 'La pregunta es requerida.',
			'answer.required' => 'La respuesta es requerido.',
			'question.unique' => 'La pregunta ya esta siendo usada.',
			'question.exists' => 'La pregunta ya esta siendo usada.',
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
				'question' => 'Pregunta',
				'answer' => 'Respuesta'
		];
	}

	public function response(array $errors)
	{
		if ($this->expectsJson()) {
			return new JsonResponse($errors, 422);
		}

		return $this->redirector->to($this->getRedirectUrl())
				->withInput()
				->withErrors($errors, 'faq');
	}
}
