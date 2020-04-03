<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCurrencyAddRequest extends FormRequest
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
            'code' => 'min:3|max:3|string'
        ];
    }

    public function messages()
    {
        return [
            'code.min'    => 'Минимальное длинна 3 символа',
            'code.max'    => 'Максимальная длинна 3 символа',
            'code.string' => 'Код валюты должен быть строкой',
        ];
    }
}
