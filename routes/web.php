<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PrestationManagerController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->roles()->doesntExist() && $user->patient()->exists()) {
            Role::findOrCreate('patient', 'web');
            $user->assignRole('patient');
            $user->load('roles');
        }

        if ($user->hasRole('patient')) {
            return redirect()->route('patient.dashboard');
        } elseif ($user->hasRole('secretaire') || $user->hasRole('medecin') || $user->hasRole('responsable_prestation')) {
            return redirect()->route('statistics.index');
        }
        return view('dashboard');
    })->name('dashboard');

    // Patient Routes
    Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/rv/create', [PatientController::class, 'createAppointment'])->name('rv.create');
        Route::post('/rv/store', [PatientController::class, 'storeAppointment'])->name('rv.store');
        Route::post('/rv/cancel/{id}', [PatientController::class, 'cancelAppointment'])->name('rv.cancel');
        
        // Impression
        Route::get('/consultation/{id}/print', [PatientController::class, 'printConsultation'])->name('consultation.print');
        Route::get('/prestation/{id}/print', [PatientController::class, 'printPrestation'])->name('prestation.print');
    });

    // Secretary Routes
    Route::middleware(['role:secretaire'])->prefix('secretaire')->name('secretaire.')->group(function () {
        Route::get('/dashboard', [SecretaryController::class, 'dashboard'])->name('dashboard');
        Route::post('/rv/validate/{id}', [SecretaryController::class, 'validateRV'])->name('rv.validate');
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
        Route::post('/rv/{id}/cancel', [SecretaryController::class, 'cancelRV'])->name('rv.cancel');
        Route::post('/rv/{id}/complete', [SecretaryController::class, 'completeRV'])->name('rv.complete');
    });

    // Doctor Routes
    Route::middleware(['role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
        $doctorRoutes = function () {
            Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
            Route::get('/consultation/{id}', [DoctorController::class, 'showConsultation'])->name('consultation.show');
            Route::post('/consultation/{id}/complete', [DoctorController::class, 'completeConsultation'])->name('consultation.complete');
            Route::post('/consultation/{id}/cancel', [DoctorController::class, 'cancelConsultation'])->name('consultation.cancel');
            Route::get('/patient/search', [DoctorController::class, 'searchPatient'])->name('patient.search');
            Route::get('/patient/{id}/history', [DoctorController::class, 'patientHistory'])->name('patient.history');
        };
        Route::group([], $doctorRoutes);
    });


    // Prestation Manager Routes
    Route::middleware(['role:responsable_prestation'])->prefix('responsable')->name('responsable.')->group(function () {
        Route::get('/dashboard', [PrestationManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/prestation/{id}', [PrestationManagerController::class, 'show'])->name('prestation.show');
        Route::post('/prestation/{id}/update', [PrestationManagerController::class, 'updateResultats'])->name('prestation.update');
        Route::post('/prestation/{id}/cancel', [PrestationManagerController::class, 'cancelPrestation'])->name('prestation.cancel');
    });


    // Statistics Route (Shared or Admin/Secretary)
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index')->middleware('role:secretaire|medecin|responsable_prestation');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
