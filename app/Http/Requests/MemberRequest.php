<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
        // TODO バリデーション処理はうまく行っている　一部、要件を満たしていないので満たすこと
        return [
            //
            'name_sei' => 'required|string|max:20',
            'name_mei' => 'required|string|max:20',
            'nickname' => 'required|string|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'required|string|regex:/\A([a-zA-Z0-9]{8,})+\z/u|max:20|confirmed',
            'email' => 'required|string|max:200|email|unique:members'
        ];
    }

    public function attributes()
    {
        return [
            'name_sei' => '名前（姓）',
            'name_mei' => '名前（名）',
            'nickname' => 'ニックネーム',
            'gender' => '性別',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード確認',
            'email' => 'メールアドレス（ログインID）'
        ];
    }
    public function messages() {
        return [
            'password.regex' => 'パスワードは半角英数字で入力してください'
        ];
    }
}
