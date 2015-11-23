<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Support\Facades\Input;

class AddressController extends Controller
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
        $results = $q->take(10)->get([
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
        ]);

        return ($results->count() > 0)
            ? response()->json($results->toArray())
            : response()->json(['error' => 'error']);
    }

    public function index()
    {
        return view('index');
    }

    public function searchResult()
    {
        $searchWord = Input::get('search', '');

        $addr = new Models\Address();
        /** @var \Illuminate\Database\Query\Builder $q */
        $q                  = $addr->newQuery();
        $decoded_searchWord = Models\Address::processZip($searchWord);
        $q->orWhere('zip', '=', $decoded_searchWord);

        foreach (['ken_furi', 'city_furi', 'town_furi'] as $col) {
            Models\Address::filterQueryFuri($searchWord, $q, $col);
        }
        foreach (['ken_name', 'city_name', 'town_name', 'kyoto_street', 'block_name'] as $col) {
            Models\Address::filterQueryKanji($searchWord, $q, $col);
        }

        /** @var \Illuminate\Database\Eloquent\Collection|static[] $results */
        $results = $q->take(100)->get([
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
        ]);

        $resultCount = count($results);

        return view('index', ['results' => $results, 'count' => $resultCount, 'searchWord' => $searchWord]);
    }
}
