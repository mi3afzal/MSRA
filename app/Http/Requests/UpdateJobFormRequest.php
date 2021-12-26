<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobFormRequest extends FormRequest
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
            'job_type' => 'required',
            'job_category' => 'required',
            'medical_center' => 'required',
            'profession' => 'required',
            'speciality' => 'required',
            'state' => 'required',
            'city' => 'required',
            'suburb' => 'required',
            'rate' => 'required',
            'work_days' => 'required',
            'title' => 'required|max:500',
            'from_date' => 'required',
            'to_date' => 'required',
            'address' => 'required|max:500',
            'description' => 'required',
            'practice_offer' => 'required',
            'essential_criteria' => 'required',
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
            'job_type.required' => 'Job Type is required!',
            'property_type.required' => 'Poperty Type is required!',
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
            'job_type' => 'trim',
            'property_type' => 'trim'
        ];
    }
}
