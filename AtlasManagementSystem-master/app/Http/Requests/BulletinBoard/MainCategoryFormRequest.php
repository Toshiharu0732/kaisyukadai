<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryFormRequest extends FormRequest
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
            'main_category_name' => 'required|max:100|unique:main_categories,main_category|string|',
        ];
    }

    public function messages(){
        return [
            'main_category_name.max' => 'カテゴリーは100文字以上入力してください。',
            'main_category_name.required' => '入力必須です。',
            'main_category_name.unique' => 'このカテゴリーはすでに登録済みです。',
            'main_category_name.string' => '文字で記入してください。',
        ];
    }

}
