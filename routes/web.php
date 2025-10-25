<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmrController;
use App\Http\Controllers\LaboratoryController;

// EMR Routes - Use + for slashes in URL (REG+EM+251014-0008)
Route::get('/emr/{reg_no}', [EmrController::class, 'show'])
    ->name('emr.show')
    ->where('reg_no', '.*'); // Allow any character

// Laboratory Routes - Use + for slashes in URL
Route::get('/examOrder/laboratory/{reg_no}', [LaboratoryController::class, 'index'])
    ->name('laboratory')
    ->where('reg_no', '.*');

// Laboratory API Routes
Route::get('/laboratory/orders/{reg_no}', [LaboratoryController::class, 'orders'])
    ->name('laboratory.orders')
    ->where('reg_no', '.*');

Route::get('/laboratory/results/{lab_id}', [LaboratoryController::class, 'results'])
    ->name('laboratory.results');

Route::get('/laboratory/search', [LaboratoryController::class, 'search'])
    ->name('laboratory.search');

Route::get('/laboratory/testbydate/{lab_id}', [LaboratoryController::class, 'testByDate'])
    ->name('laboratory.testbydate');

// Radiology Routes (keeping existing functionality)
// Route untuk menampilkan halaman (view)
Route::get('examOrder/radiologyAndImaging', function () {
    return view('examOrder.radiologyAndImaging');
})->name('radiology.imaging');

// DATA SOURCE: Kumpulan semua data radiologi
function getRadiologyData() {
    return collect([
        (object) ['date' => '14/10/2025','time' => '07:52','reg_no' => 'REG/EM/251014-0008','tx_no' => 'JO251014-00054','from' => 'IGD','doctor' => 'dr. Daniel Sutanto','items' => ['THORAX DEWASA X-RAY 1.00 X','CT SCAN KEPALA 1.00 X <br> (Rp. 931,853.00)'],'images' => ['https://via.placeholder.com/80?text=THORAX','https://via.placeholder.com/80?text=CT'],'result_text' => 'Tidak ada hasil teks yang tersedia.'],
        (object) ['date' => '12/10/2025','time' => '11:30','reg_no' => 'REG/EM/251012-0003','tx_no' => 'JO251012-00021','from' => 'KLINIK ORTHOPEDI','doctor' => 'dr. Budi Santoso, Sp.OT','items' => ['MRI LUTUT KANAN 1.00 X'],'images' => ['https://via.placeholder.com/80?text=MRI'],'result_text' => 'Hasil: Ditemukan robekan minor pada ligamen.'],
        (object) ['date' => '10/10/2025','time' => '14:15','reg_no' => 'REG/OP/251010-0112','tx_no' => 'JO251010-00088','from' => 'KLINIK KEBIDANAN','doctor' => 'dr. Siti Aminah, Sp.OG','items' => ['USG ABDOMEN ATAS & BAWAH 1.00 X'],'images' => ['https://via.placeholder.com/80?text=USG-1','https://via.placeholder.com/80?text=USG-2'],'result_text' => 'Struktur organ dalam batas normal.'],
        (object) ['date' => '05/09/2025','time' => '09:00','reg_no' => 'REG/OP/250905-0045','tx_no' => 'JO250905-00015','from' => 'KLINIK ONKOLOGI','doctor' => 'dr. Endang W, Sp.Onk','items' => ['MAMMOGRAPHY 1.00 X'],'images' => ['https://via.placeholder.com/80?text=MAMMO'],'result_text' => 'Tidak ditemukan kalsifikasi atau massa yang mencurigakan.'],
        (object) ['date' => '18/08/2025','time' => '16:45','reg_no' => 'REG/OP/250818-0201','tx_no' => 'JO250818-00150','from' => 'KLINIK GIGI','doctor' => 'drg. Ahmad Fauzi','items' => ['X-RAY PANORAMIK GIGI 1.00 X'],'images' => ['https://via.placeholder.com/80?text=PANORAMIK'],'result_text' => 'Terdapat impaksi pada gigi molar ketiga bawah kanan.']
    ]);
}

// Route ini HANYA untuk menyediakan SEMUA data JSON
Route::get('/radiology/data', function () {
    return response()->json(['success' => true, 'data' => getRadiologyData()]);
})->name('radiology.data');

// [PERBAIKAN TOTAL] Route ini sekarang melakukan pencarian dinamis
Route::get('/radiology/search', function (Request $request) {
    $query = $request->input('q', '');
    $allData = getRadiologyData();
    
    if (empty($query)) {
        // Jika tidak ada query, kembalikan semua No. Registrasi
        return response()->json(['success' => true, 'data' => $allData->pluck('reg_no')->all()]);
    }

    $matchingRegNos = [];

    // Lakukan iterasi dan pencarian di setiap order
    foreach ($allData as $order) {
        // Gabungkan semua teks yang relevan menjadi satu string
        $searchableText = implode(' ', [
            $order->reg_no,
            $order->doctor,
            $order->from,
            // Gabungkan juga semua item order menjadi satu
            collect($order->items)->map(function ($item) {
                return strip_tags($item); // Hapus tag HTML seperti <br>
            })->implode(' ')
        ]);

        // Lakukan pencarian case-insensitive
        if (stripos($searchableText, $query) !== false) {
            $matchingRegNos[] = $order->reg_no;
        }
    }
    
    return response()->json([
        'success' => true,
        'data' => array_unique($matchingRegNos) // Kembalikan hanya No. Reg yang cocok
    ]);
})->name('radiology.search');




