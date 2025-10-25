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
        
        // Get patient_id from registration
        $registration = DB::table('registrations')
            ->where('reg_no', $reg_no)
            ->first();
        
        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found'
            ], 404);
        }
        
        // Get all lab orders for this patient
        $orders = DB::table('lab_orders')
            ->where('patient_id', $registration->patient_id)
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function ($order) {
                // Parse items array if stored as PostgreSQL array or JSON
                $items = $order->items;
                if (is_string($items)) {
                    // Handle PostgreSQL array format {item1,item2}
                    $items = str_replace(['{', '}'], '', $items);
                    $items = explode(',', $items);
                }
                
                return [
                    'id' => $order->lab_id,
                    'date' => date('d/m/Y H:i', strtotime($order->order_date)),
                    'req_no' => $order->reg_no,
                    'tx_no' => $order->tx_no,
                    'from' => $order->from_unit,
                    'doctor' => $order->doctor,
                    'urgent' => $order->urgent,
                    'items' => $items,
                    'price' => $order->price
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
        // Get lab results grouped by group_name
        $results = DB::table('lab_results')
            ->where('lab_id', $lab_id)
            ->orderBy('group_name')
            ->orderBy('test_name')
            ->get();
        
        if ($results->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
        
        // Group results by group_name
        $groupedResults = [];
        foreach ($results as $result) {
            $groupName = $result->group_name ?: 'General';
            
            if (!isset($groupedResults[$groupName])) {
                $groupedResults[$groupName] = [
                    'group' => $groupName,
                    'tests' => []
                ];
            }
            
            $groupedResults[$groupName]['tests'][] = [
                'id' => $result->result_id,
                'name' => $result->test_name,
                'result_date' => date('d/m/Y H:i', strtotime($result->result_date)),
                'flag' => $result->flag,
                'result' => $result->result_value,
                'unit' => $result->unit,
                'standard_value' => $result->standard_value,
                'result_comment' => $result->result_comment,
                'result_note' => $result->result_note
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => array_values($groupedResults)
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
            // Return all available result IDs
            $resultIds = DB::table('lab_results')
                ->pluck('result_id')
                ->toArray();
            
            return response()->json([
                'success' => true,
                'data' => $resultIds
            ]);
        }
        
        // Search in test names
        $resultIds = DB::table('lab_results')
            ->where('test_name', 'ILIKE', '%' . $query . '%')
            ->orWhere('group_name', 'ILIKE', '%' . $query . '%')
            ->pluck('result_id')
            ->toArray();
        
        return response()->json([
            'success' => true,
            'data' => $resultIds
        ]);
    }
    
    /**
     * Get laboratory results by order ID (for testbydate functionality)
     * Route: /laboratory/testbydate/{lab_id}
     */
    public function testByDate($lab_id)
    {
        $results = DB::table('lab_results')
            ->where('lab_id', $lab_id)
            ->orderBy('group_name')
            ->orderBy('test_name')
            ->get();
        
        // Group results by group_name
        $groupedResults = [];
        foreach ($results as $result) {
            $groupName = $result->group_name ?: 'General';
            
            if (!isset($groupedResults[$groupName])) {
                $groupedResults[$groupName] = [
                    'group' => $groupName,
                    'tests' => []
                ];
            }
            
            $groupedResults[$groupName]['tests'][] = [
                'id' => $result->result_id,
                'name' => $result->test_name,
                'result_date' => date('d/m/Y H:i', strtotime($result->result_date)),
                'flag' => $result->flag,
                'result' => $result->result_value,
                'unit' => $result->unit,
                'standard_value' => $result->standard_value,
                'result_comment' => $result->result_comment,
                'result_note' => $result->result_note
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => array_values($groupedResults),
            'order_id' => $lab_id
        ]);
    }
}
