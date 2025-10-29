<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmrController extends Controller
{
    // Tampilkan halaman EMR (view hardcoded, data diambil via AJAX)
    public function show($regno)
    {
        return view('index', compact('regno'));
    }

    // Endpoint AJAX: ambil semua data EMR berdasarkan registration number
    public function findPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regno' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first()
            ], 400);
        }

        $regno = $request->regno;

        // Ambil data registrasi + pasien
        $registration = DB::table('registration as r')
            ->join('patient as p', 'r.patientid', '=', 'p.patientid')
            ->leftJoin('patientbilling as b', 'p.patientid', '=', 'b.patientid')
            ->select(
                'r.registrationid',
                'r.registrationnumber',
                'r.registrationdate',
                'r.patientclass as unit',
                'r.attendingdoctor as physician',
                'p.patientid',
                'p.mrn',
                'p.fullname as name',
                'p.dateofbirth as dob',
                'p.gender',
                'p.guarantor',
                'b.plafond',
                'b.totalbilling'
            )
            ->where('r.registrationnumber', $regno)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'error' => 'Registration not found.'
            ], 404);
        }

        // Ambil alergi
        $allergies = DB::table('allergy')
            ->where('patientid', $registration->patientid)
            ->pluck('allergyname')
            ->implode(', ');

        $allergiesDisplay = $allergies ?: '- None recorded';

        // Ambil diagnosis (pisahkan main & secondary)
        $diagnoses = DB::table('diagnosis')
            ->where('patientid', $registration->patientid)
            ->get();

        $mainDiagnosis = '';
        $secondaryDiagnosis = '';

        foreach ($diagnoses as $diag) {
            if (strtolower($diag->diagnosistype) === 'primary') {
                $mainDiagnosis = $diag->description;
            } elseif (strtolower($diag->diagnosistype) === 'secondary') {
                $secondaryDiagnosis = $diag->description;
            }
        }

        // Ambil vital signs
        $vitalSigns = DB::table('vitalsign')
            ->where('patientid', $registration->patientid)
            ->orderBy('measurementtime', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($v) {
                return [
                    'vital' => $v->measurementname,
                    'value' => $v->measurementvalue,
                    'time' => \Carbon\Carbon::parse($v->measurementtime)->format('H:i'),
                ];
            });

        // Siapkan response
        $data = [
            'name' => $registration->name,
            'mrn' => $registration->mrn,
            'reg_no' => $registration->registrationnumber,
            'reg_date' => $registration->registrationdate,
            'gender' => $registration->gender,
            'dob' => $registration->dob,
            'guarantor' => $registration->guarantor,
            'unit' => $registration->unit,
            'physician' => $registration->physician,
            'billing_plafond' => (float) ($registration->plafond ?? 0),
            'billing_total' => (float) ($registration->totalbilling ?? 0),
            'allergies' => $allergiesDisplay,
            'diagnosis_main' => $mainDiagnosis,
            'diagnosis_secondary' => $secondaryDiagnosis,
            'vital_signs' => $vitalSigns,
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
