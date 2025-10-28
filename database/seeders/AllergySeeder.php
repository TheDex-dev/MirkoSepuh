<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allergies = [
            [
                'patientid' => 1,
                'allergyname' => 'Penicillin',
                'recordeddate' => '2024-01-15',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'patientid' => 1,
                'allergyname' => 'Peanuts',
                'recordeddate' => '2024-01-15',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'patientid' => 2,
                'allergyname' => 'Aspirin',
                'recordeddate' => '2024-02-10',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'patientid' => 3,
                'allergyname' => 'Latex',
                'recordeddate' => '2024-03-05',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'patientid' => 4,
                'allergyname' => 'Sulfa drugs',
                'recordeddate' => '2024-04-20',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
        ];

        DB::table('allergy')->insert($allergies);
    }
}
