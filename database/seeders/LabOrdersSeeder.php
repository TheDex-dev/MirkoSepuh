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
                'registrationid' => 1,
                'orderdate' => '2024-10-25 08:30:00',
                'procedurename' => 'Complete Blood Count',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'status' => 'Completed',
                'resultsummary' => 'Hemoglobin: 14.5 g/dL, Leukosit: 8500/µL, Trombosit: 250000/µL',
                'examname' => 'CBC',
                'unit' => 'g/dL',
                'result_comment' => 'Normal',
                'ressult_note' => 'Hasil dalam batas normal',
            ],
            [
                'registrationid' => 2,
                'orderdate' => '2024-10-25 14:15:00',
                'procedurename' => 'Blood Glucose & Cholesterol',
                'requestingdoctor' => 'dr. BUDI SANTOSO, Sp.OT',
                'status' => 'Completed',
                'resultsummary' => 'Gula Darah: 95 mg/dL, Cholesterol: 180 mg/dL',
                'examname' => 'Glucose',
                'unit' => 'mg/dL',
                'result_comment' => 'Normal',
                'ressult_note' => 'Hasil dalam batas normal',
            ],
            [
                'registrationid' => 3,
                'orderdate' => '2024-10-25 09:00:00',
                'procedurename' => 'Liver & Kidney Function',
                'requestingdoctor' => 'dr. SITI AMINAH, Sp.PD',
                'status' => 'Completed',
                'resultsummary' => 'SGOT: 25 U/L, SGPT: 30 U/L, Ureum: 28 mg/dL, Kreatinin: 1.0 mg/dL',
                'examname' => 'LFT',
                'unit' => 'U/L',
                'result_comment' => 'Normal',
                'ressult_note' => 'Fungsi hati dan ginjal baik',
            ],
            [
                'registrationid' => 4,
                'orderdate' => '2024-10-25 10:45:00',
                'procedurename' => 'Hemoglobin & LED',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'status' => 'Completed',
                'resultsummary' => 'Hemoglobin: 13.2 g/dL, Leukosit: 7500/µL, LED: 10 mm/jam',
                'examname' => 'Hb',
                'unit' => 'g/dL',
                'result_comment' => 'Normal',
                'ressult_note' => 'Tidak ada infeksi akut',
            ],
            [
                'registrationid' => 5,
                'orderdate' => '2024-10-25 11:20:00',
                'procedurename' => 'Prenatal Screening',
                'requestingdoctor' => 'dr. RATNA SARI, Sp.OG',
                'status' => 'Completed',
                'resultsummary' => 'Hemoglobin: 12.5 g/dL, HbsAg: Non-reactive, HIV: Non-reactive',
                'examname' => 'Screening',
                'unit' => 'g/dL',
                'result_comment' => 'Normal',
                'ressult_note' => 'Hasil skrining baik',
            ],
        ];

        foreach ($labOrders as $order) {
            DB::table('labolatorium')->insert([
                'registrationid' => $order['registrationid'],
                'orderdate' => $order['orderdate'],
                'procedurename' => $order['procedurename'],
                'requestingdoctor' => $order['requestingdoctor'],
                'status' => $order['status'],
                'resultsummary' => $order['resultsummary'],
                'examname' => $order['examname'],
                'unit' => $order['unit'],
                'result_comment' => $order['result_comment'],
                'ressult_note' => $order['ressult_note'],
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'cretaeduserid' => json_encode(['admin']),
            ]);
        }
    }
}
