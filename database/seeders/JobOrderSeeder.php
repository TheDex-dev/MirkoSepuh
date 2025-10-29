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
        // Create placeholder job orders first (these will be updated later)
        $jobOrders = [
            [
                'laboratoryid' => 0, // Placeholder, will be updated after lab records are created
                'radiologyid' => 0, // Placeholder, will be updated after radiology records are created
                'ordertype' => 'Combined Lab & Radiology',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Patient 1 - Complete blood count and chest X-ray',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'laboratoryid' => 0,
                'radiologyid' => 0,
                'ordertype' => 'Combined Lab & Radiology',
                'requestingdoctor' => 'dr. SITI AMINAH, Sp.PD',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Patient 2 - Blood glucose and abdominal USG',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'laboratoryid' => 0,
                'radiologyid' => 0,
                'ordertype' => 'Combined Lab & Radiology',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Patient 3 - Liver function and knee X-ray',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'laboratoryid' => 0,
                'radiologyid' => 0,
                'ordertype' => 'Combined Lab & Radiology',
                'requestingdoctor' => 'dr. RATNA SARI, Sp.OG',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Patient 4 - Hemoglobin and obstetric USG',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
            [
                'laboratoryid' => 0,
                'radiologyid' => 0,
                'ordertype' => 'Combined Lab & Radiology',
                'requestingdoctor' => 'dr. HENDRA GUNAWAN, Sp.B',
                'orderdate' => now(),
                'status' => 'Completed',
                'notes' => 'Patient 5 - Prenatal screening and abdominal CT',
                'createdat' => now(),
                'updatedat' => json_encode([now()]),
                'creteduserid' => json_encode(['admin'])
            ],
        ];

        DB::table('joborder')->insert($jobOrders);
    }
}
