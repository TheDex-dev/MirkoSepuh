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
                'mrn' => '2024-001234',
                'fullname' => 'AHMAD SUDIRMAN',
                'dateofbirth' => '1985-05-15',
                'gender' => 'Male',
                'guarantor' => 'BPJS KESEHATAN',
                'phonenumber' => '081234567890',
            ],
            [
                'mrn' => '2024-001235',
                'fullname' => 'SITI NURHALIZA',
                'dateofbirth' => '1990-08-22',
                'gender' => 'Female',
                'guarantor' => 'BPJS KESEHATAN',
                'phonenumber' => '081234567891',
            ],
            [
                'mrn' => '2024-001236',
                'fullname' => 'BAMBANG WIJAYA',
                'dateofbirth' => '1978-03-10',
                'gender' => 'Male',
                'guarantor' => 'Umum',
                'phonenumber' => '081234567892',
            ],
            [
                'mrn' => '2024-001237',
                'fullname' => 'DEWI LESTARI',
                'dateofbirth' => '1995-12-05',
                'gender' => 'Female',
                'guarantor' => 'BPJS KESEHATAN',
                'phonenumber' => '081234567893',
            ],
            [
                'mrn' => '2024-001238',
                'fullname' => 'RIAN PRATAMA',
                'dateofbirth' => '2000-01-18',
                'gender' => 'Male',
                'guarantor' => 'Asuransi Swasta',
                'phonenumber' => '081234567894',
            ],
        ];

        foreach ($patients as $patient) {
            DB::table('patient')->insert([
                'mrn' => $patient['mrn'],
                'fullname' => $patient['fullname'],
                'dateofbirth' => $patient['dateofbirth'],
                'gender' => $patient['gender'],
                'guarantor' => $patient['guarantor'],
                'phonenumber' => $patient['phonenumber'],
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin']),
            ]);
        }
    }
}
