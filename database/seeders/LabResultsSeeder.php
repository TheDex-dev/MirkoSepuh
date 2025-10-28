<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labResults = [
            // Results for lab_id 1 (Patient 1, first order - Hematology)
            [
                'lab_id' => 1,
                'group_name' => 'Hematologi',
                'test_name' => 'Hemoglobin',
                'result_date' => '2024-10-25 10:30:00',
                'flag' => 'H',
                'result_value' => '16.9',
                'unit' => 'g/dL',
                'standard_value' => '13.2 - 17.3',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 1,
                'group_name' => 'Hematologi',
                'test_name' => 'Leukosit',
                'result_date' => '2024-10-25 10:30:00',
                'flag' => '',
                'result_value' => '8.5',
                'unit' => '10^3/uL',
                'standard_value' => '4.0 - 10.0',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 1,
                'group_name' => 'Hematologi',
                'test_name' => 'Trombosit',
                'result_date' => '2024-10-25 10:30:00',
                'flag' => '',
                'result_value' => '245',
                'unit' => '10^3/uL',
                'standard_value' => '150 - 400',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 1,
                'group_name' => 'Hematologi',
                'test_name' => 'Hematokrit',
                'result_date' => '2024-10-25 10:30:00',
                'flag' => '',
                'result_value' => '45.2',
                'unit' => '%',
                'standard_value' => '40.0 - 54.0',
                'result_comment' => null,
                'result_note' => null,
            ],
            // Results for lab_id 2 (Patient 1, second order - Blood Sugar)
            [
                'lab_id' => 2,
                'group_name' => 'Gula Darah Sewaktu',
                'test_name' => 'Gula Darah Sewaktu',
                'result_date' => '2024-10-25 15:00:00',
                'flag' => '',
                'result_value' => '98',
                'unit' => 'mg/dL',
                'standard_value' => '< 200',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 2,
                'group_name' => 'Lipid Profile',
                'test_name' => 'Cholesterol Total',
                'result_date' => '2024-10-25 15:00:00',
                'flag' => 'H',
                'result_value' => '225',
                'unit' => 'mg/dL',
                'standard_value' => '< 200',
                'result_comment' => 'Slightly elevated',
                'result_note' => null,
            ],
            // Results for lab_id 3 (Patient 2 - Liver Function)
            [
                'lab_id' => 3,
                'group_name' => 'Fungsi Hati',
                'test_name' => 'SGOT',
                'result_date' => '2024-10-25 11:30:00',
                'flag' => '',
                'result_value' => '28',
                'unit' => 'U/L',
                'standard_value' => '< 40',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 3,
                'group_name' => 'Fungsi Hati',
                'test_name' => 'SGPT',
                'result_date' => '2024-10-25 11:30:00',
                'flag' => '',
                'result_value' => '32',
                'unit' => 'U/L',
                'standard_value' => '< 41',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 3,
                'group_name' => 'Fungsi Ginjal',
                'test_name' => 'Ureum',
                'result_date' => '2024-10-25 11:30:00',
                'flag' => '',
                'result_value' => '35',
                'unit' => 'mg/dL',
                'standard_value' => '15 - 50',
                'result_comment' => null,
                'result_note' => null,
            ],
            [
                'lab_id' => 3,
                'group_name' => 'Fungsi Ginjal',
                'test_name' => 'Kreatinin',
                'result_date' => '2024-10-25 11:30:00',
                'flag' => '',
                'result_value' => '1.1',
                'unit' => 'mg/dL',
                'standard_value' => '0.6 - 1.3',
                'result_comment' => null,
                'result_note' => null,
            ],
            // Results for lab_id 4 (Patient 3 - Hematology)
            [
                'lab_id' => 4,
                'group_name' => 'Hematologi',
                'test_name' => 'Hemoglobin',
                'result_date' => '2024-10-25 12:15:00',
                'flag' => 'L',
                'result_value' => '11.2',
                'unit' => 'g/dL',
                'standard_value' => '13.2 - 17.3',
                'result_comment' => 'Anemia',
                'result_note' => null,
            ],
            [
                'lab_id' => 4,
                'group_name' => 'Hematologi',
                'test_name' => 'Leukosit',
                'result_date' => '2024-10-25 12:15:00',
                'flag' => 'H',
                'result_value' => '12.5',
                'unit' => '10^3/uL',
                'standard_value' => '4.0 - 10.0',
                'result_comment' => 'Leukositosis',
                'result_note' => null,
            ],
            [
                'lab_id' => 4,
                'group_name' => 'Hematologi',
                'test_name' => 'LED',
                'result_date' => '2024-10-25 12:15:00',
                'flag' => '',
                'result_value' => '15',
                'unit' => 'mm/jam',
                'standard_value' => '0 - 20',
                'result_comment' => null,
                'result_note' => null,
            ],
        ];

        foreach ($labResults as $result) {
            DB::table('lab_results')->insert([
                'lab_id' => $result['lab_id'],
                'group_name' => $result['group_name'],
                'test_name' => $result['test_name'],
                'result_date' => $result['result_date'],
                'flag' => $result['flag'],
                'result_value' => $result['result_value'],
                'unit' => $result['unit'],
                'standard_value' => $result['standard_value'],
                'result_comment' => $result['result_comment'],
                'result_note' => $result['result_note'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
