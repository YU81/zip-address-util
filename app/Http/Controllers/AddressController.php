<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;

class AddressController extends Controller
{
    public function get($zip = null, $ken_furi = null, $city_furi = null, $town_furi = null)
    {
        $addr = new Models\Address();
        /** @var Builder $q */
        $q    = $addr->newQuery();
        if (isset($zip)) {
            if ($zip != "_" && $zip != "-") {
                $decoded_zip = rawurldecode($zip);
                $decoded_zip = mb_convert_kana($decoded_zip, "a");
                if (strlen($decoded_zip) == 7) {
                    $decoded_zip = substr($decoded_zip, 0, 3) . '-' . substr($decoded_zip, 3, 4);
                    $q->orwhere('zip', '=', $decoded_zip);
                }
            }
        }
        $this->_filterFuri($ken_furi, $q, 'ken_furi');
        $this->_filterFuri($city_furi, $q, 'city_furi');
        $this->_filterFuri($town_furi, $q, 'town_furi');

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
        /** @var Builder $q */
        $q = $addr->newQuery();
        if (isset($searchWord)) {
            if ($searchWord != "_" && $searchWord != "-") {
                $decoded_searchWord = rawurldecode($searchWord);
                $decoded_searchWord = mb_convert_kana($decoded_searchWord, "a");
                if (strlen($decoded_searchWord) == 7) {
                    $decoded_searchWord = substr($decoded_searchWord, 0, 3) . '-' . substr($decoded_searchWord, 3, 4);
                    $q->orwhere('zip', '=', $decoded_searchWord);
                }
            }
        }
        $this->_filterFuri($searchWord, $q, 'ken_furi');
        $this->_filterFuri($searchWord, $q, 'city_furi');
        $this->_filterFuri($searchWord, $q, 'town_furi');

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
        ]);

        $resultCount = count($results);

        return view('index', ['results' => $results, 'count' => $resultCount]);
    }

    /**
     * @param string $furi
     * @param Builder $q
     */
    private function _filterFuri($furi, $q, $colName)
    {
        if (isset($furi)) {
            $decoded_furi = rawurldecode($furi);
            $decoded_furi = mb_convert_kana($decoded_furi, "CK");
            if ($furi != "_" && $furi != "-") {
                $q->orWhere($colName, 'like', '%' . $decoded_furi . '%');
            }
        }
    }
}
