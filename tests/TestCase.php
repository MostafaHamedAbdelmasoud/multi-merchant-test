<?php

namespace Tests;

use App\Models\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Set the currently logged in admin for the application.
     *
     * @param null $driver
     *
     */
    public function actingAsAdmin($driver = 'api')
    {
        $admin = User::factory()->create([
            'type' => 1
        ]);

        $this->be($admin, $driver);

        return $admin;
    }

    /**
     * Set the currently logged in customer for the application.
     *
     * @param null $driver
     *
     */
    public function actingAsCustomer($driver = 'api')
    {
        $customer = User::factory()->create([
            'type' => 3
        ]);

        $this->be($customer, $driver);

        return $customer;
    }

    /**
     * Set the currently logged in customer for the application.
     *
     * @param null $driver
     *
     */
    public function actingAsStoreOwner($driver = 'api')
    {
        $storeOwner = User::factory()->create([
            'type' => 2
        ]);

        $this->be($storeOwner, $driver);

        return $storeOwner;
    }
}
