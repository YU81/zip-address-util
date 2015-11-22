<?php

class AddressTestCase extends TestCase
{
    public function testDataBaseAccess()
    {
        $address = App\Models\Address::all()->take(1);

        self::assertTrue(count($address) === 1);
    }

}