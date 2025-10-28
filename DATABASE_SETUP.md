# Database Setup Guide

This guide explains the migration files and seeders created for the MirkoSepuh database.

## Migration Files Created

All migration files are located in `database/migrations/` and include:

1. **create_patient_table** - Patient master data
2. **create_registration_table** - Patient registration records
3. **create_allergy_table** - Patient allergies
4. **create_patientbilling_table** - Patient billing information
5. **create_diagnosis_table** - Patient diagnosis records
6. **create_vitalsign_table** - Vital signs measurements
7. **create_radiologyorder_table** - Radiology orders
8. **create_labolatorium_table** - Laboratory orders and results
9. **create_joborder_table** - Job orders
10. **create_joborderdetail_table** - Job order details

## Seeder Files Created

All seeder files are located in `database/seeders/` and include:

### Existing Seeders (already in project):
- `PatientsSeeder` - Seeds patient data
- `RegistrationsSeeder` - Seeds registration data
- `LabOrdersSeeder` - Seeds lab orders
- `LabResultsSeeder` - Seeds lab results
- `VitalSignsSeeder` - Seeds vital signs
- `RadiologyOrdersSeeder` - Seeds radiology orders

### New Seeders Created:
- `AllergySeeder` - Seeds allergy data with sample patient allergies
- `PatientBillingSeeder` - Seeds billing data with plafond and billing amounts
- `DiagnosisSeeder` - Seeds diagnosis data with ICD codes
- `JobOrderSeeder` - Seeds job orders for various services
- `JobOrderDetailSeeder` - Seeds job order details with services and prices

## How to Run Migrations and Seeders

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create all the database tables based on the migration files.

### Step 2: Run Seeders
```bash
php artisan db:seed
```

This will populate the tables with test data in the correct order to respect foreign key constraints.

### Alternative: Migrate and Seed in One Command
```bash
php artisan migrate:fresh --seed
```

⚠️ **Warning**: This command will drop all tables and recreate them with fresh data. Use only in development!

## Database Structure

### Main Tables and Relationships

- **patient** (1) → (many) **registration**
- **patient** (1) → (many) **allergy**
- **registration** (1) → (1) **patientbilling**
- **registration** (1) → (many) **diagnosis**
- **registration** (1) → (many) **vitalsign**
- **registration** (1) → (many) **radiologyorder**
- **registration** (1) → (many) **labolatorium**
- **registration** (1) → (many) **joborder**
- **joborder** (1) → (many) **joborderdetail**

## Sample Data Overview

The seeders create sample data for testing:
- 5 sample allergy records
- 5 sample billing records with realistic amounts
- 6 sample diagnosis records with ICD-10 codes
- 5 sample job orders (Laboratory, Radiology, Pharmacy, Consultation)
- 6 sample job order details with services and prices

## Notes

1. All tables use JSON fields for `createdat`, `updatedat`, and `createduserid` to match the PostgreSQL array types in the original SQL.
2. Foreign keys are set with `onDelete('cascade')` to maintain referential integrity.
3. The seeding order in `DatabaseSeeder.php` respects foreign key constraints.
4. Make sure your `.env` file is properly configured with your database credentials before running migrations.

## Troubleshooting

If you encounter errors:
1. Check that your database connection is properly configured in `.env`
2. Ensure the database exists before running migrations
3. If migrations fail, run `php artisan migrate:rollback` and try again
4. Check the Laravel log files in `storage/logs/` for detailed error messages
