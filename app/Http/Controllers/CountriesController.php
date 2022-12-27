<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterUrlQueriesTrait;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class CountriesController extends Controller
{
    use FilterUrlQueriesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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


    public function index()
    {

        $filters = request()->only('country', 'valid');
        $country = request('country') && array_key_exists(request('country'), self::Countries) ? self::Countries[strtolower(request('country'))] : null;
        $limit = request()->get('limit', 10);
        $offset = request()->get('offset', 0);

        // * we could work with this DB::select('SELECT * FROM customer WHERE phone like :country', ['country' => '%' . $country_code['country_code'] . '%']);
        // $res = Customer::where('phone', 'like', '%' . $country_code['country_code'] . '%')->get();
        // * or we could use eloquent
        // * but i used DB::select because i felt its better for the purpose of this test

        // * here i could have used regexp function in db but i used php preg_match function because sqlite does not support it

        // * so we get the customers and paginate them with limit and offset and then we filter them with the country

        if ($country) {
            $res = DB::select(
                'SELECT * FROM customer WHERE phone like :country limit :limit offset :offset',
                ['country' => '%(' . $country['country_code'] . ')%', 'limit' => $limit, 'offset' => $offset]
            );
            $count = DB::select(
                'SELECT count(*) FROM customer WHERE phone like :country',
                ['country' => '%(' . $country['country_code'] . ')%']
            );
            foreach ($res as $customer) {
                $customer->state = preg_match($country['regex'], $customer->phone);
                $customer->country = $country;
                $customer->phone = trim(str_replace('(' . $country['country_code'] . ')', '', $customer->phone));
            }

            $res = $this->checkIfPhoneIsValidAndGetCustomer($filters, $res);
        } else {

            $res = DB::select('SELECT * FROM customer limit :limit offset :offset', ['limit' => $limit, 'offset' => $offset]);
            $count = DB::select('SELECT count(*) FROM customer');

            foreach ($res as $customer) {
                if (array_key_exists(substr($customer->phone, 1, 3), self::Countries)) {
                    $customer->country = self::Countries[substr($customer->phone, 1, 3)];
                    $customer->state = preg_match($customer->country['regex'], $customer->phone);
                    $customer->phone = trim(str_replace('(' . $customer->country['country_code'] . ')', '', $customer->phone));
                }

            }
            $res = $this->checkIfPhoneIsValidAndGetCustomer($filters, $res);
        }


        return view('index', [
            'customers' => $res,
            'count' => $count[0]->{'count(*)'},
            'limit' => $limit,
            'offset' => $offset,
            'countries' => self::Countries,
        ]);
    }
}
