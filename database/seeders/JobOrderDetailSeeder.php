<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobOrderDetails = [
            [
                'joborderid' => 1,
                'servicecode' => 'LAB001',
                'servicename' => 'Complete Blood Count (CBC)',
                'quantity' => 1,
                'price' => 150000.00,
                'resultvalue' => 'WBC: 7500/µL, RBC: 4.5M/µL, Hemoglobin: 14g/dL',
                'status' => 'Completed',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'joborderid' => 1,
                'servicecode' => 'LAB002',
                'servicename' => 'Lipid Profile',
                'quantity' => 1,
                'price' => 250000.00,
                'resultvalue' => 'Total Cholesterol: 180mg/dL, HDL: 45mg/dL, LDL: 110mg/dL',
                'status' => 'Completed',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'joborderid' => 2,
                'servicecode' => 'RAD001',
                'servicename' => 'Chest X-Ray',
                'quantity' => 1,
                'price' => 350000.00,
                'resultvalue' => null,
                'status' => 'In Progress',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'joborderid' => 3,
                'servicecode' => 'PHARM001',
                'servicename' => 'Ibuprofen 400mg',
                'quantity' => 30,
                'price' => 5000.00,
                'resultvalue' => null,
                'status' => 'Pending',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'joborderid' => 4,
                'servicecode' => 'CONS001',
                'servicename' => 'Cardiology Consultation',
                'quantity' => 1,
                'price' => 500000.00,
                'resultvalue' => null,
                'status' => 'Scheduled',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
            [
                'joborderid' => 5,
                'servicecode' => 'LAB003',
                'servicename' => 'Blood Glucose Test',
                'quantity' => 1,
                'price' => 75000.00,
                'resultvalue' => 'Fasting: 95mg/dL, Random: 120mg/dL',
                'status' => 'Completed',
                'createdat' => json_encode([now()]),
                'updatedat' => json_encode([now()]),
                'createduserid' => json_encode(['admin'])
            ],
        ];

        DB::table('joborderdetail')->insert($jobOrderDetails);
    }
}
