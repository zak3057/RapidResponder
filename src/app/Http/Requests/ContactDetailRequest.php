<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactDetailRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'body' => 'required|string|max:4000',
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
            'title.required' => 'タイトルを入力してください。',
            'title.string' => '不正な入力です。',
            'title.max' => 'タイトルは200文字以内で入力してください。',

            'body.required' => '本文を入力してください。',
            'body.string' => '不正な入力です。',
            'body.max' => '本文は4000文字以内で入力してください。',
        ];
    }
}
