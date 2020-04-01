<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminGroupFilterAddRequest extends FormRequest
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
            'title'               => 'required|min:4|max:25',
        ];
    }

    public function messages()
    {
        return [
            'title.min'           => 'Минимальная длинна названия 4 символа',
            'title.max'           => 'Максимальная длинна названия 25 символов',
        ];
    }
}
