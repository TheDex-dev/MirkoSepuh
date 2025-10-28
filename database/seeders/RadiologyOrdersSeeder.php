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
                'patient_id' => 1,
                'reg_no' => 'REG/EM/251014-0001',
                'rad_date' => '2024-10-25',
                'rad_time' => '09:00:00',
                'tx_no' => 'JO251014-00054',
                'from_unit' => 'IGD',
                'doctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'items' => json_encode(['Rontgen Thorax AP', 'Rontgen Cervical']),
                'images' => json_encode([
                    'https://example.com/images/thorax-001.jpg',
                    'https://example.com/images/cervical-001.jpg'
                ]),
                'result_text' => 'Cor dan pulmo dalam batas normal. Tidak tampak infiltrat atau massa. Sinus costophrenicus kanan dan kiri tajam.',
            ],
            [
                'patient_id' => 2,
                'reg_no' => 'REG/EM/251014-0002',
                'rad_date' => '2024-10-25',
                'rad_time' => '10:30:00',
                'tx_no' => 'JO251014-00055',
                'from_unit' => 'POLI DALAM',
                'doctor' => 'dr. SITI AMINAH, Sp.PD',
                'items' => json_encode(['USG Abdomen']),
                'images' => json_encode([
                    'https://example.com/images/usg-abdomen-001.jpg'
                ]),
                'result_text' => 'Hepar: ukuran normal, echotexture homogen, tidak tampak SOL. Vesica fellea: dinding tidak menebal, tidak tampak batu. Lien, pancreas, kedua ginjal dalam batas normal.',
            ],
            [
                'patient_id' => 3,
                'reg_no' => 'REG/EM/251014-0003',
                'rad_date' => '2024-10-25',
                'rad_time' => '11:45:00',
                'tx_no' => 'JO251014-00056',
                'from_unit' => 'IGD',
                'doctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'items' => json_encode(['Rontgen Genu AP/Lateral']),
                'images' => json_encode([
                    'https://example.com/images/genu-ap-001.jpg',
                    'https://example.com/images/genu-lat-001.jpg'
                ]),
                'result_text' => 'Alignment tulang-tulang pembentuk sendi genu dalam batas normal. Celah sendi tidak menyempit. Tidak tampak fraktur atau dislokasi. Soft tissue swelling (-)',
            ],
            [
                'patient_id' => 4,
                'reg_no' => 'REG/EM/251014-0004',
                'rad_date' => '2024-10-25',
                'rad_time' => '12:00:00',
                'tx_no' => 'JO251014-00057',
                'from_unit' => 'POLI KANDUNGAN',
                'doctor' => 'dr. RATNA SARI, Sp.OG',
                'items' => json_encode(['USG Obstetri']),
                'images' => json_encode([
                    'https://example.com/images/usg-obs-001.jpg'
                ]),
                'result_text' => 'Janin tunggal, hidup, presentasi kepala. BPD: 8.5 cm, FL: 6.8 cm, AC: 30.2 cm. Taksiran berat janin: 2800 gram. Plasenta di fundus, grade II. Air ketuban cukup. Kesan: Gravida aterm sesuai usia kehamilan 38-39 minggu.',
            ],
            [
                'patient_id' => 5,
                'reg_no' => 'REG/EM/251014-0005',
                'rad_date' => '2024-10-25',
                'rad_time' => '14:30:00',
                'tx_no' => 'JO251014-00058',
                'from_unit' => 'SAKURA 12',
                'doctor' => 'dr. HENDRA GUNAWAN, Sp.B',
                'items' => json_encode(['CT Scan Abdomen dengan Kontras']),
                'images' => json_encode([
                    'https://example.com/images/ct-abdomen-001.jpg',
                    'https://example.com/images/ct-abdomen-002.jpg',
                    'https://example.com/images/ct-abdomen-003.jpg'
                ]),
                'result_text' => 'Hepar, lien, pankreas, dan kedua ginjal dalam batas normal. Tidak tampak massa atau koleksi cairan abnormal. Usus halus dan usus besar tidak tampak dilatasi. Tidak tampak free air atau free fluid di cavum abdomen. Kesan: Tidak tampak kelainan pada CT Scan Abdomen.',
            ],
        ];

        foreach ($radiologyOrders as $order) {
            DB::table('radiology_orders')->insert([
                'patient_id' => $order['patient_id'],
                'reg_no' => $order['reg_no'],
                'rad_date' => $order['rad_date'],
                'rad_time' => $order['rad_time'],
                'tx_no' => $order['tx_no'],
                'from_unit' => $order['from_unit'],
                'doctor' => $order['doctor'],
                'items' => $order['items'],
                'images' => $order['images'],
                'result_text' => $order['result_text'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
