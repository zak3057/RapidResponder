<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'contact_id',
        'created_at',
        'updated_at',
        'user_id',
        'title',
        'body',
    ];

    /**
     * contact_idと一致するmessagesテーブルのレコード取得
     * SELECT messages.*, users.email FROM messages INNER JOIN users ON users.id = messages.user_id WHERE contact_id = ? ORDER BY messages.id
     *
     * @param array $params
     * @return Message
     */
    public static function getContactDetailIndex($params)
    {
        return self::select('messages.*', 'users.email')
                ->where('contact_id', '=', $params['id'])
                ->join('users', 'users.id', '=', 'messages.user_id')
                ->orderBy('id', 'asc')->get();
    }

    /**
     * 送信するメールの情報をDBに保存
     *
     * @param array $inputs
     * @param int $user_id
     * @return Message
     */
    public static function setMessage($inputs, $user_id)
    {
        return self::create([
            'contact_id' => $inputs['id'],
            'user_id' => $user_id,
            'title' => $inputs['title'],
            'body' => $inputs['body'],
        ]);
    }
}
