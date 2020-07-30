<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Http\Requests\ContactsRequest;
use App\Mail\ContactSendmail;

class ContactsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * confirm フォームからの値確認と値の受け渡し
     *
     * @param ContactsRequest $request
     * @return void
     */
    public function confirm(ContactsRequest $request)
    {
        // バリデーション実行
        $request->rules();

        // フォームから受け取った値取得
        $inputs = $request->all();

        // お問い合わせ内容確認ページのviewに変数を渡して表示
        return view('contact.confirm', [
            'inputs' => $inputs,
        ]);
    }

    /**
     * send DBへの登録とメールの送信
     *
     * @param ContactsRequest $request
     * @return void
     */
    public function send(ContactsRequest $request)
    {
        // バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $request->rules();

        // フォームから受け取った値取得
        $inputs = $request->all();

        // DB登録
        Contact::create([
            'name' => $inputs['name'],
            'mail' => $inputs['mail'],
            'tel' => $inputs['tel'],
            'item' => $inputs['item'],
            'body' => $inputs['body'],
            'status' => '未対応',
        ]);

        // 入力されたメールアドレスにメールを送信
        \Illuminate\Support\Facades\Mail::to($inputs['mail'])->send(new ContactSendmail($inputs));

        // 再送信を防ぐためにトークンを再発行
        $request->session()->regenerateToken();

        // 送信完了ページのviewを表示
        return view('contact.thanks');

        // return view('contact.thanks', [
        //     'inputs' => $inputs,
        // ]);
    }

}
