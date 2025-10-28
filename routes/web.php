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