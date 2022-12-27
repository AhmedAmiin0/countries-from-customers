<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    const Countries = [
        '237' => [
            'country_code' => '237',
            'regex' => '/\(237\)\ ?[2368]\d{7,8}$/',
            'name' => 'Cameroon'
        ],
        '251' => [
            'country_code' => '251',
            'regex' => '/\(251\)\ ?[1-59]\d{8}$/',
            'name' => 'Ethiopia'
        ],
        '212' => [
            'country_code' => '212',
            'regex' => '/\(212\)\ ?[5-9]\d{8}$/',
            'name' => 'Morocco'
        ],
        '258' => [
            'country_code' => '258',
            'regex' => '/\(258\)\ ?[28]\d{7,8}$/',
            'name' => 'Mozambique'
        ],
        '256' => [
            'country_code' => '256',
            'regex' => '/\(256\)\ ?\d{9}$/',
            'name' => 'Uganda'
        ],
    ];
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*
     *  test if the customer is valid
     *  test customer is invalid
     *  test customer table is empty
     * test customer table is not empty
     * test customer table is not empty and has valid customer
     * test customer table is not empty and has invalid customer
     */
    protected $customers = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->customers = Customer::all();
    }

    public function test_countries_list_with_no_filters_applied()
    {
        $response = $this->get(route('countries.index'));
        $response->assertSee('Countries');
        $response->assertSee('Phone');
        $response->assertSee('state');
        $response->assertSee('Valid');
        $response->assertSee('Invalid');
        $response->assertSee('country code');
        $response->assertSee('country');
    }

    public function test_countries_list_with_country_filter_applied()
    {
        $response = $this->get(route('countries.index', ['country' => '237']));
        $response->assertViewIs('index');
        $response->assertViewHas('customers');
        $response->assertViewHas('count');
        $response->assertViewHas('limit');
        $response->assertViewHas('offset');
        $response->assertViewHas('countries');
        $response->assertStatus(200);
        $response->assertSee('237');
        $response->assertViewHas('customers', function ($customers) {
            foreach ($customers as $customer) {
                $this->assertEquals($customer->country['country_code'], '237');
            }
            return true;
        });
    }

}
