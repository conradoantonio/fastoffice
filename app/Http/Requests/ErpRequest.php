<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

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
	 * Get the data of the request and change it.
	 *
	 * @return array
	 */
	protected function getValidatorInstance()
	{
		$input = $this->all();
		$input['date'] = date("Y-m-d H:i:s", strtotime($input['date']));

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
					'concept' => 'present',
					'amount' => 'required|numeric',
					'type' => 'required',
					'category_id' => 'required',
					'office_id' => 'sometimes',
					'branch_id' => 'sometimes',
					'egress_type_id' => 'sometimes',
					'date' => 'required',
					'file' => 'required'
				];
			case 'PUT':
				return [
					'concept' => 'present',
					'amount' => 'required|numeric',
					'type' => 'required',
					'category_id' => 'required',
					'office_id' => 'sometimes',
					'branch_id' => 'sometimes',
					'egress_type_id' => 'sometimes',
					'date' => 'required',
					'file' => 'sometimes',
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
			'concept' => 'Concepto',
			'amount' => 'Cantidad',
			'type' => 'Tipo',
			'category_id' => 'Categoría',
			'office_id' => 'Oficina',
			'branch_id' => 'Franquicia',
			'file' => 'file',
		];
	}

	public function response(array $errors)
	{
		if ($this->expectsJson()) {
			return new JsonResponse($errors, 422);
		}

		$input = $this->all();
		$categories = Category::where('type', $input['type'])->pluck('name', 'id')->prepend('Seleccione una categoría', 0);

		return $this->redirector->to($this->getRedirectUrl())
			->withInput()
			->withErrors($errors, 'erp')
			->with('categories', $categories);
	}
}
