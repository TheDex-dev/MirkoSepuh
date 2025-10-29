<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryController extends Controller
{
    /**
     * Display laboratory page for a specific registration number
     * Route: /examOrder/laboratory/{reg_no}
     * Example: /examOrder/laboratory/REG+EM+251014-0008
     */
    public function index($reg_no)
    {
        // Convert URL format back to database format
        // REG+EM+251014-0008 -> REG/EM/251014-0008
        $reg_no = str_replace('+', '/', $reg_no);
        
        return view('examOrder.laboratory', ['reg_no' => $reg_no]);
    }
    
    /**
     * Get all laboratory orders for a specific registration number
     * Route: /laboratory/orders/{reg_no}
     */
    public function orders($reg_no)
    {
        // Convert URL format back to database format
        $reg_no = str_replace('+', '/', $reg_no);
        
        // Get registration by registration number
        $registration = DB::table('registration')
            ->where('registrationnumber', $reg_no)
            ->first();
        
        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found'
            ], 404);
        }
        
        // Get all lab orders for this patient (not just this registration)
        $orders = DB::table('laboratory')
            ->where('patientid', $registration->patientid)
            ->orderBy('orderdate', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->laboratoryid,
                    'date' => date('d/m/Y H:i', strtotime($order->orderdate)),
                    'procedure' => $order->procedurename,
                    'doctor' => $order->requestingdoctor,
                    'status' => $order->status,
                    'exam' => $order->examname,
                    'unit' => $order->unit,
                    'result' => $order->resultsummary,
                    'comment' => $order->resultcomment,
                    'note' => $order->resultnote
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
    
    /**
     * Get laboratory results for a specific lab order
     * Route: /laboratory/results/{lab_id}
     */
    public function results($lab_id)
    {
        // Get lab order with all details
        $order = DB::table('laboratory')
            ->where('laboratoryid', $lab_id)
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Laboratory order not found'
            ], 404);
        }
        
        // Return the laboratory order details
        $result = [
            'id' => $order->laboratoryid,
            'procedure' => $order->procedurename,
            'exam' => $order->examname,
            'date' => date('d/m/Y H:i', strtotime($order->orderdate)),
            'doctor' => $order->requestingdoctor,
            'status' => $order->status,
            'result' => $order->resultsummary,
            'unit' => $order->unit,
            'comment' => $order->resultcomment,
            'note' => $order->resultnote
        ];
        
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
    
    /**
     * Search laboratory tests
     * Route: /laboratory/search
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            // Return all available order IDs
            $orderIds = DB::table('laboratory')
                ->pluck('laboratoryid')
                ->toArray();
            
            return response()->json([
                'success' => true,
                'data' => $orderIds
            ]);
        }
        
        // Search in procedure names and exam names
        $orderIds = DB::table('laboratory')
            ->where('procedurename', 'ILIKE', '%' . $query . '%')
            ->orWhere('examname', 'ILIKE', '%' . $query . '%')
            ->pluck('laboratoryid')
            ->toArray();
        
        return response()->json([
            'success' => true,
            'data' => $orderIds
        ]);
    }
    
    /**
     * Get laboratory results by order ID (for testbydate functionality)
     * Route: /laboratory/testbydate/{lab_id}
     */
    public function testByDate($lab_id)
    {
        // Get lab order with all details
        $order = DB::table('laboratory')
            ->where('laboratoryid', $lab_id)
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Laboratory order not found'
            ], 404);
        }
        
        // Return the laboratory order details
        $result = [
            'id' => $order->laboratoryid,
            'procedure' => $order->procedurename,
            'exam' => $order->examname,
            'date' => date('d/m/Y H:i', strtotime($order->orderdate)),
            'doctor' => $order->requestingdoctor,
            'status' => $order->status,
            'result' => $order->resultsummary,
            'unit' => $order->unit,
            'comment' => $order->resultcomment,
            'note' => $order->resultnote
        ];
        
        return response()->json([
            'success' => true,
            'data' => $result,
            'order_id' => $lab_id
        ]);
    }
}
