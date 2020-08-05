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

        // contact_idが一致するレコード取得
        // SELECT contacts.*, users.email FROM contacts LEFT JOIN users ON users.id = contacts.user_id WHERE contacts.id = ?
        $contact = Contact::select('contacts.*', 'users.email')->where('contacts.id', '=', $params['id'])
                    ->leftJoin('users', 'users.id', '=', 'contacts.user_id')->first();

        // contact_idと一致するmessagesテーブルのレコード取得
        // SELECT messages.*, users.email FROM messages INNER JOIN users ON users.id = messages.user_id WHERE contact_id = ? ORDER BY messages.id
        $messages = Message::select('messages.*', 'users.email')->where('contact_id', '=', $params['id'])
                    ->join('users', 'users.id', '=', 'messages.user_id')->orderBy('id', 'asc')->get();

        // contact_idと一致するcommentsテーブルのレコード取得
        $comments = Comment::select('comments.*', 'users.email')->where('contact_id', '=', $params['id'])
        ->join('users', 'users.id', '=', 'comments.user_id')->orderBy('id', 'asc')->get();

        return view('contact.archive.detail.index', [
            'contact' => $contact,
            'param_id' => $params['id'],
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
        $params['id'] = $request->id;

        // statusを対応中に更新し、user_idに操作したユーザーを登録
        Contact::where('id', '=', $params['id'])->update(['status' => '対応中', 'user_id' => Auth::id()]);

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
        $params['id'] = $request->id;

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        $db = Contact::select('user_id')->where('id', '=', $params['id'])->first();
        if($db['user_id'] === Auth::id()) {
            // statusを未対応に更新し、user_idをNULLにする
            Contact::where('id', '=', $params['id'])->update(['status' => '未対応', 'user_id' => NULL]);
        }

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
        $params['id'] = $request->id;

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        $db = Contact::select('user_id')->where('id', '=', $params['id'])->first();
        if($db['user_id'] === Auth::id()) {
            // statusを対応済みに更新し、user_idをNULLにする
            Contact::where('id', '=', $params['id'])->update(['status' => '対応済み', 'user_id' => NULL]);
        }

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

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        $db = Contact::select('user_id')->where('id', '=', $inputs['id'])->first();
        if($db['user_id'] !== Auth::id()) {
            // 異なるユーザーの場合はそのままリダイレクト
            return redirect()->route('contact.archive.detail.index', [
                'id' => $inputs['id'],
            ]);
        }

        // バリデーション実行
        $request->rules();

        // DB登録
        $db = Message::create([
            'contact_id' => $inputs['id'],
            'user_id' => Auth::id(),
            'title' => $inputs['title'],
            'body' => $inputs['body'],
        ]);

        // 送信先メールアドレスと送信者メールアドレスを取得
        $email = Contact::select('contacts.mail as contact', 'users.email as user')->where('contacts.id', '=', $inputs['id'])
        ->leftJoin('users', 'users.id', '=', 'contacts.user_id')->first();

        // メール送信
        \Illuminate\Support\Facades\Mail::to($email['contact'])->send(new ContactDetailSendmail($inputs, $email['user']));

        // 元のページにリダイレクト
        return redirect()->route('contact.archive.detail.index', [
            'id' => $inputs['id'],
            '#m'.$db->id,
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

        // 既に対応者が存在する場合、操作を行うユーザーが対応者と一致しているか
        $db = Contact::select('user_id')->where('id', '=', $inputs['id'])->first();
        if($db['user_id'] !== Auth::id()) {
            // 異なるユーザーの場合はそのままリダイレクト
            return redirect()->route('contact.archive.detail.index', [
                'id' => $inputs['id'],
            ]);
        }

        // バリデーション実行
        $request->rules();

        // DB登録
        $db = Comment::create([
            'contact_id' => $inputs['id'],
            'user_id' => Auth::id(),
            'body' => $inputs['comment_body'],
        ]);

        // 元のページにリダイレクト
        return redirect()->route('contact.archive.detail.index', [
            'id' => $inputs['id'],
            '#c'.$db->id,
        ]);
    }
}
