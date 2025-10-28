<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RadiologyController extends Controller
{
    /**
     * Menampilkan halaman (view) Radiology untuk reg_no tertentu.
     * Route: /examOrder/radiologyAndImaging/{reg_no}
     */
    public function index($reg_no)
    {
        $reg_no_db = str_replace('+', '/', $reg_no);
        return view('examOrder.radiologyAndImaging', ['reg_no' => $reg_no_db]);
    }

    /**
     * Menyediakan data JSON order radiologi untuk patient_id yang terkait
     * dengan reg_no yang diberikan.
     * Route: /radiology/data/{reg_no}
     */
    public function data($reg_no)
    {
        $reg_no_db = str_replace('+', '/', $reg_no);

        // 1. Dapatkan patientid dari reg_no
        $registration = DB::table('registration')
            ->where('registrationnumber', $reg_no_db) //
            ->first();

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Registrasi tidak ditemukan'], 404);
        }

        // 2. Dapatkan semua registrationid untuk patientid ini
        $allRegistrationIds = DB::table('registration')
            ->where('patientid', $registration->patientid) //
            ->pluck('registrationid'); //

        // 3. Dapatkan semua order radiologi untuk patientid ini
        $orders = DB::table('radiologyorder') //
            ->join('registration', 'radiologyorder.registrationid', '=', 'registration.registrationid')
            ->whereIn('radiologyorder.registrationid', $allRegistrationIds) //
            ->select('radiologyorder.*', 'registration.registrationnumber')
            ->orderBy('radiologyorder.orderdate', 'desc') //
            ->get()
            ->map(function ($order) {
                return (object) [
                    'date' => date('d/m/Y', strtotime($order->orderdate)), //
                    'time' => date('H:i', strtotime($order->orderdate)), //
                    'reg_no' => $order->registrationnumber, // Dari join
                    'tx_no' => $order->orderid, // Tidak ada tx_no, gunakan orderid
                    'from' => '', // Tidak ada 'from_unit'
                    'doctor' => $order->requestingdoctor, //
                    'items' => [$order->procedurename], // 'items' adalah 'procedurename'
                    'images' => [], // <-- PENTING: Skema baru tidak punya kolom 'images'
                    'result_text' => $order->resultsummary ?? 'Tidak ada hasil teks yang tersedia.' //
                ];
            });
        
        return response()->json(['success' => true, 'data' => $orders]);
    }

    /**
     * Mencari data radiologi berdasarkan query.
     * Route: /radiology/search
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        $dbQuery = DB::table('radiologyorder'); //

        if (empty($query)) {
            // Jika query kosong, kembalikan semua No. Registrasi
            // (Kita harus join untuk mendapatkan 'registrationnumber')
            $allRegNos = DB::table('radiologyorder')
                ->join('registration', 'radiologyorder.registrationid', '=', 'registration.registrationid')
                ->pluck('registration.registrationnumber')
                ->unique()
                ->all();
            return response()->json(['success' => true, 'data' => $allRegNos]);
        }

        // Lakukan pencarian
        $matchingRegNos = $dbQuery
            ->join('registration', 'radiologyorder.registrationid', '=', 'registration.registrationid')
            ->where(function($db) use ($query) {
                $db->where('registration.registrationnumber', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('radiologyorder.orderid', 'ILIKE', '%' . $query . '%')
                   ->orWhere('radiologyorder.requestingdoctor', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('radiologyorder.procedurename', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('radiologyorder.resultsummary', 'ILIKE', '%' . $query . '%'); //
            })
            ->pluck('registration.registrationnumber')
            ->unique()
            ->all();

        return response()->json([
            'success' => true,
            'data' => $matchingRegNos
        ]);
    }
}