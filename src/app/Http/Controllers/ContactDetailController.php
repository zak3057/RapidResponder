<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactDetailRequest;
use App\Http\Requests\ContactDetailCommentRequest;
use App\Contact;
use App\User;
use App\Message;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactDetailSendmail;

class ContactDetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        // パラメータ取得
        $params['id'] = $request->id;
        $request->session()->put('id', $params['id']);

        // contact_idが一致するレコード取得
        $contact = Contact::getContactDetailIndex($params);

        // contact_idと一致するmessagesテーブルのレコード取得
        $messages = Message::getContactDetailIndex($params);

        // contact_idと一致するcommentsテーブルのレコード取得
        $comments = Comment::getContactDetailIndex($params);

        return view('contact.archive.detail.index', [
            'contact' => $contact,
            'messages' => $messages,
            'comments' => $comments,
        ]);
    }

    /**
     * start 対応開始
     *
     * @param Request $request
     * @return void
     */
    public function start(Request $request)
    {
        // パラメータ取得
        $params['id'] = $request->session()->get('id');

        // statusを対応中に更新し、user_idに操作したユーザーを登録
        Contact::setStatusStart($params, Auth::id());

        return redirect()->route('contact.archive.detail.index', [
            'id' => $params['id']
        ]);
    }

    /**
     * returnStatus 未対応に戻す
     *
     * @param Request $request
     * @return void
     */
    public function returnStatus(Request $request)
    {
        // パラメータ取得
        $params['id'] = $request->session()->get('id');

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        Contact::changeStatus($params, Auth::id(), '未対応');

        return redirect()->route('contact.archive.detail.index', [
            'id' => $params['id']
        ]);
    }

    /**
     * complete 対応済み
     *
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        // パラメータ取得
        $params['id'] = $request->session()->get('id');

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        Contact::changeStatus($params, Auth::id(), '対応済み');

        return redirect()->route('contact.archive.detail.index', [
            'id' => $params['id']
        ]);
    }

    /**
     * message 問い合わせに対してメールを送信する
     *
     * @param ContactDetailRequest $request
     * @return void
     */
    public function message(ContactDetailRequest $request)
    {
        // フォームから受け取った値取得
        $inputs = $request->all();
        $inputs['id'] = $request->session()->get('id');

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        if(!Contact::hasContactUser($inputs, Auth::id())) {
            // 異なるユーザーの場合はそのままリダイレクト
            return redirect()->route('contact.archive.detail.index', [
                'id' => $inputs['id'],
            ]);
        }

        // DB登録
        // TODO:インスタンス化する
        // $message = new Message;
        // $message->setMessage($inputs, Auth::id());
        $db = Message::setMessage($inputs, Auth::id());

        // dd($message);

        // 送信先メールアドレスと送信者メールアドレスを取得
        $email = Contact::getContactEmail($inputs);

        // メール送信
        \Illuminate\Support\Facades\Mail::to($email['contact'])->send(new ContactDetailSendmail($inputs, $email['user']));

        // 元のページにリダイレクト
        return redirect()->route('contact.archive.detail.index', [
            'id' => $inputs['id'],
            '#m'.$db->id
        ]);
    }

    /**
     * comment コメントをDBに登録する
     *
     * @param ContactDetailCommentRequest $request
     * @return void
     */
    public function comment(ContactDetailCommentRequest $request)
    {
        // フォームから受け取った値取得
        $inputs = $request->all();
        $inputs['id'] = $request->session()->get('id');

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        if(!Contact::hasContactUser($inputs, Auth::id())) {
            // 異なるユーザーの場合はそのままリダイレクト
            return redirect()->route('contact.archive.detail.index', [
                'id' => $inputs['id'],
            ]);
        }

        // DB登録
        $db = Comment::setComment($inputs, Auth::id());

        // 元のページにリダイレクト
        return redirect()->route('contact.archive.detail.index', [
            'id' => $inputs['id'],
            '#c'.$db->id,
        ]);
    }
}
