-- =============================================
-- Simplified PostgreSQL Schema
-- Based on pg_dump: ulemmirko_tanggal28
-- All tables, sequences, constraints, and relationships included
-- No data, no session settings, no comments
-- =============================================

-- Schema
CREATE SCHEMA IF NOT EXISTS public;
ALTER SCHEMA public OWNER TO pg_database_owner;

-- Table: patient
CREATE TABLE public.patient (
    patientid integer PRIMARY KEY,
    mrn varchar(20) UNIQUE NOT NULL,
    fullname varchar(100) NOT NULL,
    dateofbirth date,
    gender varchar(10),
    guarantor varchar(100),
    phonenumber varchar(20),
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.patients_patient_id_seq OWNED BY public.patient.patientid;
ALTER TABLE public.patient ALTER COLUMN patientid SET DEFAULT nextval('public.patients_patient_id_seq');
ALTER TABLE public.patient OWNER TO postgres;

-- Table: registration
CREATE TABLE public.registration (
    registrationid integer PRIMARY KEY,
    patientid integer NOT NULL REFERENCES public.patient(patientid) ON DELETE CASCADE,
    registrationnumber varchar(30) UNIQUE NOT NULL,
    registrationdate timestamp NOT NULL,
    patientclass varchar(50),
    attendingdoctor varchar(100),
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.registrations_registration_id_seq OWNED BY public.registration.registrationid;
ALTER TABLE public.registration ALTER COLUMN registrationid SET DEFAULT nextval('public.registrations_registration_id_seq');
ALTER TABLE public.registration OWNER TO postgres;

-- Table: patientbilling
CREATE TABLE public.patientbilling (
    billingid integer PRIMARY KEY,
    patientid integer UNIQUE NOT NULL REFERENCES public.patient(patientid),
    plafond numeric(15,2) DEFAULT 0,
    totalbilling numeric(15,2) DEFAULT 0,
    difference numeric(15,2) DEFAULT 0,
    lastupdated timestamp DEFAULT CURRENT_TIMESTAMP,
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.patient_billing_billing_id_seq OWNED BY public.patientbilling.billingid;
ALTER TABLE public.patientbilling ALTER COLUMN billingid SET DEFAULT nextval('public.patient_billing_billing_id_seq');
ALTER TABLE public.patientbilling OWNER TO postgres;

-- Table: allergy
CREATE TABLE public.allergy (
    allergyid integer PRIMARY KEY,
    patientid integer NOT NULL REFERENCES public.patient(patientid) ON DELETE CASCADE,
    allergyname varchar(255) NOT NULL,
    recordeddate date DEFAULT CURRENT_DATE,
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.allergies_allergy_id_seq OWNED BY public.allergy.allergyid;
ALTER TABLE public.allergy ALTER COLUMN allergyid SET DEFAULT nextval('public.allergies_allergy_id_seq');
ALTER TABLE public.allergy OWNER TO postgres;

-- Table: diagnosis
CREATE TABLE public.diagnosis (
    diagnosisid integer PRIMARY KEY,
    patientid integer NOT NULL REFERENCES public.patient(patientid),
    diagnosistype varchar(50),
    diagnosiscode varchar(20),
    description text NOT NULL,
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.diagnoses_diagnosis_id_seq OWNED BY public.diagnosis.diagnosisid;
ALTER TABLE public.diagnosis ALTER COLUMN diagnosisid SET DEFAULT nextval('public.diagnoses_diagnosis_id_seq');
ALTER TABLE public.diagnosis OWNER TO postgres;

-- Table: vitalsign
CREATE TABLE public.vitalsign (
    vitalid integer PRIMARY KEY,
    patientid integer NOT NULL REFERENCES public.patient(patientid),
    measurementname varchar(50) NOT NULL,
    measurementvalue varchar(50) NOT NULL,
    measurementtime timestamp NOT NULL,
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.vital_signs_vitals_id_seq OWNED BY public.vitalsign.vitalid;
ALTER TABLE public.vitalsign ALTER COLUMN vitalid SET DEFAULT nextval('public.vital_signs_vitals_id_seq');
ALTER TABLE public.vitalsign OWNER TO postgres;

-- Table: radiologyorder
CREATE TABLE public.radiologyorder (
    radiologyid integer PRIMARY KEY,
    patientid integer NOT NULL REFERENCES public.patient(patientid),
    orderdate timestamp NOT NULL,
    procedurename varchar(255) NOT NULL,
    requestingdoctor varchar(100),
    status varchar(50) DEFAULT 'Ordered',
    resultsummary text,
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL,
    joborderid integer NOT NULL
);
CREATE SEQUENCE public.radiology_orders_order_id_seq OWNED BY public.radiologyorder.radiologyid;
ALTER TABLE public.radiologyorder ALTER COLUMN radiologyid SET DEFAULT nextval('public.radiology_orders_order_id_seq');
CREATE INDEX fki_patientid ON public.radiologyorder (patientid);
ALTER TABLE public.radiologyorder OWNER TO postgres;

-- Table: laboratory
CREATE TABLE public.laboratory (
    laboratoryid integer PRIMARY KEY,
    patientid integer NOT NULL REFERENCES public.patient(patientid),
    orderdate timestamp NOT NULL,
    procedurename varchar(255) NOT NULL,
    requestingdoctor varchar(100),
    status varchar(50) DEFAULT 'Ordered',
    resultsummary text,
    examname varchar(50),
    unit varchar(50),
    resultcomment varchar(50),
    resultnote varchar(50),
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL,
    joboredrid integer NOT NULL
);
CREATE SEQUENCE public.labotaratory_order_id_seq OWNED BY public.laboratory.laboratoryid;
ALTER TABLE public.laboratory ALTER COLUMN laboratoryid SET DEFAULT nextval('public.labotaratory_order_id_seq');
ALTER TABLE public.laboratory OWNER TO postgres;

-- Table: joborder
CREATE TABLE public.joborder (
    joborderid integer PRIMARY KEY,
    laboratoryid integer NOT NULL REFERENCES public.laboratory(laboratoryid),
    radiologyid integer NOT NULL REFERENCES public.radiologyorder(radiologyid),
    ordertype varchar(100),
    requestingdoctor varchar(100),
    orderdate timestamp DEFAULT CURRENT_TIMESTAMP,
    status varchar(50),
    notes text,
    createdat timestamptz,
    updatedat timestamp[],
    creteduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.joborder_joborderid_seq OWNED BY public.joborder.joborderid;
ALTER TABLE public.joborder ALTER COLUMN joborderid SET DEFAULT nextval('public.joborder_joborderid_seq');
CREATE INDEX fki_laboratory_fk ON public.joborder (laboratoryid);
CREATE INDEX fki_radiology_fk ON public.joborder (radiologyid);
ALTER TABLE public.joborder OWNER TO postgres;

-- Table: joborderdetail
CREATE TABLE public.joborderdetail (
    joborderdetailid integer PRIMARY KEY,
    joborderid integer NOT NULL REFERENCES public.joborder(joborderid) ON DELETE CASCADE,
    servicecode varchar(50),
    servicename varchar(255) NOT NULL,
    quantity integer DEFAULT 1,
    price numeric(15,2) DEFAULT 0,
    resultvalue text,
    status varchar(50),
    createdat timestamptz[],
    updatedat timestamptz[],
    createduserid varchar(100)[] NOT NULL
);
CREATE SEQUENCE public.joborderdetail_joborderdetailid_seq OWNED BY public.joborderdetail.joborderdetailid;
ALTER TABLE public.joborderdetail ALTER COLUMN joborderdetailid SET DEFAULT nextval('public.joborderdetail_joborderdetailid_seq');
ALTER TABLE public.joborderdetail OWNER TO postgres;

-- Reset sequences to start at 1
SELECT setval('public.patients_patient_id_seq', 1, false);
SELECT setval('public.registrations_registration_id_seq', 1, false);
SELECT setval('public.patient_billing_billing_id_seq', 1, false);
SELECT setval('public.allergies_allergy_id_seq', 1, false);
SELECT setval('public.diagnoses_diagnosis_id_seq', 1, false);
SELECT setval('public.vital_signs_vitals_id_seq', 1, false);
SELECT setval('public.radiology_orders_order_id_seq', 1, false);
SELECT setval('public.labotaratory_order_id_seq', 1, false);
SELECT setval('public.joborder_joborderid_seq', 1, false);
SELECT setval('public.joborderdetail_joborderdetailid_seq', 1, false);