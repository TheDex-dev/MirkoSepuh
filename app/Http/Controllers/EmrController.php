<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmrController extends Controller
{
    /**
     * Display EMR data for a specific registration number
     * Route: /emr/{reg_no}
     * Example: /emr/REG+EM+251014-0008
     */
    public function show($reg_no)
    {
        // Convert URL format back to database format
        // REG+EM+251014-0008 -> REG/EM/251014-0008
        $reg_no = str_replace('+', '/', $reg_no);
        
        // Get registration data with patient info
        $registration = DB::table('registrations')
            ->join('patients', 'registrations.patient_id', '=', 'patients.patient_id')
            ->where('registrations.reg_no', $reg_no)
            ->select(
                'patients.*',
                'registrations.reg_no',
                'registrations.reg_date',
                'registrations.unit',
                'registrations.physician'
            )
            ->first();
        
        if (!$registration) {
            abort(404, 'Registration not found');
        }
        
        // Calculate age
        $age = $this->calculateAge($registration->dob);
        
        // Get vital signs for this patient
        $vitalSigns = DB::table('vital_signs')
            ->where('patient_id', $registration->patient_id)
            ->orderBy('vs_date', 'desc')
            ->orderBy('vs_time', 'desc')
            ->get();
        
        // Group vital signs by detecting the type from value/unit
        $latestVitals = [];
        $processedTypes = [];
        
        foreach ($vitalSigns as $vs) {
            $type = $this->detectVitalSignType($vs->value, $vs->unit);
            
            // Only take the first (latest) occurrence of each type
            if ($type && !in_array($type, $processedTypes)) {
                $processedTypes[] = $type;
                $latestVitals[] = (object) [
                    'name' => $type,
                    'value' => $vs->value,
                    'unit' => $vs->unit,
                    'date' => $vs->vs_date,
                    'time' => $vs->vs_time
                ];
            }
        }
        
        // Get billing information from lab and radiology orders
        $labTotal = DB::table('lab_orders')
            ->where('patient_id', $registration->patient_id)
            ->where('reg_no', $reg_no)
            ->get()
            ->sum(function($order) {
                // Extract numeric value from price string (e.g., "Rp. 29,625.00")
                $price = preg_replace('/[^0-9.]/', '', $order->price ?? '0');
                return (float) $price;
            });
        
        $radTotal = DB::table('radiology_orders')
            ->where('patient_id', $registration->patient_id)
            ->where('reg_no', $reg_no)
            ->count() * 150000; // Assuming average cost per radiology order
        
        $totalBilling = $labTotal + $radTotal;
        $plafond = 10000.00; // This should come from patient insurance data
        $selisih = $plafond - $totalBilling;
        
        return view('index', [
            'patient' => $registration,
            'age' => $age,
             'vitalSigns' => $latestVitals,
            'billing' => [
                'plafond' => $plafond,
                'total' => $totalBilling,
                'selisih' => $selisih
            ]
        ]);
    }
    
    /**
     * Calculate age from date of birth
     */
    private function calculateAge($dob)
    {
        if (!$dob) {
            return 'N/A';
        }
        
        $birthDate = new \DateTime($dob);
        $today = new \DateTime();
        $interval = $today->diff($birthDate);
        
        return sprintf('%dy %dm %dd', $interval->y, $interval->m, $interval->d);
    }
    
    /**
     * Detect vital sign type from value and unit
     */
    private function detectVitalSignType($value, $unit)
    {
        $combined = strtolower($value . ' ' . $unit);
        
        // Pattern matching for different vital sign types
        if (strpos($combined, 'spo2') !== false || strpos($combined, '%') !== false) {
            return 'SpO2';
        }
        if (strpos($combined, 'weight') !== false || strpos($combined, 'kg') !== false || strpos($combined, 'berat') !== false) {
            return 'Weight';
        }
        if (strpos($combined, 'height') !== false || strpos($combined, 'cm') !== false || strpos($combined, 'tinggi') !== false) {
            return 'Height';
        }
        if (strpos($combined, 'gcs') !== false) {
            return 'GCS Total';
        }
        if (strpos($combined, 'sistol') !== false || strpos($combined, 'systol') !== false) {
            return 'BP Sistolic';
        }
        if (strpos($combined, 'diastol') !== false) {
            return 'BP Diastolic';
        }
        if (strpos($combined, 'heart') !== false || strpos($combined, 'nadi') !== false || strpos($combined, 'pulse') !== false) {
            return 'Heart Rate';
        }
        if (strpos($combined, 'resp') !== false || strpos($combined, 'nafas') !== false || strpos($combined, 'pernapasan') !== false) {
            return 'Resp. Rate';
        }
        if (strpos($combined, 'temp') !== false || strpos($combined, 'suhu') !== false) {
            return 'Temperature';
        }
        if (strpos($combined, 'mmhg') !== false) {
            // Generic blood pressure reading
            return 'Blood Pressure';
        }
        if (strpos($combined, 'x/mnt') !== false || strpos($combined, 'x/min') !== false) {
            // Generic rate reading
            return 'Rate';
        }
        
        return null; // Unknown type
    }
}
