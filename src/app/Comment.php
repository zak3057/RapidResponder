<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'contact_id',
        'created_at',
        'updated_at',
        'user_id',
        'body',
    ];

    /**
     * contact_idと一致するcommentsテーブルのレコード取得
     * select comments.*, users.email from comments inner join users on users.id = comments.user_id where contact_id = ? order by id asc
     *
     * @param array $params
     * @return Comment
     */
    public static function getContactDetailIndex($params) {
        return self::select('comments.*', 'users.email')
                ->where('contact_id', '=', $params['id'])
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->orderBy('id', 'asc')->get();
    }

    /**
     * commentをDBに登録する
     *
     * @param array $inputs
     * @param int $user_id
     * @return Comment
     */
    public static function setComment($inputs, $user_id)
    {
        return self::create([
            'contact_id' => $inputs['id'],
            'user_id' => $user_id,
            'body' => $inputs['comment_body'],
        ]);
    }
}