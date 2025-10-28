# Database Migration and Seeding Guide

This Laravel project includes migrations and seeders for a medical records database system.

## Database Schema

The database consists of 6 main tables:
- **patients**: Core patient information
- **registrations**: Patient visit registrations
- **lab_orders**: Laboratory test orders
- **lab_results**: Laboratory test results
- **vital_signs**: Patient vital signs measurements
- **radiology_orders**: Radiology test orders

## Setup Instructions

### 1. Configure Database Connection

Edit your `.env` file to set up PostgreSQL connection:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Run Migrations

To create all the database tables:

```bash
php artisan migrate
```

To rollback migrations:

```bash
php artisan migrate:rollback
```

To reset and re-run all migrations:

```bash
php artisan migrate:fresh
```

### 3. Seed Database with Test Data

To populate the database with dummy data for testing:

```bash
php artisan db:seed
```

Or run migrations and seeders together:

```bash
php artisan migrate:fresh --seed
```

### 4. Run Individual Seeders

You can also run individual seeders if needed:

```bash
php artisan db:seed --class=PatientsSeeder
php artisan db:seed --class=RegistrationsSeeder
php artisan db:seed --class=LabOrdersSeeder
php artisan db:seed --class=LabResultsSeeder
php artisan db:seed --class=VitalSignsSeeder
php artisan db:seed --class=RadiologyOrdersSeeder
```

## Test Data Overview

The seeders create:
- **5 patients** with varied demographics and insurance information
- **6 registrations** across different hospital units
- **5 lab orders** including urgent and routine tests
- **13 lab results** with various test results (normal, high, and low flags)
- **19 vital signs** measurements for all patients
- **5 radiology orders** with imaging results

## Database Structure Notes

- All tables use Laravel timestamps (`created_at`, `updated_at`)
- Foreign key constraints maintain referential integrity
- Array fields (items, images) are stored as JSON strings
- PostgreSQL-specific data types are used where appropriate

## Verifying the Data

After seeding, you can verify the data using PostgreSQL commands:

```sql
-- Count records in each table
SELECT 'patients' as table_name, COUNT(*) as count FROM patients
UNION ALL
SELECT 'registrations', COUNT(*) FROM registrations
UNION ALL
SELECT 'lab_orders', COUNT(*) FROM lab_orders
UNION ALL
SELECT 'lab_results', COUNT(*) FROM lab_results
UNION ALL
SELECT 'vital_signs', COUNT(*) FROM vital_signs
UNION ALL
SELECT 'radiology_orders', COUNT(*) FROM radiology_orders;
```

## Troubleshooting

If you encounter foreign key constraint errors:
1. Make sure you run migrations in order (they are timestamped correctly)
2. When seeding, ensure parent records exist before child records
3. Use `php artisan migrate:fresh --seed` to start fresh

If you need to reset everything:
```bash
php artisan migrate:fresh --seed
```
