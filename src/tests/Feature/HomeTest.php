<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ContactsControllerTest extends TestCase
{
    // テストで入れたデータはテスト後に削除する
    // use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザ作成
        $this->user = factory(User::class)->create();
    }

    /**
     * ログイン認証テスト
     * TODO: json形式でログイン後のユーザーデータを取得できない
     */
    public function testLogin(): void
    {
        // 作成したテストユーザのemailとpasswordで認証リクエスト
        $response = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'secret',
        ]);

        // 正しいレスポンスが返り、ユーザ名が取得できることを確認
        $response
            ->assertStatus(302)
            ->assertRedirect('/home');  // リダイレクト先チェック
            // ->assertJson(['email' => $this->user->emal]);

        // 指定したユーザーが認証されていることを確認
        $this->assertAuthenticatedAs($this->user);
    }

    /**
     * statusが正しいか
     *
     * @return void
     */
    public function testStatusSuccess()
    {
        $response = $this->actingAs($this->user);
        $response = $this->get('/home');
        $response
            ->assertStatus(200)
            ->assertSee('<h2>ログインに成功しました</h2>');
            // ->assertJsonFragment([
            //     'test' =>  'aaa'
            // ]);
    }
}
