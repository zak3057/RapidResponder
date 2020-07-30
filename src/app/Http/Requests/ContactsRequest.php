<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
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
            'name' => 'required|string|max:16',
            'mail' => 'required|string|email|max:200',
            'tel' => 'required|regex:/^[0-9]+$/|max:12',
            'item' => 'required|string|max:16',
            'body' => 'required|string|max:2000',
            // 'status' => 'string|max:16',
            // 'created_at' => 'required|datetime',
        ];
    }

    /**
     * messages エラーメッセージのカスタマイズ
     *
     * @return void
     */
    public function messages()
    {
        return [
            'name.required' => '氏名を入力してください。',
            'name.string' => '氏名は文字列で入力してください。',
            'name.max' => '氏名は16文字以内で入力してください。',

            'mail.required' => 'メールアドレスを入力してください。',
            'mail.string' => 'メールアドレスは文字列で入力してください。',
            'mail.max' => 'メールアドレスは200文字以内で入力してください。',
            'mail.email' => '正しいメールアドレスを入力してください。',

            'tel.required' => '電話番号を入力してください。',
            'tel.max' => '電話番号は200文字以内で入力してください。',
            'tel.regex' => '正しい電話番号を入力してください。',

            'item.required' => '商品種別を選択してください。',

            'body.required' => '問い合わせ内容を入力してください。',
            'body.max' => '問い合わせ内容は2000文字以内で入力してください。',
            'body.string' => '正しい問い合わせ内容を入力してください。',
        ];
    }
}
