<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductCreateRequest extends FormRequest
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
            'title'       => 'required|min:3|max:100|string',
            'category_id' => 'integer',
            'price'       => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.min'           => 'Минимальная длинна названия 3 символа',
            'title.max'           => 'Максимальная длинна названия 100 символов',
            'category_id.integer' => 'Категория должна быть числом',
            'price.required'      => 'Цена обязательна для заполнения',
        ];
    }
}
