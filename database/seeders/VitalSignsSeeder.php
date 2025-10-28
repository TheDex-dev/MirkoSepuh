<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VitalSignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vitalSigns = [
            // Patient 1
            [
                'patient_id' => 1,
                'vs_date' => '2024-10-25',
                'vs_time' => '08:00:00',
                'value' => '120/80',
                'unit' => 'mmHg',
            ],
            [
                'patient_id' => 1,
                'vs_date' => '2024-10-25',
                'vs_time' => '08:00:00',
                'value' => '78',
                'unit' => 'bpm',
            ],
            [
                'patient_id' => 1,
                'vs_date' => '2024-10-25',
                'vs_time' => '08:00:00',
                'value' => '36.5',
                'unit' => '°C',
            ],
            [
                'patient_id' => 1,
                'vs_date' => '2024-10-25',
                'vs_time' => '08:00:00',
                'value' => '98',
                'unit' => '%',
            ],
            [
                'patient_id' => 1,
                'vs_date' => '2024-10-25',
                'vs_time' => '08:00:00',
                'value' => '18',
                'unit' => 'x/min',
            ],
            // Patient 2
            [
                'patient_id' => 2,
                'vs_date' => '2024-10-25',
                'vs_time' => '09:00:00',
                'value' => '130/85',
                'unit' => 'mmHg',
            ],
            [
                'patient_id' => 2,
                'vs_date' => '2024-10-25',
                'vs_time' => '09:00:00',
                'value' => '82',
                'unit' => 'bpm',
            ],
            [
                'patient_id' => 2,
                'vs_date' => '2024-10-25',
                'vs_time' => '09:00:00',
                'value' => '37.2',
                'unit' => '°C',
            ],
            [
                'patient_id' => 2,
                'vs_date' => '2024-10-25',
                'vs_time' => '09:00:00',
                'value' => '97',
                'unit' => '%',
            ],
            // Patient 3
            [
                'patient_id' => 3,
                'vs_date' => '2024-10-25',
                'vs_time' => '10:30:00',
                'value' => '140/90',
                'unit' => 'mmHg',
            ],
            [
                'patient_id' => 3,
                'vs_date' => '2024-10-25',
                'vs_time' => '10:30:00',
                'value' => '88',
                'unit' => 'bpm',
            ],
            [
                'patient_id' => 3,
                'vs_date' => '2024-10-25',
                'vs_time' => '10:30:00',
                'value' => '38.1',
                'unit' => '°C',
            ],
            [
                'patient_id' => 3,
                'vs_date' => '2024-10-25',
                'vs_time' => '10:30:00',
                'value' => '96',
                'unit' => '%',
            ],
            // Patient 4
            [
                'patient_id' => 4,
                'vs_date' => '2024-10-25',
                'vs_time' => '11:15:00',
                'value' => '110/70',
                'unit' => 'mmHg',
            ],
            [
                'patient_id' => 4,
                'vs_date' => '2024-10-25',
                'vs_time' => '11:15:00',
                'value' => '72',
                'unit' => 'bpm',
            ],
            [
                'patient_id' => 4,
                'vs_date' => '2024-10-25',
                'vs_time' => '11:15:00',
                'value' => '36.8',
                'unit' => '°C',
            ],
            // Patient 5
            [
                'patient_id' => 5,
                'vs_date' => '2024-10-25',
                'vs_time' => '13:00:00',
                'value' => '125/82',
                'unit' => 'mmHg',
            ],
            [
                'patient_id' => 5,
                'vs_date' => '2024-10-25',
                'vs_time' => '13:00:00',
                'value' => '80',
                'unit' => 'bpm',
            ],
            [
                'patient_id' => 5,
                'vs_date' => '2024-10-25',
                'vs_time' => '13:00:00',
                'value' => '37.0',
                'unit' => '°C',
            ],
            [
                'patient_id' => 5,
                'vs_date' => '2024-10-25',
                'vs_time' => '13:00:00',
                'value' => '99',
                'unit' => '%',
            ],
        ];

        foreach ($vitalSigns as $vitalSign) {
            DB::table('vital_signs')->insert([
                'patient_id' => $vitalSign['patient_id'],
                'vs_date' => $vitalSign['vs_date'],
                'vs_time' => $vitalSign['vs_time'],
                'value' => $vitalSign['value'],
                'unit' => $vitalSign['unit'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
