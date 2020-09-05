<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * statusが正しいか
     *
     * @return void
     */
    public function testStatus()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // public function FunctionName(Type $var = null)
    // {
    //     # code...
    // }
}
