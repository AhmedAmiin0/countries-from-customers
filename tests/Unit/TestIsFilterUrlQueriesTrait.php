<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TestIsFilterUrlQueriesTrait extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_filter_url_queries_valid()
    {
        $trait = $this->getObjectForTrait('App\Http\Traits\FilterUrlQueriesTrait');
        $query = [
            0 => (object) [
                'state' => true,
            ],
            1 => (object) [
                'state' => false,
            ],
        ];
        $filters = [
            'valid' => 'valid',
        ];
        $result = $trait->checkIfPhoneIsValidAndGetCustomer($filters, $query);
        $this->assertCount(1, $result);
        $this->assertTrue($result[0]->state);
    }

    public function test_filter_url_queries_invalid()
    {
        $trait = $this->getObjectForTrait('App\Http\Traits\FilterUrlQueriesTrait');
        $query = [
            0 => (object) [
                'state' => true,
            ],
            1 => (object) [
                'state' => false,
            ],
        ];
        $filters = [
            'valid' => 'invalid',
        ];
        $result = $trait->checkIfPhoneIsValidAndGetCustomer($filters, $query);
        $this->assertCount(1, $result);
        $this->assertFalse($result[0]->state);
    }

}
