<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $billings = [
            [
                'registrationid' => 1,
                'plafond' => 10000000.00,
                'totalbilling' => 2500000.00,
                'difference' => 7500000.00,
                'lastupdated' => now(),
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 2,
                'plafond' => 15000000.00,
                'totalbilling' => 5000000.00,
                'difference' => 10000000.00,
                'lastupdated' => now(),
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 3,
                'plafond' => 8000000.00,
                'totalbilling' => 3200000.00,
                'difference' => 4800000.00,
                'lastupdated' => now(),
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 4,
                'plafond' => 12000000.00,
                'totalbilling' => 7800000.00,
                'difference' => 4200000.00,
                'lastupdated' => now(),
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 5,
                'plafond' => 20000000.00,
                'totalbilling' => 15000000.00,
                'difference' => 5000000.00,
                'lastupdated' => now(),
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
        ];

        DB::table('patientbilling')->insert($billings);
    }
}
