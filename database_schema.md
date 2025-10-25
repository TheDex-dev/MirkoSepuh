# Database Schema Documentation for PostgreSQL

This document describes the schema, relationships, and columns of the tables created for the PostgreSQL database based on the provided data. The structure is designed to store patient information, registrations, laboratory orders and results, vital signs, and radiology orders, with appropriate relationships to maintain data integrity.

## Table: patients
**Purpose**: Stores core patient information.
**Columns**:
- `patient_id` (SERIAL, PRIMARY KEY): Unique identifier for each patient.
- `name` (TEXT, NOT NULL): Patient's full name.
- `mrn` (TEXT): Medical Record Number, can be null or placeholder (e.g., '-').
- `gender` (TEXT): Patient's gender (e.g., 'Male', 'Female').
- `dob` (DATE): Date of birth.
- `guarantor` (TEXT): Entity responsible for payment (e.g., 'BPJS KESEHATAN').
- `bpjs_sep_no` (TEXT): BPJS insurance number, if applicable.
- `cov_class` (TEXT): Coverage class (e.g., 'Rawat Jalan').

## Table: registrations
**Purpose**: Stores registration details for patient visits, linked to patients.
**Columns**:
- `reg_id` (SERIAL, PRIMARY KEY): Unique identifier for each registration.
- `patient_id` (INTEGER, FOREIGN KEY): References `patients(patient_id)`.
- `reg_no` (TEXT, UNIQUE, NOT NULL): Unique registration number (e.g., 'REG/EM/251014-0008').
- `reg_date` (DATE): Date of registration.
- `unit` (TEXT): Department or unit (e.g., 'IGD', 'KLINIK ORTHOPEDI').
- `physician` (TEXT): Name of the attending physician.

**Relationships**:
- `patient_id` links to `patients(patient_id)` to associate each registration with a patient.

## Table: lab_orders
**Purpose**: Stores laboratory test orders, linked to patients.
**Columns**:
- `lab_id` (SERIAL, PRIMARY KEY): Unique identifier for each lab order.
- `patient_id` (INTEGER, FOREIGN KEY): References `patients(patient_id)`.
- `reg_no` (TEXT): Registration number, matching `registrations(reg_no)`.
- `order_date` (TIMESTAMP): Date and time the lab order was placed.
- `tx_no` (TEXT): Transaction number for the order (e.g., 'JDG2101L4-00083').
- `from_unit` (TEXT): Department ordering the test (e.g., 'SAKURA 12').
- `doctor` (TEXT): Name of the ordering doctor.
- `urgent` (BOOLEAN): Indicates if the order is urgent.
- `items` (TEXT[]): Array of test items ordered.
- `price` (TEXT): Cost of the order, stored as text (e.g., 'Rp. 29,625.00').

**Relationships**:
- `patient_id` links to `patients(patient_id)` to associate orders with a patient.
- `reg_no` corresponds to `registrations(reg_no)` for traceability, though not enforced as a foreign key to allow flexibility.

## Table: lab_results
**Purpose**: Stores results of laboratory tests, linked to lab orders.
**Columns**:
- `result_id` (SERIAL, PRIMARY KEY): Unique identifier for each result.
- `lab_id` (INTEGER, FOREIGN KEY): References `lab_orders(lab_id)`.
- `group_name` (TEXT): Test group (e.g., 'Hematologi', 'Gula Darah Sewaktu').
- `test_name` (TEXT): Name of the specific test (e.g., 'Hemoglobin').
- `result_date` (TIMESTAMP): Date and time of the result.
- `flag` (TEXT): Result flag (e.g., 'H' for high, '' for normal).
- `result_value` (TEXT): Test result value (e.g., '16.9').
- `unit` (TEXT): Unit of measurement (e.g., '13.2 - 17.3 g/dL').
- `standard_value` (TEXT): Standard reference value, if any.
- `result_comment` (TEXT): Additional comments on the result.
- `result_note` (TEXT): Notes, such as 'duplo'.

**Relationships**:
- `lab_id` links to `lab_orders(lab_id)` to associate results with their respective orders.

## Table: vital_signs
**Purpose**: Stores patient vital signs measurements, linked to patients.
**Columns**:
- `vs_id` (SERIAL, PRIMARY KEY): Unique identifier for each vital sign record.
- `patient_id` (INTEGER, FOREIGN KEY): References `patients(patient_id)`.
- `vs_date` (DATE): Date of the measurement.
- `vs_time` (TIME): Time of the measurement.
- `value` (TEXT): Measurement value (e.g., '98 %', '[4] Spontan').
- `unit` (TEXT): Unit of measurement, often empty for qualitative data.

**Relationships**:
- `patient_id` links to `patients(patient_id)` to associate vital signs with a patient.

## Table: radiology_orders
**Purpose**: Stores radiology test orders, linked to patients.
**Columns**:
- `rad_id` (SERIAL, PRIMARY KEY): Unique identifier for each radiology order.
- `patient_id` (INTEGER, FOREIGN KEY): References `patients(patient_id)`.
- `reg_no` (TEXT): Registration number, matching `registrations(reg_no)`.
- `rad_date` (DATE): Date of the radiology order.
- `rad_time` (TIME): Time of the radiology order.
- `tx_no` (TEXT): Transaction number (e.g., 'JO251014-00054').
- `from_unit` (TEXT): Department ordering the test (e.g., 'IGD').
- `doctor` (TEXT): Name of the ordering doctor.
- `items` (TEXT[]): Array of radiology test items.
- `images` (TEXT[]): Array of image URLs (e.g., placeholder URLs).
- `result_text` (TEXT): Textual result of the radiology test.

**Relationships**:
- `patient_id` links to `patients(patient_id)` to associate orders with a patient.
- `reg_no` corresponds to `registrations(reg_no)` for traceability, though not enforced as a foreign key.

## Schema Relationships Summary
- **patients** is the central table, linked to:
  - **registrations** via `patient_id` (one patient to many registrations).
  - **lab_orders** via `patient_id` (one patient to many lab orders).
  - **vital_signs** via `patient_id` (one patient to many vital signs).
  - **radiology_orders** via `patient_id` (one patient to many radiology orders).
- **lab_orders** is linked to **lab_results** via `lab_id` (one lab order to many results).
- **registrations** provides a reference for `reg_no` used in `lab_orders` and `radiology_orders` to track the context of orders, though not strictly enforced as a foreign key to accommodate potential data inconsistencies in the source.

This schema ensures data integrity through foreign key constraints where appropriate, while maintaining flexibility for fields like `reg_no`. The structure supports querying patient data, their registrations, laboratory orders and results, vital signs, and radiology orders in a relational manner.