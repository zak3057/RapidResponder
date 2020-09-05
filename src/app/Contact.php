<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'mail',
        'tel',
        'item',
        'body',
        'status',
        'created_at',
        'updated_at',
        'user_id',
    ];

    // 製品種別
    public static $item = [
        'A001',
        'A002',
        'A003',
        'A004',
        'A005',
        'A006',
        'A007',
        'A008',
        'A009',
        'A010',
        'A011',
        'A012',
        'A013',
        'A014',
        'A015',
        'A016',
    ];

    /**
     * お問い合わせで入力された値をDBに登録
     *
     * @param array $inputs フォームから受け取った値
     * @return void
     */
    public static function setContactData($inputs)
    {
        self::create([
            'name' => $inputs['name'],
            'mail' => $inputs['mail'],
            'tel' => $inputs['tel'],
            'item' => $inputs['item'],
            'body' => $inputs['body'],
            'status' => '未対応',
        ]);
    }

    /**
     * statusを対応中に更新し、user_idに操作したユーザーを登録
     *
     * @param array $params
     * @param string $status
     * @param int $id
     * @return void
     */
    public static function setStatusStart($params, $user_id)
    {
        self::where('id', '=', $params['id'])->update(['status' => '対応中', 'user_id' => $user_id]);
    }

    /**
     * お問い合わせの対応者が、ステータスの変更を行うユーザーと一致しているか確認し、
     * 一致していれば、statusを更新し、user_idをNULLにする
     *
     * @param array $params
     * @param int $user_id
     * @param string $status
     * @return void
     */
    public static function changeStatus($params, $user_id, $status)
    {
        if(self::hasContactUser($params, $user_id)) {
            // statusを更新し、user_idをNULLにする
            self::where('id', '=', $params['id'])->update(['status' => $status, 'user_id' => NULL]);
        }
    }

    /**
     * お問い合わせの対応者が、操作を行うユーザーが対応者と一致しているかチェックを行う
     *
     * @param array $params
     * @param int $user_id
     * @return boolean
     */
    public static function hasContactUser($params, $user_id)
    {
        $db = self::select('user_id')->where('id', '=', $params['id'])->first();
        return $db['user_id'] === $user_id;
    }

    /**
     * statusがパラメータと一致するレコードをcreated_atが新しい順に10件取得
     * appendsでページネーションのリンクにパラメータ追加
     *
     * @param array $params
     * @return Contact
     */
    public static function getContactArchive($params)
    {
        return self::where('status', '=', $params['status'])->orderBy('created_at', 'desc')->paginate(10)->appends($params);
    }

    /**
     * contact_idが一致するレコード取得
     * SELECT contacts.*, users.email FROM contacts LEFT JOIN users ON users.id = contacts.user_id WHERE contacts.id = ?
     *
     * @param array $params
     * @return void
     */
    public static function getContactDetailIndex($params)
    {
        return self::select('contacts.*', 'users.email')
                ->where('contacts.id', '=', $params['id'])
                ->leftJoin('users', 'users.id', '=', 'contacts.user_id')->first();
    }

    /**
     * 送信先メールアドレスと送信者メールアドレスを取得
     *
     * @param array $inputs
     * @return void
     */
    public static function getContactEmail($inputs)
    {
        return self::select('contacts.mail as contact', 'users.email as user')
                ->where('contacts.id', '=', $inputs['id'])
                ->leftJoin('users', 'users.id', '=', 'contacts.user_id')
                ->first();
    }
}
