<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactDetailCommentRequest extends FormRequest
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
            'id' => 'required|integer',
            'comment_body' => 'required|string|max:4000',
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
            'id.required' => '不正な入力です。',
            'id.integer' => '不正な入力です。',

            'comment_body.required' => '本文を入力してください。',
            'comment_body.string' => '不正な入力です。',
            'comment_body.max' => '本文は4000文字以内で入力してください。',
        ];
    }
}
