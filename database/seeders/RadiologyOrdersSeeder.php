<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RadiologyOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $radiologyOrders = [
            [
                'registrationid' => 1,
                'orderdate' => '2024-10-25 09:00:00',
                'procedurename' => 'Rontgen Thorax AP & Cervical',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'status' => 'Completed',
                'resultsummary' => 'Cor dan pulmo dalam batas normal. Tidak tampak infiltrat atau massa. Sinus costophrenicus kanan dan kiri tajam.',
            ],
            [
                'registrationid' => 3,
                'orderdate' => '2024-10-25 10:30:00',
                'procedurename' => 'USG Abdomen',
                'requestingdoctor' => 'dr. SITI AMINAH, Sp.PD',
                'status' => 'Completed',
                'resultsummary' => 'Hepar: ukuran normal, echotexture homogen, tidak tampak SOL. Vesica fellea: dinding tidak menebal, tidak tampak batu. Lien, pancreas, kedua ginjal dalam batas normal.',
            ],
            [
                'registrationid' => 4,
                'orderdate' => '2024-10-25 11:45:00',
                'procedurename' => 'Rontgen Genu AP/Lateral',
                'requestingdoctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'status' => 'Completed',
                'resultsummary' => 'Alignment tulang-tulang pembentuk sendi genu dalam batas normal. Celah sendi tidak menyempit. Tidak tampak fraktur atau dislokasi. Soft tissue swelling (-)',
            ],
            [
                'registrationid' => 5,
                'orderdate' => '2024-10-25 12:00:00',
                'procedurename' => 'USG Obstetri',
                'requestingdoctor' => 'dr. RATNA SARI, Sp.OG',
                'status' => 'Completed',
                'resultsummary' => 'Janin tunggal, hidup, presentasi kepala. BPD: 8.5 cm, FL: 6.8 cm, AC: 30.2 cm. Taksiran berat janin: 2800 gram. Plasenta di fundus, grade II. Air ketuban cukup. Kesan: Gravida aterm sesuai usia kehamilan 38-39 minggu.',
            ],
            [
                'registrationid' => 6,
                'orderdate' => '2024-10-25 14:30:00',
                'procedurename' => 'CT Scan Abdomen dengan Kontras',
                'requestingdoctor' => 'dr. HENDRA GUNAWAN, Sp.B',
                'status' => 'Completed',
                'resultsummary' => 'Hepar, lien, pankreas, dan kedua ginjal dalam batas normal. Tidak tampak massa atau koleksi cairan abnormal. Usus halus dan usus besar tidak tampak dilatasi. Tidak tampak free air atau free fluid di cavum abdomen. Kesan: Tidak tampak kelainan pada CT Scan Abdomen.',
            ],
        ];

        foreach ($radiologyOrders as $order) {
            DB::table('radiologyorder')->insert([
                'registrationid' => $order['registrationid'],
                'orderdate' => $order['orderdate'],
                'procedurename' => $order['procedurename'],
                'requestingdoctor' => $order['requestingdoctor'],
                'status' => $order['status'],
                'resultsummary' => $order['resultsummary'],
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin']),
            ]);
        }
    }
}
