<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateJobOrderReferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update job orders with correct laboratory and radiology IDs
        // This runs after all lab and radiology records are created
        
        // Update job order 1 (Patient 1)
        DB::table('joborder')->where('joborderid', 1)->update([
            'laboratoryid' => 1,
            'radiologyid' => 1
        ]);
        
        // Update job order 2 (Patient 2) 
        DB::table('joborder')->where('joborderid', 2)->update([
            'laboratoryid' => 2,
            'radiologyid' => 2
        ]);
        
        // Update job order 3 (Patient 3)
        DB::table('joborder')->where('joborderid', 3)->update([
            'laboratoryid' => 3,
            'radiologyid' => 3
        ]);
        
        // Update job order 4 (Patient 4)
        DB::table('joborder')->where('joborderid', 4)->update([
            'laboratoryid' => 4,
            'radiologyid' => 4
        ]);
        
        // Update job order 5 (Patient 5)
        DB::table('joborder')->where('joborderid', 5)->update([
            'laboratoryid' => 5,
            'radiologyid' => 5
        ]);
    }
}