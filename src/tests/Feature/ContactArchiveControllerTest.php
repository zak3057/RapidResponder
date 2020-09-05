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
     * statusが正しいか
     * TODO: controllerからbladeに渡している値をチェック
     *
     * @return void
     */
    public function testStatusSuccess()
    {
        $response = $this->actingAs($this->user);
        $response = $this->get('/contact/archive');
        $response
            ->assertStatus(200)
            ->assertSee('<h2>お問い合わせ一覧</h2>');
            // ->assertJsonFragment([
            //     'status' =>  '未対応'
            // ]);

        // dump($response);
    }

    /**
     * ログインしていないユーザーがアクセス
     */
    public function testStatusFailure()
    {
        $response = $this->get('/contact/archive');
        $response->assertStatus(302);
    }

    public function testPaginate()
    {
        $response = $this->actingAs($this->user);
        $response = $this->get('/contact/archive?status=%E6%9C%AA%E5%AF%BE%E5%BF%9C&amp;page=2');
        $response
            ->assertStatus(200)
            ->assertSee('<span class="page-link">2</span>');
    }
}
