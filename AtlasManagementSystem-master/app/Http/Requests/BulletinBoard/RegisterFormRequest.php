<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
                'over_name' => 'required|string|max:10',
                'under_name' =>'required|string|max:10',
                'over_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
                'under_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
                'mail_address' =>'required|email|unique:users|max:100',
                'sex' =>'not_in: 0' ,
                'birth_day' =>'' ,
                'role' =>'not_in: 0' ,
                'password' => 'required|min:8|max:30|',
        ];
    }

    public function messages(){
        return [
                'over_name.max' =>'10文字以下で入力してください。',
                'over_name.required' =>'入力必須です。',
                'under_name.max' =>'10文字以下で入力してください。',
                'under_name.required' =>'入力必須です。',
                'over_name_kana.max' => '30文字以内で入力してください。',
                'over_name_kana.required' =>'入力必須です。',
                 'over_name_kana.regex' => 'カタカナで入力してください。',
                'under_name_kana.max' =>'30文字以内で入力してください。' ,
                 'under_name_kana.regex' => 'カタカナで入力してください。',
                 'under_name_kana.required' =>'入力必須です。',
                'mail_address.email' => 'メールアドレスの形式で入力してください。',
                'mail_address.required' =>'入力必須です。',
                'mail_address.unique' => '既に登録済みのメールアドレスです。',
                'sex.not_in: 0' => '入力必須です',
                'birth_day' => '入力必須です',
                'role.not_in: 0' =>'入力必須です',
                'password.min' => '8文字以上で入力してください。',
                'password.required' =>'入力必須です。',
                'password.confirmed' =>'入力が正しいか確認してください。',
        ];
    }
}
