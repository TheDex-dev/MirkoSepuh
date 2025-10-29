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
            ['patientid' => 1, 'measurementname' => 'Blood Pressure', 'measurementvalue' => '120/80 mmHg', 'measurementtime' => '2024-10-25 08:00:00'],
            ['patientid' => 1, 'measurementname' => 'Heart Rate', 'measurementvalue' => '78 bpm', 'measurementtime' => '2024-10-25 08:00:00'],
            ['patientid' => 1, 'measurementname' => 'Temperature', 'measurementvalue' => '36.5 °C', 'measurementtime' => '2024-10-25 08:00:00'],
            ['patientid' => 1, 'measurementname' => 'Oxygen Saturation', 'measurementvalue' => '98 %', 'measurementtime' => '2024-10-25 08:00:00'],
            ['patientid' => 1, 'measurementname' => 'Respiratory Rate', 'measurementvalue' => '18 x/min', 'measurementtime' => '2024-10-25 08:00:00'],
            
            // Patient 2
            ['patientid' => 2, 'measurementname' => 'Blood Pressure', 'measurementvalue' => '130/85 mmHg', 'measurementtime' => '2024-10-25 10:00:00'],
            ['patientid' => 2, 'measurementname' => 'Heart Rate', 'measurementvalue' => '82 bpm', 'measurementtime' => '2024-10-25 10:00:00'],
            ['patientid' => 2, 'measurementname' => 'Temperature', 'measurementvalue' => '37.2 °C', 'measurementtime' => '2024-10-25 10:00:00'],
            
            // Patient 3
            ['patientid' => 3, 'measurementname' => 'Blood Pressure', 'measurementvalue' => '130/85 mmHg', 'measurementtime' => '2024-10-25 09:00:00'],
            ['patientid' => 3, 'measurementname' => 'Heart Rate', 'measurementvalue' => '82 bpm', 'measurementtime' => '2024-10-25 09:00:00'],
            ['patientid' => 3, 'measurementname' => 'Temperature', 'measurementvalue' => '37.2 °C', 'measurementtime' => '2024-10-25 09:00:00'],
            ['patientid' => 3, 'measurementname' => 'Oxygen Saturation', 'measurementvalue' => '97 %', 'measurementtime' => '2024-10-25 09:00:00'],
            
            // Patient 4
            ['patientid' => 4, 'measurementname' => 'Blood Pressure', 'measurementvalue' => '140/90 mmHg', 'measurementtime' => '2024-10-25 11:00:00'],
            ['patientid' => 4, 'measurementname' => 'Heart Rate', 'measurementvalue' => '88 bpm', 'measurementtime' => '2024-10-25 11:00:00'],
            ['patientid' => 4, 'measurementname' => 'Temperature', 'measurementvalue' => '38.1 °C', 'measurementtime' => '2024-10-25 11:00:00'],
            ['patientid' => 4, 'measurementname' => 'Oxygen Saturation', 'measurementvalue' => '96 %', 'measurementtime' => '2024-10-25 11:00:00'],
            
            // Patient 5
            ['patientid' => 5, 'measurementname' => 'Blood Pressure', 'measurementvalue' => '110/70 mmHg', 'measurementtime' => '2024-10-25 13:00:00'],
            ['patientid' => 5, 'measurementname' => 'Heart Rate', 'measurementvalue' => '72 bpm', 'measurementtime' => '2024-10-25 13:00:00'],
            ['patientid' => 5, 'measurementname' => 'Temperature', 'measurementvalue' => '36.8 °C', 'measurementtime' => '2024-10-25 13:00:00'],
        ];

        foreach ($vitalSigns as $vitalSign) {
            DB::table('vitalsign')->insert([
                'patientid' => $vitalSign['patientid'],
                'measurementname' => $vitalSign['measurementname'],
                'measurementvalue' => $vitalSign['measurementvalue'],
                'measurementtime' => $vitalSign['measurementtime'],
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin']),
            ]);
        }
    }
}
