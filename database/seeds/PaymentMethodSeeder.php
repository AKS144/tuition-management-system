<?php

use Illuminate\Database\Seeder;
use App\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = [
            [
                'name' => 'Cash',
                // 'branch_id' => '1'
            ],
            [
                'name' => 'Check',
                // 'branch_id' => '1'
            ],
            [
                'name' => 'Credit Card',
                // 'branch_id' => '1'
            ],
            [
                'name' => 'Bank Transfer',
                // 'branch_id' => '1'
            ],
        ];

        foreach($paymentMethods as $key => $value) {
            PaymentMethod::create($value);
        }
    }
}
