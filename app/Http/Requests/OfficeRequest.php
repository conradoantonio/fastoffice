<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Municipality;

class OfficeRequest extends FormRequest
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
					'name'  => 'required',
					'num_int' => 'nullable',
					'price' => 'required|numeric',
					'phone' => 'required|numeric',
					'num_people' => 'required|numeric',
					'user_id' => 'present',
					'branch_id' => 'required',
					'office_type_id' => 'required',
					'description' => 'required'
				];
			case 'PUT':
				if ( $this->photo ){
					return [
						'photo' => 'image|mimes:jpeg,png,jpg,gif|max:3070'
					];
				}
				return [
					'name'  => 'required',
					'num_int' => 'nullable',
					'price' => 'required|numeric',
					'phone' => 'required|numeric',
					'num_people' => 'required|numeric',
					'user_id' => 'present',
					'branch_id' => 'required',
					'office_type_id' => 'required',
					'description' => 'required'
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
			'required' => ':attribute es requerido.',
			'numeric' => ':attribute debe ser numérico.'
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
			'name' => 'Nombre',
			'num_int' => 'Número interior',
			'price' => 'Precio',
			'phone' => 'Teléfono',
			'num_people' => 'Número de personas',
			'user_id' => 'Usuario',
			'branch_id' => 'Sucursal',
			'office_type_id' => 'Tipo de oficina',
			'description' => 'Descripción'
		];
	}

	public function response(array $errors)
	{
		if ($this->expectsJson()) {
			return new JsonResponse($errors, 422);
		}

		/*$input = $this->all();
		$municipalities = Municipality::whereHas('state', function($query) use ($input){
			$query->where('id', $input['state_id']);
		})->pluck('name', 'id')->prepend('Seleccione una ciudad', 0);*/

		return $this->redirector->to($this->getRedirectUrl())
			->withInput()
			->withErrors($errors, 'office');
			#->with('municipalities', $municipalities);
	}
}
