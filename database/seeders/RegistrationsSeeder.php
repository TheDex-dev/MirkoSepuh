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
                'patientid' => 1,
                'registrationnumber' => 'REG/EM/251014-0001',
                'registrationdate' => '2024-10-25 08:00:00',
                'patientclass' => 'IGD',
                'attendingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
            ],
            [
                'patientid' => 1,
                'registrationnumber' => 'REG/EM/251014-0008',
                'registrationdate' => '2024-10-25 10:00:00',
                'patientclass' => 'KLINIK ORTHOPEDI',
                'attendingdoctor' => 'dr. BUDI SANTOSO, Sp.OT',
            ],
            [
                'patientid' => 2,
                'registrationnumber' => 'REG/EM/251014-0002',
                'registrationdate' => '2024-10-25 09:00:00',
                'patientclass' => 'POLI DALAM',
                'attendingdoctor' => 'dr. SITI AMINAH, Sp.PD',
            ],
            [
                'patientid' => 3,
                'registrationnumber' => 'REG/EM/251014-0003',
                'registrationdate' => '2024-10-25 11:00:00',
                'patientclass' => 'IGD',
                'attendingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
            ],
            [
                'patientid' => 4,
                'registrationnumber' => 'REG/EM/251014-0004',
                'registrationdate' => '2024-10-25 13:00:00',
                'patientclass' => 'POLI KANDUNGAN',
                'attendingdoctor' => 'dr. RATNA SARI, Sp.OG',
            ],
            [
                'patientid' => 5,
                'registrationnumber' => 'REG/EM/251014-0005',
                'registrationdate' => '2024-10-25 14:00:00',
                'patientclass' => 'SAKURA 12',
                'attendingdoctor' => 'dr. HENDRA GUNAWAN, Sp.B',
            ],
        ];

        foreach ($registrations as $registration) {
            DB::table('registration')->insert([
                'patientid' => $registration['patientid'],
                'registrationnumber' => $registration['registrationnumber'],
                'registrationdate' => $registration['registrationdate'],
                'patientclass' => $registration['patientclass'],
                'attendingdoctor' => $registration['attendingdoctor'],
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin']),
            ]);
        }
    }
}
