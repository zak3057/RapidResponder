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
        $response = $this->get(route('contact.archive.detail.index', [
            'id' => 1
        ]));
        $response
            ->assertStatus(200)
            ->assertSee('<h2>お問い合わせ詳細</h2>')
            ->assertSee('2020-10-17 14:03:34')
            ->assertSee('Gryphon. Alice did not at all what had become of me? They&#039;re dreadfully fond of pretending to be Number One,&#039; said Alice. &#039;What IS the fun?&#039; said Alice. &#039;Come on, then,&#039; said the youth, &#039;as I mentioned before, And have grown most uncommonly fat; Yet you turned a corner, &#039;Oh my ears and whiskers, how late it&#039;s getting!&#039; She was close behind her, listening: so she went round the neck of the Shark, But, when the White Rabbit read:-- &#039;They told me he was obliged to have lessons to learn! No, I&#039;ve made up my.');
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
        $response = $this->get(route('contact.archive.detail.index', [
            'id' => 1
        ]));
        $response->assertStatus(302);
    }

    /**
     * 存在しない問い合わせにアクセス
     *
     * @return void
     */
    public function testStatusFailure2()
    {
        $response = $this->actingAs($this->user);
        $response = $this->get(route('contact.archive.detail.index', [
            'id' => 1001
        ]));
        $response->assertStatus(500);
    }

    /**
     * ステータス変更
     * TODO: 何故かstatus変更されない
     *
     * @return void
     */
    public function testStart()
    {
        $response = $this->actingAs($this->user);
        $response = $this->get('/contact/archive/detail/start?id=1');
        $response
            ->assertStatus(302)
            ->assertRedirect('/contact/archive/detail?');
    }

    // public function testMessageSuccess(Type $var = null)
    // {
    //     # code...
    // }
}
