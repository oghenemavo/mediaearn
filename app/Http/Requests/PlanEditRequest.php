<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanEditRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'price' => 'required|numeric|min:0.1',
            'max_views' => 'required|numeric|min:1',
            'description' => 'nullable|string|min:10',
            'discount' => 'nullable|numeric',
        ];
    }
}
