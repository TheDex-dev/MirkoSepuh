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
                'patient_id' => 1,
                'reg_no' => 'REG/EM/251014-0001',
                'order_date' => '2024-10-25 08:30:00',
                'tx_no' => 'JDG2101L4-00083',
                'from_unit' => 'IGD',
                'doctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'urgent' => true,
                'items' => json_encode(['Hemoglobin', 'Leukosit', 'Trombosit', 'Hematokrit']),
                'price' => 'Rp. 29,625.00',
            ],
            [
                'patient_id' => 1,
                'reg_no' => 'REG/EM/251014-0008',
                'order_date' => '2024-10-25 14:15:00',
                'tx_no' => 'JDG2101L4-00084',
                'from_unit' => 'SAKURA 12',
                'doctor' => 'dr. BUDI SANTOSO, Sp.OT',
                'urgent' => false,
                'items' => json_encode(['Gula Darah Sewaktu', 'Cholesterol Total']),
                'price' => 'Rp. 15,000.00',
            ],
            [
                'patient_id' => 2,
                'reg_no' => 'REG/EM/251014-0002',
                'order_date' => '2024-10-25 09:00:00',
                'tx_no' => 'JDG2101L4-00085',
                'from_unit' => 'POLI DALAM',
                'doctor' => 'dr. SITI AMINAH, Sp.PD',
                'urgent' => false,
                'items' => json_encode(['SGOT', 'SGPT', 'Ureum', 'Kreatinin']),
                'price' => 'Rp. 42,500.00',
            ],
            [
                'patient_id' => 3,
                'reg_no' => 'REG/EM/251014-0003',
                'order_date' => '2024-10-25 10:45:00',
                'tx_no' => 'JDG2101L4-00086',
                'from_unit' => 'IGD',
                'doctor' => 'dr. AHMAD FAUZI, Sp.EM',
                'urgent' => true,
                'items' => json_encode(['Hemoglobin', 'Leukosit', 'LED']),
                'price' => 'Rp. 22,000.00',
            ],
            [
                'patient_id' => 4,
                'reg_no' => 'REG/EM/251014-0004',
                'order_date' => '2024-10-25 11:20:00',
                'tx_no' => 'JDG2101L4-00087',
                'from_unit' => 'POLI KANDUNGAN',
                'doctor' => 'dr. RATNA SARI, Sp.OG',
                'urgent' => false,
                'items' => json_encode(['Hemoglobin', 'HbsAg', 'HIV']),
                'price' => 'Rp. 35,000.00',
            ],
        ];

        foreach ($labOrders as $order) {
            DB::table('lab_orders')->insert([
                'patient_id' => $order['patient_id'],
                'reg_no' => $order['reg_no'],
                'order_date' => $order['order_date'],
                'tx_no' => $order['tx_no'],
                'from_unit' => $order['from_unit'],
                'doctor' => $order['doctor'],
                'urgent' => $order['urgent'],
                'items' => $order['items'],
                'price' => $order['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
