<?php

class AddressTest extends TestCase
{
    public function testDataBaseAccess()
    {
        $address = new App\Models\Address();
        $results = $address->query()->where('zip', '001-0000')->get();

        self::assertTrue(count($results) === 1);
    }
    public function testZipNormalize1()
    {
        $codes = ['160-0022', '160ー0022', '160－0022', '160―0022'];
        foreach ($codes as $zip) {
            $processed = App\Models\Address::processZip($zip);
            self::assertTrue($processed === $codes[0]);
            $processed2 = App\Models\Address::processZip($zip, false);
            self::assertTrue($processed2 === '1600022');
        }
    }

    public function testZipNormalize2()
    {
        $zip       = '1600022';
        $processed = App\Models\Address::processZip($zip);
        self::assertTrue($processed === '160-0022');
        $processed2 = App\Models\Address::processZip($zip, false);
        self::assertTrue($processed2 === $zip);
    }

    public function testFilterFuri()
    {
        $furiQueries  = ['しんじゅく', 'シンジュク', 'ｼﾝｼﾞｭｸ'];
        $trueColumns  = ['city_furi', 'town_furi'];
        $falseColumns = ['ken_furi'];

        foreach ($furiQueries as $furi) {
            foreach ($trueColumns as $trueColumn) {
                /** @var \Illuminate\Database\Query\Builder $q */
                $addr = new \App\Models\Address();
                $q    = $addr->newQuery();
                \App\Models\Address::filterQueryFuri($furi, $q, $trueColumn);
                $result = $q->get(['id']);
                self::assertTrue(count($result) > 0);
            }
            foreach ($falseColumns as $falseColumn) {
                $addr = new \App\Models\Address();
                $q    = $addr->newQuery();
                \App\Models\Address::filterQueryFuri($furi, $q, $falseColumn);
                $result = $q->get(['id']);
                self::assertTrue(count($result) === 0);
            }
        }
    }

    public function testFilterKanji()
    {
        $kanji        = '新宿';
        $trueColumns  = ['city_name', 'town_name'];
        $falseColumns = ['ken_name'];

        foreach ($trueColumns as $trueColumn) {
            /** @var \Illuminate\Database\Query\Builder $q */
            $addr = new \App\Models\Address();
            $q    = $addr->newQuery();
            \App\Models\Address::filterQueryFuri($kanji, $q, $trueColumn);
            $result = $q->get(['id']);
            self::assertTrue(count($result) > 0);
        }
        foreach ($falseColumns as $falseColumn) {
            /** @var \Illuminate\Database\Query\Builder $q */
            $addr = new \App\Models\Address();
            $q    = $addr->newQuery();
            \App\Models\Address::filterQueryFuri($kanji, $q, $falseColumn);
            $result = $q->get(['id']);
            self::assertTrue(count($result) === 0);
        }
    }
}
