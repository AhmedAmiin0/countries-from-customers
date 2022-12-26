<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_countries_list_with_no_filters_applied()
    {
        $response = $this->get('');
        $response->assertStatus(200)
            ->assertSee('country')
            ->assertSee('phone')
            ->assertSee('state')
            ->assertSee('country code');
    }
}
