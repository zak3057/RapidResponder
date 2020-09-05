<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {



            dd(print_r($browser));


            $browser->visit('/')
                    // ->resize(1920, 1080)
                    // ->screenshot('test')
                    // ->assertSee('<h1>TOP</h1>');
                    ->dump($browser);
                    // ->assertDontSee('<h1>TOP</h1>');

            
        });
    }
}
