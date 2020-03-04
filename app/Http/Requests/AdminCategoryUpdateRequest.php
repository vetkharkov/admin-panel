<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryUpdateRequest extends FormRequest
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
            'title'       => 'required|min:4|max:200',
            'slug'        => 'max:200',
            'description' => 'min:30|max:500|string',
            'parent_id'   => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'title.min'          => 'Минимальное имя 4 символа',
            'description.min'    => 'Минимальная длинна описания 30 символов',
            'description.max'    => 'Максимальная длинна описания 500 символов',
            'description.string' => 'Описание должно быть текстом',
        ];
    }
}
