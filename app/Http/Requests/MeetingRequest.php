<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
	 * Get the data of the request and change it.
	 *
	 * @return array
	 */
	protected function getValidatorInstance()
	{
		$input = $this->all();
		$input['datetime_start'] = date("Y-m-d H:i:s", strtotime($input['date'].' '.$input['hour']));
		$input['datetime_end'] = date("Y-m-d H:i:s", strtotime("+1 hours", strtotime($input['datetime_start'])));

		$this->getInputSource()->replace($input);

		/*modify data before send to validator*/

		return parent::getValidatorInstance();
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
					'title' => 'required',
					'description' => 'required',
					'datetime_start' => 'date|before:'.$this->datetime_end,
					'datetime_end' => 'date|after:'.$this->datetime_start,
					'office_id' => 'required',
					'user_id' => 'present'
				];
			case 'PUT':
				return [
					'title' => 'required',
					'description' => 'required',
					'datetime_start' => 'date|before:'.$this->datetime_end,
					'datetime_end' => 'date|after:'.$this->datetime_start,
					'office_id' => 'required',
					'user_id' => 'present'
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
