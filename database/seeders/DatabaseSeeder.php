<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $account1 = Account::create([
            'user_id' => $user->id,
            'bank' => 'BRI',
            'balance' => 1000000,
            'account_number' => '0987654321',
            'pin' => '654321'
        ]);

        $account2 = Account::create([
            'user_id' => $user->id,
            'bank' => 'BCA',
            'balance' => 1000000,
            'account_number' => '1234567890',
            'pin' => '123456'
        ]);

        $account3 = Account::create([
            'user_id' => $user->id,
            'bank' => 'BNI',
            'balance' => 1000000,
            'account_number' => '8887777',
            'pin' => '190999'
        ]);

        Transaction::insert([
            [
                'sender_id' => $account1->id,
                'recipient_id' => $account2->id,
                'type' => 'transfer',
                'amount' => 50000,
                'status' => 1,
                'created_at' => '2021-06-21 10:00:00'
            ],
            [
                'sender_id' => $account1->id,
                'recipient_id' => $account2->id,
                'type' => 'transfer',
                'amount' => 250000,
                'status' => 1,
                'created_at' => '2021-06-21 10:01:00'
            ],
            [
                'sender_id' => $account1->id,
                'recipient_id' => $account1->id,
                'type' => 'tarik_tunai',
                'amount' => 250000,
                'status' => 1,
                'created_at' => '2021-06-21 10:02:00'
            ],
            [
                'sender_id' => $account2->id,
                'recipient_id' => $account3->id,
                'type' => 'transfer',
                'amount' => 500000,
                'status' => 1,
                'created_at' => '2021-06-21 10:03:00'
            ],
            [
                'sender_id' => $account3->id,
                'recipient_id' => $account1->id,
                'type' => 'transfer',
                'amount' => 90000,
                'status' => 1,
                'created_at' => '2021-06-21 10:04:00'
            ],
        ]);
    }
}
