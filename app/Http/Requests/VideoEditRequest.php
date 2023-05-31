<?php

namespace App\Http\Requests;

use App\Enums\VideoTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class VideoEditRequest extends FormRequest
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
            'category_id' => 'required',
            'title' => 'required|min:2',
            'description' => 'required|min:10',
            'video_type' => 'required',
            'video_id' => [
                'nullable',
                Rule::requiredIf(request()->video_type == VideoTypeEnum::YOUTUBE->value),
                // 'size:11'
            ],
            'video_file' => [
                'nullable',
                Rule::requiredIf(request()->video_type == VideoTypeEnum::UPLOAD),
                'mimes:mp4'
            ],
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'length' => 'required|numeric',
            'charges' => 'required|numeric|min:100|max:1000000000',
            'earnable' => 'required|numeric|min:1',
            'earnable_ns' => 'required|numeric|min:1',
            'earned_after' => 'required|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); // Here is your array of errors
        // dd($errors);
        // throw new HttpResponseException($errors);
    }
}
