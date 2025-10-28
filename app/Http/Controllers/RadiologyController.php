<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan ini di-import

class RadiologyController extends Controller
{
    /**
     * Menampilkan halaman (view) Radiology untuk reg_no tertentu.
     *
     * Route: /examOrder/radiologyAndImaging/{reg_no}
     * Name: 'radiology.imaging'
     */
    public function index($reg_no)
    {
        // Konversi format URL (REG+EM+...) kembali ke format DB (REG/EM/...)
        $reg_no_db = str_replace('+', '/', $reg_no);
        
        // Kirim reg_no ke view
        return view('examOrder.radiologyAndImaging', ['reg_no' => $reg_no_db]);
    }

    /**
     * Menyediakan data JSON order radiologi untuk patient_id yang terkait
     * dengan reg_no yang diberikan.
     *
     * Route: /radiology/data/{reg_no}
     * Name: 'radiology.data'
     */
    public function data($reg_no)
    {
        // Konversi format URL ke format DB
        $reg_no_db = str_replace('+', '/', $reg_no);

        // 1. Dapatkan patient_id dari tabel registrations
        $registration = DB::table('registrations')
            ->where('reg_no', $reg_no_db)
            ->first(); //

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi tidak ditemukan'
            ], 404);
        }

        // 2. Dapatkan semua order radiologi untuk patient_id tersebut
        $orders = DB::table('radiology_orders')
            ->where('patient_id', $registration->patient_id) //
            ->orderBy('rad_date', 'desc') //
            ->orderBy('rad_time', 'desc') //
            ->get()
            ->map(function ($order) {
                
                // Logika Parsing Array (dari skema, 'items' dan 'images' adalah TEXT[])
                $items = $order->items ?? [];
                if (is_string($items)) {
                    $items = str_replace(['{', '}'], '', $items);
                    $items = $items ? explode(',', $items) : [];
                }

                $images = $order->images ?? [];
                if (is_string($images)) {
                    $images = str_replace(['{', '}'], '', $images);
                    $images = $images ? explode(',', $images) : [];
                }
                // --- Akhir Logika Parsing ---

                return (object) [
                    'date' => date('d/m/Y', strtotime($order->rad_date)), //
                    'time' => date('H:i', strtotime($order->rad_time)), //
                    'reg_no' => $order->reg_no,
                    'tx_no' => $order->tx_no,
                    'from' => $order->from_unit,
                    'doctor' => $order->doctor,
                    'items' => $items,
                    'images' => $images,
                    'result_text' => $order->result_text ?? 'Tidak ada hasil teks yang tersedia.'
                ];
            });
        
        return response()->json(['success' => true, 'data' => $orders]);
    }

    /**
     * Mencari data radiologi berdasarkan query.
     * Fungsi ini tetap mencari secara global (tidak per pasien)
     * untuk meniru fungsionalitas JS Anda saat ini.
     *
     * Route: /radiology/search
     * Name: 'radiology.search'
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        $dbQuery = DB::table('radiology_orders'); //

        if (empty($query)) {
            $allRegNos = $dbQuery->pluck('reg_no')->unique()->all();
            return response()->json(['success' => true, 'data' => $allRegNos]);
        }

        // Gunakan ILIKE untuk PostgreSQL (case-insensitive)
        $matchingRegNos = $dbQuery
            ->where(function($db) use ($query) {
                $db->where('reg_no', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('tx_no', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('doctor', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('from_unit', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('items', 'ILIKE', '%' . $query . '%') //
                   ->orWhere('result_text', 'ILIKE', '%' . $query . '%'); //
            })
            ->pluck('reg_no')
            ->unique()
            ->all();

        return response()->json([
            'success' => true,
            'data' => $matchingRegNos
        ]);
    }
}