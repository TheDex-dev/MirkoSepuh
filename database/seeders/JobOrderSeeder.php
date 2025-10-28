<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobOrders = [
            [
                'registration' => 1,
                'ordertype' => 'Laboratory',
                'requestingdoctor' => 'Dr. Smith',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Complete blood count requested',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'registration' => 2,
                'ordertype' => 'Radiology',
                'requestingdoctor' => 'Dr. Johnson',
                'orderdate' => now(),
                'status' => 'In Progress',
                'notes' => 'Chest X-ray requested',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'registration' => 3,
                'ordertype' => 'Pharmacy',
                'requestingdoctor' => 'Dr. Williams',
                'orderdate' => now(),
                'status' => 'Pending',
                'notes' => 'Pain medication prescription',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'registration' => 4,
                'ordertype' => 'Consultation',
                'requestingdoctor' => 'Dr. Brown',
                'orderdate' => now(),
                'status' => 'Scheduled',
                'notes' => 'Cardiology consultation required',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'registration' => 5,
                'ordertype' => 'Laboratory',
                'requestingdoctor' => 'Dr. Davis',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Blood glucose test',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
        ];

        DB::table('joborder')->insert($jobOrders);
    }
}
