<?php

class AddressTestCase extends TestCase
{
    public function dataBaseAccess()
    {
        $address = App\Models\Address::all()->take(1);

        self::assertTrue(count($address) === 1);
    }

}