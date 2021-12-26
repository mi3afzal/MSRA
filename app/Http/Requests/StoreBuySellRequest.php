<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuySellRequest extends FormRequest
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
        return [
            'type' => 'required',
            'property_type' => 'required',
            'promotional_flag' => 'required',
            'state' => 'required',
            'city' => 'required',
            'suburb' => 'required',
            'price' => 'required',
            'title' => 'required|max:250',
            'number' => 'required',
            'email' => 'required|max:250',
            'description' => 'required|max:1000',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type.required' => 'Type is required!',
            'property_type.required' => 'Property Type is required!',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'type' => 'trim',
            'property_type' => 'trim'
        ];
    }
}
