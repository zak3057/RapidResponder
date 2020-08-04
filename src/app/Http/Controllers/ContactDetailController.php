<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactDetailRequest;
use App\Contact;
use App\User;
use App\Message;
use App\Comment;
use Illuminate\Support\Facades\Auth;

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
        // getパラメータ取得
        $params['id'] = $request->id;
        // contact_idが一致するレコード取得
        // SELECT contacts.*, users.email FROM contacts LEFT JOIN users ON users.id = contacts.user_id WHERE contacts.id = ?
        $contact = Contact::select('contacts.*', 'users.email')->where('contacts.id', '=', $params['id'])
                    ->leftJoin('users', 'users.id', '=', 'contacts.user_id')->first();

        // contact_idと一致するmessagesテーブルのレコード取得
        $messages = Message::join('users', function ($join) use($params) {
            $join->on('users.id', '=', 'messages.user_id')
            ->where('contact_id', '=', $params['id']);
        })->select('messages.*', 'users.email')
        ->get();

        // contact_idと一致するcommentsテーブルのレコード取得
        $comments = Comment::join('users', function ($join) use($params) {
            $join->on('users.id', '=', 'comments.user_id')
            ->where('contact_id', '=', $params['id']);
        })->select('comments.*', 'users.email')
        ->get();

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
        // getパラメータ取得
        $params['id'] = $request->id;

        // statusを対応中に更新し、user_idに操作したユーザーを登録
        Contact::where('id', '=', $params['id'])->update(['status' => '対応中', 'user_id' => Auth::id()]);

        return redirect(route('contact.archive.detail.index', ['id' => $params['id']]));
    }

    /**
     * returnStatus 未対応に戻す
     *
     * @param Request $request
     * @return void
     */
    public function returnStatus(Request $request)
    {
        // getパラメータ取得
        $params['id'] = $request->id;

        // statusを未対応に更新し、user_idをNULLにする
        Contact::where('id', '=', $params['id'])->update(['status' => '未対応', 'user_id' => NULL]);

        return redirect(route('contact.archive.detail.index', ['id' => $params['id']]));
    }

    /**
     * complete 対応済み
     *
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        // getパラメータ取得
        $params['id'] = $request->id;

        // statusを対応済みに更新し、user_idをNULLにする
        Contact::where('id', '=', $params['id'])->update(['status' => '対応済み', 'user_id' => NULL]);

        return redirect(route('contact.archive.detail.index', ['id' => $params['id']]));
    }

    public function message(ContactDetailRequest $request)
    {
        // バリデーション実行
        // $request->messageRules();

        // フォームから受け取った値取得
        $inputs = $request->all();

        // DB登録
        // Message::create([
        //     'contact_id' => $inputs[''],
        //     'user_id' => $inputs[''],
        //     'title' => $inputs[''],
        //     'body' => $inputs[''],
        // ]);

        // メール送信

        // 元のページにリダイレクト
        return redirect(route('contact.archive.detail.index', [
            'id' => $inputs['id']
        ]));
    }
}
