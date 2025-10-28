<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diagnoses = [
            [
                'registrationid' => 1,
                'diagnosistype' => 'Primary',
                'diagnosiscode' => 'J18.9',
                'description' => 'Pneumonia, unspecified organism',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 1,
                'diagnosistype' => 'Secondary',
                'diagnosiscode' => 'I10',
                'description' => 'Essential (primary) hypertension',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 2,
                'diagnosistype' => 'Primary',
                'diagnosiscode' => 'E11.9',
                'description' => 'Type 2 diabetes mellitus without complications',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 3,
                'diagnosistype' => 'Primary',
                'diagnosiscode' => 'M54.5',
                'description' => 'Low back pain',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 4,
                'diagnosistype' => 'Primary',
                'diagnosiscode' => 'K21.9',
                'description' => 'Gastro-esophageal reflux disease without esophagitis',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'registrationid' => 5,
                'diagnosistype' => 'Primary',
                'diagnosiscode' => 'S06.0',
                'description' => 'Concussion',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
        ];

        DB::table('diagnosis')->insert($diagnoses);
    }
}
