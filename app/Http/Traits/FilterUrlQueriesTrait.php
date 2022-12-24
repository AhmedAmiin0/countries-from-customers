<?php

namespace App\Http\Traits;

trait FilterUrlQueriesTrait
{
    /**
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */

    public function checkIfPhoneIsValidAndGetCustomer(array $filters, array $query): array
    {
        if (isset($filters['valid']) && $filters['valid'] === 'valid') {
            $query = array_filter($query, fn ($item)  => $item->state);
            $query = array_values($query);
        }
        if (isset($filters['valid']) && $filters['valid'] === 'invalid') {
            $query = array_filter($query, fn ($item)  => !$item->state);
            $query = array_values($query);
        }
        return $query;
    }
}
