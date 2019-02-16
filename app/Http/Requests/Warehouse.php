<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Warehouse extends FormRequest
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
            'name' => 'required|max:20:min|10',
            'number' => 'required|max:10|min:4',
        ];
    }

    public function messages()
    {
        // return parent::messages(); // TODO: Change the autogenerated stub
        return [
            'name.required' => '仓库名称不得为空！',
            'name.max' => '仓库名称不得大于20位！',
            'name.min' => '仓库名称不得小于2位！',
            'number.required' => '仓库编号不得为空！',
            'number.max' => '仓库编号不得大于10位！',
            'number.min' => '仓库编号不得小于2位！',
        ];
    }
}
