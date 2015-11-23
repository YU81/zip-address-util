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
}
