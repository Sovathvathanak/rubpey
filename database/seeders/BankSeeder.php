<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Seed the bank tables with the data from the db_bank_mng export.
     */
    public function run(): void
    {
        DB::table('tb_customers')->insert([
            ['customer_id' => 1, 'first_name' => 'Layhout', 'last_name' => 'Tang', 'Image' => 'layhout.jpg', 'password' => 'layhout99', 'pin_number' => '0912', 'national_id' => 'ID00123456', 'nationality' => 'Cambodian', 'phone' => '+855-85-312-052', 'email' => 'layhout09@gmail.com', 'address' => 'St. 2, Phnom Penh', 'data_of_birth' => '2006-12-09', 'last_login' => '2026-07-06 23:21:58', 'created_at' => '2026-07-06 23:21:58'],
            ['customer_id' => 2, 'first_name' => 'Kimkuy', 'last_name' => 'Ngo', 'Image' => 'kimkuy.jpg', 'password' => 'kimkuy0102', 'pin_number' => '1209', 'national_id' => 'ID00987654', 'nationality' => 'Cambodian', 'phone' => '+855-12-213-750', 'email' => 'kimkuyNN@gmail.com', 'address' => 'St. 63, Phnom Penh', 'data_of_birth' => '2005-10-12', 'last_login' => '2026-07-06 23:21:58', 'created_at' => '2026-07-06 23:21:58'],
            ['customer_id' => 3, 'first_name' => 'Sovanmony', 'last_name' => 'Reaksmey', 'Image' => 'mony.jpg', 'password' => 'monysovan1201', 'pin_number' => '9012', 'national_id' => 'ID00456789', 'nationality' => 'Cambodian', 'phone' => '+855-23-830-830', 'email' => 'sovanmony@gmail.com', 'address' => 'St. 271, Battam Bang', 'data_of_birth' => null, 'last_login' => '2026-07-06 23:21:58', 'created_at' => '2026-07-06 23:21:58'],
            ['customer_id' => 4, 'first_name' => 'Sovathvathanak', 'last_name' => 'Meung', 'Image' => 'naknak.jpg', 'password' => 'sovathanak1234', 'pin_number' => '1269', 'national_id' => 'ID00126629', 'nationality' => 'Cambodian', 'phone' => '+855-12-711-330', 'email' => 'naknak1204@gmail.com', 'address' => 'St. 371, Phnom Penh', 'data_of_birth' => '2025-01-01', 'last_login' => '2026-07-06 23:21:58', 'created_at' => '2026-07-06 23:21:58'],
            ['customer_id' => 5, 'first_name' => 'Vinchhou', 'last_name' => 'Phea', 'Image' => 'sopheak.jpg', 'password' => 'hashed_pw_1', 'pin_number' => '1234', 'national_id' => 'ID00111111', 'nationality' => 'Cambodian', 'phone' => '+855-12-555-666', 'email' => 'vinchhouPhea@gmail.com', 'address' => 'St. 210, Phnom Penh', 'data_of_birth' => '1998-04-12', 'last_login' => '2026-07-07 01:44:35', 'created_at' => '2026-07-07 01:44:35'],
        ]);

        DB::table('tb_accounts')->insert([
            ['account_id' => 1, 'customer_id' => 1, 'account_type' => 'Savings', 'account_number' => '001-1000', 'balance' => 1100.00, 'status' => 'Active', 'currency' => 'USD', 'account_name' => 'Layhout Main Savings'],
            ['account_id' => 2, 'customer_id' => 1, 'account_type' => 'Checking', 'account_number' => '001-1000', 'balance' => 300.00, 'status' => 'Active', 'currency' => 'USD', 'account_name' => 'Layhout Daily Checking'],
            ['account_id' => 3, 'customer_id' => 2, 'account_type' => 'Savings', 'account_number' => '001-2000', 'balance' => 5200.50, 'status' => 'Active', 'currency' => 'USD', 'account_name' => 'Kimkuy Savings'],
            ['account_id' => 4, 'customer_id' => 3, 'account_type' => 'Savings', 'account_number' => '001-3000', 'balance' => 1300.00, 'status' => 'Active', 'currency' => 'KHR', 'account_name' => 'Sovanmony Riel Savings'],
            ['account_id' => 5, 'customer_id' => 4, 'account_type' => 'Checking', 'account_number' => '001-4000', 'balance' => 2100.75, 'status' => 'Active', 'currency' => 'USD', 'account_name' => 'Sovathvathanak Checking'],
        ]);

        DB::table('tb_transfers')->insert([
            ['transfer_id' => 1, 'from_account_id' => 2, 'to_account_id' => 3, 'amount' => 100.00, 'reference_code' => 'TRF-0001', 'transfer_date' => '2026-07-07 00:04:50', 'status' => 'Completed'],
            ['transfer_id' => 2, 'from_account_id' => 5, 'to_account_id' => 4, 'amount' => 50.00, 'reference_code' => 'TRF-0002', 'transfer_date' => '2026-07-07 00:04:50', 'status' => 'Completed'],
            ['transfer_id' => 3, 'from_account_id' => null, 'to_account_id' => 1, 'amount' => 250.00, 'reference_code' => 'DEP-0001', 'transfer_date' => '2026-07-07 00:04:50', 'status' => 'Completed'],
            ['transfer_id' => 4, 'from_account_id' => 2, 'to_account_id' => 4, 'amount' => 500.00, 'reference_code' => 'TCP-0002', 'transfer_date' => '2026-07-07 14:19:57', 'status' => 'Failed'],
            ['transfer_id' => 6, 'from_account_id' => 2, 'to_account_id' => 4, 'amount' => 500.00, 'reference_code' => 'TCP-0001', 'transfer_date' => '2026-07-07 14:26:01', 'status' => 'Completed'],
            ['transfer_id' => 7, 'from_account_id' => null, 'to_account_id' => 1, 'amount' => 100.00, 'reference_code' => 'DEP-0002', 'transfer_date' => '2026-07-07 14:46:15', 'status' => 'Failed'],
        ]);

        DB::table('tb_transaction_hts')->insert([
            ['transaction_id' => 1, 'account_id' => 2, 'transfer_id' => 1, 'amount' => -100.00, 'description' => 'Transfer to Kimkuy Ngo', 'transfer_date' => '2026-07-07 00:05:09', 'status' => 'Completed'],
            ['transaction_id' => 2, 'account_id' => 3, 'transfer_id' => 1, 'amount' => 100.00, 'description' => 'Transfer from Layhout Tang', 'transfer_date' => '2026-07-07 00:05:09', 'status' => 'Completed'],
            ['transaction_id' => 3, 'account_id' => 5, 'transfer_id' => 2, 'amount' => -50.00, 'description' => 'Transfer to Sovanmony Reaksmey', 'transfer_date' => '2026-07-07 00:05:10', 'status' => 'Completed'],
            ['transaction_id' => 4, 'account_id' => 4, 'transfer_id' => 2, 'amount' => 50.00, 'description' => 'Transfer from Sovathvathanak Meung', 'transfer_date' => '2026-07-07 00:05:10', 'status' => 'Completed'],
            ['transaction_id' => 5, 'account_id' => 1, 'transfer_id' => 3, 'amount' => 250.00, 'description' => 'Deposit', 'transfer_date' => '2026-07-07 00:05:10', 'status' => 'Completed'],
            ['transaction_id' => 6, 'account_id' => 2, 'transfer_id' => 4, 'amount' => -500.00, 'description' => 'Transfer from Sovathvathanak Meung: Just For Fun', 'transfer_date' => '2026-07-07 14:19:57', 'status' => 'Failed'],
            ['transaction_id' => 8, 'account_id' => 2, 'transfer_id' => 6, 'amount' => -500.00, 'description' => 'Transfer to Sovathvathanak Meung: Just For Fun', 'transfer_date' => '2026-07-07 14:26:01', 'status' => 'Completed'],
            ['transaction_id' => 9, 'account_id' => 4, 'transfer_id' => 6, 'amount' => 500.00, 'description' => 'Transfer from Layhout Tang: Just For Fun', 'transfer_date' => '2026-07-07 14:26:01', 'status' => 'Completed'],
            ['transaction_id' => 10, 'account_id' => 1, 'transfer_id' => 7, 'amount' => 100.00, 'description' => 'Deposit', 'transfer_date' => '2026-07-07 14:46:16', 'status' => 'Failed'],
        ]);
    }
}
