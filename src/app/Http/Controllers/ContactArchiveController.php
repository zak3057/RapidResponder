<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactArchiveController extends Controller
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
        $params['status'] = $request->status;
        if($params['status'] === NULL) $params['status'] = "未対応";

        // statusが未対応のレコードをcreated_atが新しい順に10件取得
        $contacts = Contact::where('status', '=', $params['status'])->orderBy('created_at', 'desc')->paginate(10)->appends($params);
        // レコードをカウントし、0の場合falseを返す
        $record = true;
        if($contacts->count() === 0) $record=false;

        return view('contact.archive.index', [
            'contacts' => $contacts,
            'status' => $params['status'],
            'record' => $record,
        ]);
    }
}
