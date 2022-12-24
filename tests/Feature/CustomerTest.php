<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_countries_list_with_no_filters_applied()
    {
        $this->seed();
        $response = $this->get('');
        $response->assertStatus(200);
    }
    public function test_countries_list_with_country_filter_applied()
    {
        $this->seed();
        $response = $this->get('?country=237');
        $response->assertStatus(200);
    }

    public function test_countries_list_with_country_filter_applied_and_invalid()
    {
        $this->seed();
        $response = $this->get('?country=237&valid=valid');
        $response->assertStatus(200);
    }

    public function test_countries_list_with_country_filter_applied_and_invalid_and_valid()
    {
        $this->seed();
        $response = $this->get('?country=237&valid=invalid');
        $response->assertStatus(200);
    }

    public function test_countries_list_with_country_filter_applied_and_invalid_and_valid_and_limit()
    {
        $this->seed();
        $response = $this->get('?country=237&valid=invalid&limit=10');
        $response->assertStatus(200);
    }

    public function test_countries_list_with_country_filter_applied_and_invalid_and_valid_and_limit_and_offset()
    {
        $this->seed();
        $response = $this->get('?country=237&valid=invalid&limit=10&offset=10');
        $response->assertStatus(200);
    }
}
