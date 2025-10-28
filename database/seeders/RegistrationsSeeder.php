<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registrations = [
            [
                'patient_id' => 1,
                'reg_no' => 'REG/EM/251014-0001',
                'reg_date' => '2024-10-25',
                'unit' => 'IGD',
                'physician' => 'dr. AHMAD FAUZI, Sp.EM',
            ],
            [
                'patient_id' => 1,
                'reg_no' => 'REG/EM/251014-0008',
                'reg_date' => '2024-10-25',
                'unit' => 'KLINIK ORTHOPEDI',
                'physician' => 'dr. BUDI SANTOSO, Sp.OT',
            ],
            [
                'patient_id' => 2,
                'reg_no' => 'REG/EM/251014-0002',
                'reg_date' => '2024-10-25',
                'unit' => 'POLI DALAM',
                'physician' => 'dr. SITI AMINAH, Sp.PD',
            ],
            [
                'patient_id' => 3,
                'reg_no' => 'REG/EM/251014-0003',
                'reg_date' => '2024-10-25',
                'unit' => 'IGD',
                'physician' => 'dr. AHMAD FAUZI, Sp.EM',
            ],
            [
                'patient_id' => 4,
                'reg_no' => 'REG/EM/251014-0004',
                'reg_date' => '2024-10-25',
                'unit' => 'POLI KANDUNGAN',
                'physician' => 'dr. RATNA SARI, Sp.OG',
            ],
            [
                'patient_id' => 5,
                'reg_no' => 'REG/EM/251014-0005',
                'reg_date' => '2024-10-25',
                'unit' => 'SAKURA 12',
                'physician' => 'dr. HENDRA GUNAWAN, Sp.B',
            ],
        ];

        foreach ($registrations as $registration) {
            DB::table('registrations')->insert([
                'patient_id' => $registration['patient_id'],
                'reg_no' => $registration['reg_no'],
                'reg_date' => $registration['reg_date'],
                'unit' => $registration['unit'],
                'physician' => $registration['physician'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
