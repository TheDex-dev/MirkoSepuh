<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmrController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\RadiologyController;

// EMR Routes - Use + for slashes in URL (REG+EM+251014-0008)
Route::get('/emr/{reg_no}', [EmrController::class, 'show'])
    ->name('emr.show')
    ->where('reg_no', '.*'); // Allow any character

// EMR API Route - Get patient data by registration number
Route::post('/emr/findPatient', [EmrController::class, 'findPatient'])
    ->name('emr.findPatient');

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

// Route untuk menampilkan halaman (view)
Route::get('examOrder/radiologyAndImaging/{reg_no}', [RadiologyController::class, 'index'])
    ->name('radiology.imaging')
    ->where('reg_no', '.*'); // Izinkan karakter '+' dan '/'

// Route ini HANYA untuk menyediakan data JSON berdasarkan reg_no
Route::get('/radiology/data/{reg_no}', [RadiologyController::class, 'data'])
    ->name('radiology.data')
    ->where('reg_no', '.*'); // Izinkan karakter '+' dan '/'

// Route pencarian tetap global (tidak perlu reg_no)
Route::get('/radiology/search', [RadiologyController::class, 'search'])
    ->name('radiology.search');