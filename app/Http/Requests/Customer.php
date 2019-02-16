<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Customer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:10|unique:customers'
        ];
    }

    public function messages()
    {
        // return parent::messages(); // TODO: Change the autogenerated stub
        return [
            'name.required' => '内容不得为空！',
            'name.min' => '内容不得小于2位！',
            'name.max' => '内容不得大于10位！',
            'name.unique' => '结算方式名称已存在！'
        ];

    }
}
