<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = [
            [
                'name' => 'AHMAD SUDIRMAN',
                'mrn' => '2024-001234',
                'gender' => 'Male',
                'dob' => '1985-05-15',
                'guarantor' => 'BPJS KESEHATAN',
                'bpjs_sep_no' => '0301R0011024K000001',
                'cov_class' => 'Rawat Jalan',
            ],
            [
                'name' => 'SITI NURHALIZA',
                'mrn' => '2024-001235',
                'gender' => 'Female',
                'dob' => '1990-08-22',
                'guarantor' => 'BPJS KESEHATAN',
                'bpjs_sep_no' => '0301R0011024K000002',
                'cov_class' => 'Rawat Inap',
            ],
            [
                'name' => 'BAMBANG WIJAYA',
                'mrn' => '2024-001236',
                'gender' => 'Male',
                'dob' => '1978-03-10',
                'guarantor' => 'Umum',
                'bpjs_sep_no' => null,
                'cov_class' => 'Rawat Jalan',
            ],
            [
                'name' => 'DEWI LESTARI',
                'mrn' => '2024-001237',
                'gender' => 'Female',
                'dob' => '1995-12-05',
                'guarantor' => 'BPJS KESEHATAN',
                'bpjs_sep_no' => '0301R0011024K000003',
                'cov_class' => 'Rawat Jalan',
            ],
            [
                'name' => 'RIAN PRATAMA',
                'mrn' => '2024-001238',
                'gender' => 'Male',
                'dob' => '2000-01-18',
                'guarantor' => 'Asuransi Swasta',
                'bpjs_sep_no' => null,
                'cov_class' => 'Rawat Inap',
            ],
        ];

        foreach ($patients as $patient) {
            DB::table('patients')->insert([
                'name' => $patient['name'],
                'mrn' => $patient['mrn'],
                'gender' => $patient['gender'],
                'dob' => $patient['dob'],
                'guarantor' => $patient['guarantor'],
                'bpjs_sep_no' => $patient['bpjs_sep_no'],
                'cov_class' => $patient['cov_class'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
