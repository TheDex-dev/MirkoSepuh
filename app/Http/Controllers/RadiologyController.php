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
            ->where('registrationnumber', $reg_no_db)
            ->first();

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Registrasi tidak ditemukan'], 404);
        }

        // 2. Dapatkan semua order radiologi untuk patientid ini (tidak perlu join registration lagi)
        $orders = DB::table('radiologyorder')
            ->where('patientid', $registration->patientid)
            ->orderBy('orderdate', 'desc')
            ->get()
            ->map(function ($order) use ($reg_no_db) {
                return (object) [
                    'date' => date('d/m/Y', strtotime($order->orderdate)),
                    'time' => date('H:i', strtotime($order->orderdate)),
                    'reg_no' => $reg_no_db, // Use the current registration number
                    'tx_no' => $order->radiologyid, // Use radiologyid instead of orderid
                    'from' => '', // Tidak ada 'from_unit'
                    'doctor' => $order->requestingdoctor,
                    'items' => [$order->procedurename], // 'items' adalah 'procedurename'
                    'images' => [], // <-- PENTING: Skema baru tidak punya kolom 'images'
                    'result_text' => $order->resultsummary ?? 'Tidak ada hasil teks yang tersedia.'
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
        
        $dbQuery = DB::table('radiologyorder');

        if (empty($query)) {
            // Jika query kosong, kembalikan semua radiologyid
            $allRadiologyIds = DB::table('radiologyorder')
                ->pluck('radiologyid')
                ->unique()
                ->all();
            return response()->json(['success' => true, 'data' => $allRadiologyIds]);
        }

        // Lakukan pencarian
        $matchingRadiologyIds = $dbQuery
            ->where(function($db) use ($query) {
                $db->where('radiologyid', 'ILIKE', '%' . $query . '%')
                   ->orWhere('requestingdoctor', 'ILIKE', '%' . $query . '%')
                   ->orWhere('procedurename', 'ILIKE', '%' . $query . '%')
                   ->orWhere('resultsummary', 'ILIKE', '%' . $query . '%');
            })
            ->pluck('radiologyid')
            ->unique()
            ->all();

        return response()->json([
            'success' => true,
            'data' => $matchingRadiologyIds
        ]);
    }
}