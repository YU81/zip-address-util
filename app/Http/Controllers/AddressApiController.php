<?php

namespace App\Http\Controllers;

use App\Models;

class AddressApiController extends Controller
{
    public function get($zip = null, $ken_furi = null, $city_furi = null, $town_furi = null)
    {
        $addr = new Models\Address();
        /** @var \Illuminate\Database\Query\Builder $q */
        $q           = $addr->newQuery();
        $decoded_zip = Models\Address::processZip($zip);
        $q->orWhere('zip', '=', $decoded_zip);

        foreach (['ken_furi', 'city_furi', 'town_furi'] as $col) {
            Models\Address::filterQueryFuri(${$col}, $q, $col);
        }

        /** @var \Illuminate\Database\Eloquent\Collection|static[] $results */
        $columns = [
            'ken_id',
            'zip',
            'ken_name',
            'ken_furi',
            'city_name',
            'city_furi',
            'town_name',
            'town_furi',
            'kyoto_street',
            'block_name',
            'office_name',
            'office_address',
        ];

        $results      = $q->take(10)->get($columns);
        // NULLのフィールドを省略
        $resultsArray = array_map(function ($result) use ($columns) {
            foreach ($columns as $col) {
                if (array_key_exists($col, $result)
                    && ($result[$col] === 'NULL' || trim(mb_convert_kana($result[$col], 's')) === '')
                ) {
                    unset($result[$col]);
                }
            }

            return $result;
        }, $results->toArray());

        $date = date('Y/m/d H:i:s');
        return ($results->count() > 0)
            ? response()->json(['error' => 'success', 'date' => $date, 'count' => $results->count(), 'results' => $resultsArray])
            : response()->json(['error' => 'error', 'date' => $date, 'count' => 0]);
    }
}
