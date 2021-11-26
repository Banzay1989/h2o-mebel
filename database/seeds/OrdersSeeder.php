<?php

use App\Order;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Factory::create('ru_RU');
        for ($i = 1; $i < 100; $i++) {
            $order = [
                'name' => $faker->sentence(2),
                'description' => $faker->sentence(10),
                'completion_date' => Carbon::now()->addDays(random_int(1, 100))->toDateString(),
                'status' => Order::STATUSES[random_int(0,count(Order::STATUSES)-1)],

            ];
            Order::create($order);
        }
    }
}
