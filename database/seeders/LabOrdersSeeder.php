<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labOrders = [
            [
                'patientid' => 1,
                'orderdate' => '2024-10-25 08:30:00',
                'procedurename' => 'Complete Blood Count',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'status' => 'Completed',
                'resultsummary' => 'Hemoglobin: 14.5 g/dL, Leukosit: 8500/µL, Trombosit: 250000/µL',
                'examname' => 'CBC',
                'unit' => 'g/dL',
                'resultcomment' => 'Normal',
                'resultnote' => 'Hasil dalam batas normal',
                'joboredrid' => 1,
            ],
            [
                'patientid' => 2,
                'orderdate' => '2024-10-25 14:15:00',
                'procedurename' => 'Blood Glucose & Cholesterol',
                'requestingdoctor' => 'dr. BUDI SANTOSO, Sp.OT',
                'status' => 'Completed',
                'resultsummary' => 'Gula Darah: 95 mg/dL, Cholesterol: 180 mg/dL',
                'examname' => 'Glucose',
                'unit' => 'mg/dL',
                'resultcomment' => 'Normal',
                'resultnote' => 'Hasil dalam batas normal',
                'joboredrid' => 2,
            ],
            [
                'patientid' => 3,
                'orderdate' => '2024-10-25 09:00:00',
                'procedurename' => 'Liver & Kidney Function',
                'requestingdoctor' => 'dr. SITI AMINAH, Sp.PD',
                'status' => 'Completed',
                'resultsummary' => 'SGOT: 25 U/L, SGPT: 30 U/L, Ureum: 28 mg/dL, Kreatinin: 1.0 mg/dL',
                'examname' => 'LFT',
                'unit' => 'U/L',
                'resultcomment' => 'Normal',
                'resultnote' => 'Fungsi hati dan ginjal baik',
                'joboredrid' => 3,
            ],
            [
                'patientid' => 4,
                'orderdate' => '2024-10-25 10:45:00',
                'procedurename' => 'Hemoglobin & LED',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'status' => 'Completed',
                'resultsummary' => 'Hemoglobin: 13.2 g/dL, Leukosit: 7500/µL, LED: 10 mm/jam',
                'examname' => 'Hb',
                'unit' => 'g/dL',
                'resultcomment' => 'Normal',
                'resultnote' => 'Tidak ada infeksi akut',
                'joboredrid' => 4,
            ],
            [
                'patientid' => 5,
                'orderdate' => '2024-10-25 11:20:00',
                'procedurename' => 'Prenatal Screening',
                'requestingdoctor' => 'dr. RATNA SARI, Sp.OG',
                'status' => 'Completed',
                'resultsummary' => 'Hemoglobin: 12.5 g/dL, HbsAg: Non-reactive, HIV: Non-reactive',
                'examname' => 'Screening',
                'unit' => 'g/dL',
                'resultcomment' => 'Normal',
                'resultnote' => 'Hasil skrining baik',
                'joboredrid' => 5,
            ],
        ];

        foreach ($labOrders as $order) {
            DB::table('laboratory')->insert([
                'patientid' => $order['patientid'],
                'orderdate' => $order['orderdate'],
                'procedurename' => $order['procedurename'],
                'requestingdoctor' => $order['requestingdoctor'],
                'status' => $order['status'],
                'resultsummary' => $order['resultsummary'],
                'examname' => $order['examname'],
                'unit' => $order['unit'],
                'resultcomment' => $order['resultcomment'],
                'resultnote' => $order['resultnote'],
                'joboredrid' => $order['joboredrid'],
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin']),
            ]);
        }
    }
}
