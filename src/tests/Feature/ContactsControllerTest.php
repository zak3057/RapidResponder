<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Mail\ContactSendmail;

class ContactsControllerTest extends TestCase
{
    // テストで入れたデータはテスト後に削除する
    // use RefreshDatabase;

    /**
     * statusが正しいか
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('contact.index'));
        $response->assertStatus(200)
                    ->assertSee('<h2>お問い合わせ</h2>');
        // dump($response->content());
    }

    /**
     * 入力内容が正しい場合
     *
     * @return void
     */
    public function testConfirmSuccess()
    {
        // キャッシュクリア
        Artisan::call('config:clear');

        // $this->withoutExceptionHandling();

        $request = [
            'name' => '山田　太郎',              // 16文字以下
            'mail' => 'yamada@example.com',     // 200文字以下
            'tel' => '09000000000',             // 12文字以下
            'item' => 'A001',                   // 指定されたもののみ
            'body' => 'aaa',                    // 2000文字以下
        ];
        $response = $this->post(route('contact.confirm'), $request);
        $response->assertStatus(200)
                    ->assertSee('<h2>お問い合わせ内容確認</h2>');
    }

    /**
     * 明らかに正しくない値
     *
     * @return void
     */
    public function testConfirmFailure()
    {
        $request = [
            'name' => ' ',
            'mail' => ' ',
            'tel' => ' ',
            'item' => ' ',
            'body' => ' ',
        ];
        $response = $this->from(route('contact.index'))
                        ->post(route('contact.confirm'), $request);
        $response->assertStatus(302)
                ->assertRedirect(route('contact.index'));  // リダイレクト先チェック

        $this->get(route('contact.index'))
        ->assertSee('<small class="form-text text-danger">氏名を入力してください。</small>')
        ->assertSee('<small class="form-text text-danger">メールアドレスを入力してください。</small>')
        ->assertSee('<small class="form-text text-danger">電話番号を入力してください。</small>')
        ->assertSee('<small class="form-text text-danger">商品種別を選択してください。</small>')
        ->assertSee('<small class="form-text text-danger">問い合わせ内容を入力してください。</small>');
    }

    /**
     * 境界値チェック 真
     *
     * @return void
     */
    public function testConfirmSuccess2()
    {
        $request = [
            'name' => '0123456789abcdef',       // 16文字
            'mail' => 'adayamadayamadayamadayamadayamadayamadayamadayamadayamadaya@example.com',                       // 200文字
            'tel' => '000000000000',            // 12文字
            'item' => 'A016',                   // 指定されたもののみ
            'body' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',                    // 2000文字
        ];
        $response = $this->post(route('contact.confirm'), $request);
        $response->assertStatus(200)
                    ->assertSee('<h2>お問い合わせ内容確認</h2>');
    }

    /**
     * 境界値チェック 偽
     *
     * @return void
     */
    public function testConfirmFailure2()
    {
        $request = [
            'name' => '0123456789abcdefg',
            'mail' => 'adayamadayamadayamadayamadayamadayamadayamadayamadayamadayaadayamadayamadayamadayamadayamadayamadayamadayamadayamadayaadayamadayamadayamadayamadayamadayamadayamadayamadayamadaya@example.com',
            'tel' => '0000000000000',
            'item' => 'A017',
            'body' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ];
        // ->from() で前の画面を設定
        $response = $this->from(route('contact.index'))
            ->post(route('contact.confirm'), $request);

        // リダイレクト先が正しいことを確認
        $response->assertStatus(302)
                ->assertRedirect(route('contact.index'));

        // リダイレクト後にエラーメッセージが表示されているか確認
        $this->get(route('contact.index'))
        ->assertSee('<small class="form-text text-danger">氏名は16文字以内で入力してください。</small>')
        ->assertSee('<small class="form-text text-danger">正しいメールアドレスを入力してください。</small>')
        ->assertSee('<small class="form-text text-danger">電話番号は200文字以内で入力してください。</small>')
        ->assertSee('<small class="form-text text-danger">商品種別の値が正しくありません</small>')
        ->assertSee('<small class="form-text text-danger">問い合わせ内容は2000文字以内で入力してください。</small>');
    }

    /**
     * フォームに入力されたものが正しくDBに登録されているか
     *
     * @return void
     */
    public function testThanks()
    {
        // メールが送信されることを防ぐ
        \Illuminate\Support\Facades\Mail::fake();

        $email = 'yamada@example.com';

        $request = [
            'name' => '山田　太郎',              // 16文字以下
            'mail' => $email,                   // 200文字以下
            'tel' => '09000000000',             // 12文字以下
            'item' => 'A001',                   // 指定されたもののみ
            'body' => 'aaa',                    // 2000文字以下
        ];
        $response = $this->post('/contact/thanks', $request);
        $response->assertStatus(200)
                ->assertSee('<h2>お問い合わせ完了いたしました</h2>');
        $this->assertDatabaseHas('contacts', [
            'name' => '山田　太郎',              // 16文字以下
            'mail' => $email,                   // 200文字以下
            'tel' => '09000000000',             // 12文字以下
            'item' => 'A001',                   // 指定されたもののみ
            'body' => 'aaa',                    // 2000文字以下
        ]);

        // 1回送信されたことをアサート
        \Illuminate\Support\Facades\Mail::assertSent(ContactSendmail::class, 1);

        // メールが指定したユーザーに送信されていることをアサート
        \Illuminate\Support\Facades\Mail::assertSent(
            ContactSendmail::class,
            function ($mail) use ($email) {
                return $mail->to[0]['address'] === $email;
            }
        );
    }
}
