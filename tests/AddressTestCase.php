<?php

class AddressTest extends TestCase
{
    public function testDataBaseAccess()
    {
        $address = new App\Models\Address();
        $results = $address->query()->where('zip', '001-0000')->get();

        self::assertTrue(count($results) === 1);
    }

}