// AJAX Routes for Laboratory (Removed - now handled by LaboratoryController)

// Radiology Routes (keeping existing functionality)

Route::get('/laboratory/results', function () {
    $results = [
        ['group' => 'Gula Darah Sewaktu (Strip)', 'tests' => [
            ['id' => 1, 'name' => 'Gula Darah Sewaktu (Strip)', 'result_date' => '14/10/2025 09:17', 'flag' => 'H', 'result' => '190', 'unit' => '< 140 mg/dL', 'standard_value' => '', 'result_comment' => '', 'result_note' => '']
        ]],
        ['group' => 'Hematologi', 'tests' => [
            ['id' => 2, 'name' => 'Hemoglobin', 'result_date' => '14/10/2025 09:36', 'flag' => '', 'result' => '16.9', 'unit' => '13.2 - 17.3 g/dL', 'standard_value' => '', 'result_comment' => '', 'result_note' => ''],
            ['id' => 3, 'name' => 'Hematokrit', 'result_date' => '14/10/2025 09:36', 'flag' => '', 'result' => '46.0', 'unit' => '40 - 52 %', 'standard_value' => '', 'result_comment' => '', 'result_note' => ''],
            ['id' => 4, 'name' => 'Leukosit', 'result_date' => '14/10/2025 09:36', 'flag' => '', 'result' => '9.83', 'unit' => '4 - 10.5 10³/μL', 'standard_value' => '', 'result_comment' => '', 'result_note' => ''],
            ['id' => 5, 'name' => 'Trombosit', 'result_date' => '14/10/2025 09:36', 'flag' => '', 'result' => '360', 'unit' => '150 - 400 10³/μL', 'standard_value' => '', 'result_comment' => '', 'result_note' => ''],
            ['id' => 6, 'name' => 'Eritrosit', 'result_date' => '14/10/2025 09:36', 'flag' => 'H', 'result' => '5.74', 'unit' => '4.5 - 5.5 10⁶/μL', 'standard_value' => '', 'result_comment' => '', 'result_note' => ''],
            ['id' => 17, 'name' => 'Creatinin', 'result_date' => '14/10/2025 09:36', 'flag' => 'H', 'result' => '1.54', 'unit' => '0.67 - 1.17 mg/dL', 'standard_value' => '', 'result_comment' => 'duplo', 'result_note' => '']
        ]]
    ];
    return response()->json(['success' => true, 'data' => $results]);
});

Route::get('/laboratory/search', function () {
    $query = request('q', '');
    $allTestIds = range(1, 20);
    $matchingIds = [];
    if (empty($query)) {
        $matchingIds = $allTestIds;
    } else {
        $searchTerms = ['hemoglobin' => [2], 'gula' => [1, 18], 'darah' => [1, 18], 'hematokrit' => [3], 'leukosit' => [4], 'trombosit' => [5], 'eritrosit' => [6], 'creatinin' => [17], 'natrium' => [19], 'kalium' => [20], 'ureum' => [16]];
        foreach ($searchTerms as $term => $ids) {
            if (stripos($term, $query) !== false) {
                $matchingIds = array_merge($matchingIds, $ids);
            }
        }
        $matchingIds = array_unique($matchingIds);
    }
    return response()->json(['success' => true, 'data' => $matchingIds]);
});

Route::get('/laboratory/testbydate', function () {
    $orderId = request('id', '');
    $allResults = [
        1 => [['group' => 'Gula Darah Sewaktu (Strip)', 'tests' => [['id' => 1, 'name' => 'Gula Darah Sewaktu (Strip)', 'result_date' => '14/10/2025 09:17', 'flag' => 'H', 'result' => '190', 'unit' => '< 140 mg/dL', 'standard_value' => '', 'result_comment' => '', 'result_note' => '']]]],
        2 => [['group' => 'Hematologi', 'tests' => [['id' => 2, 'name' => 'Hemoglobin', 'result_date' => '14/10/2025 09:36', 'flag' => '', 'result' => '16.9', 'unit' => '13.2 - 17.3 g/dL', 'standard_value' => '', 'result_comment' => '', 'result_note' => '']]]],
        3 => []
    ];
    $results = $allResults[$orderId] ?? [];
    return response()->json(['success' => true, 'data' => $results, 'order_id' => $orderId]);
});