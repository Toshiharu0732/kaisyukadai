<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            'sub_category_name' => 'required|max:100|unique:sub_categories,sub_category|string|',
        ];
    }

    public function messages(){
        return [
            'sub_category_name.max' => 'カテゴリーは100文字以上入力してください。',
            'sub_category_name.required' => '入力必須です。',
            'sub_category_name.unique' => 'このカテゴリーはすでに登録済みです。',
            'sub_category_name.string' => '文字で記入してください。',
        ];
    }

}
