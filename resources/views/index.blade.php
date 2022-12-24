<x-layout title='Get Country From Phone Number'>
  <form action="{{ route('customers.index') }}" method="GET">
    <div class="row ">
      <h1>Countries</h1>
      <div class="d-flex justify-content-between">

        <div>
          <label for="country">
            country
            <select name="country" id="country" class="form-select">
              <option value="">All</option>
              @foreach ($countries as $country)
                <option value="{{ $country['country_code'] }}" @if ($country['country_code'] == request()->country) selected @endif>
                  {{ $country['name'] }}</option>
              @endforeach
            </select>
          </label>
          <label for="valid">
            valid
            <select name="valid" class="form-select">
              <option value="">All</option>
              <option value="valid" @if (request()->valid == 'valid') selected @endif>Valid</option>
              <option value="invalid" @if (request()->valid == 'invalid') selected @endif>Invalid</option>
            </select>
          </label>
        </div>
        <div>
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <table class="table
        table-striped
        ">
      <thead>
        <tr>
          <th scope="col"> country </th>
          <th scope="col"> state </th>
          <th scope="col"> country code </th>
          <th scope="col"> phone </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($customers as $customer)
          <tr>
            <td>{{ $customer->country['name'] }}</td>
            <td>{{ $customer->state ? 'OK' : 'NOK' }}</td>
            <td>+{{ $customer->country['country_code'] }}</td>
            <td>{{ $customer->phone }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-between">
      <div>
        <select name="limit" id="limit" class="form-select">
          <option value="5" @if ($limit == 5) selected @endif>5</option>
          <option value="10" @if ($limit == 10) selected @endif>10</option>
          <option value="15" @if ($limit == 15) selected @endif>15</option>
          <option value="20" @if ($limit == 20) selected @endif>20</option>
        </select>
      </div>
      <div>
        @if ($offset > 0)
          <a href="{{ route('customers.index', ['offset' => $offset - $limit, 'limit' => $limit, 'country' => request()->country, 'valid' => request()->valid]) }}"
            class="btn btn-primary">Previous</a>
        @endif
        @if ($offset + $limit < $count)
          <a href="{{ route('customers.index', ['offset' => $offset + $limit, 'limit' => $limit, 'country' => request()->country, 'valid' => request()->valid]) }}"
            class="btn btn-primary">Next</a>
        @endif
      </div>
    </div>

  </form>
</x-layout>
