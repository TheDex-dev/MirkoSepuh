<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed in order to respect foreign key constraints
        $this->call([
            PatientsSeeder::class,
            RegistrationsSeeder::class,
            AllergySeeder::class,
            PatientBillingSeeder::class,
            DiagnosisSeeder::class,
            VitalSignsSeeder::class,
            JobOrderSeeder::class,
            RadiologyOrdersSeeder::class,
            LabOrdersSeeder::class,
            UpdateJobOrderReferencesSeeder::class, // Update job order references after lab and radiology are created
            JobOrderDetailSeeder::class,
        ]);
    }
}
