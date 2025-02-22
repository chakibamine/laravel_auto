<?php

use App\Http\Livewire\BootstrapTables;
use App\Http\Livewire\Components\Buttons;
use App\Http\Livewire\Components\Forms;
use App\Http\Livewire\Components\Modals;
use App\Http\Livewire\Components\Notifications;
use App\Http\Livewire\Components\Typography;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Err404;
use App\Http\Livewire\Err500;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Lock;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\ForgotPasswordExample;
use App\Http\Livewire\Index;
use App\Http\Livewire\LoginExample;
use App\Http\Livewire\ProfileExample;
use App\Http\Livewire\RegisterExample;
use App\Http\Livewire\Transactions;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ResetPasswordExample;
use App\Http\Livewire\UpgradeToPro;
use App\Http\Livewire\Users;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::get('/register', Register::class)->name('register');

Route::get('/login', Login::class)->name('login');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::get('/404', Err404::class)->name('404');
Route::get('/500', Err500::class)->name('500');
Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('upgrade-to-pro');

Route::middleware('auth')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/profile-example', ProfileExample::class)->name('profile-example');
    Route::get('/users', Users::class)->name('users');
    Route::get('/login-example', LoginExample::class)->name('login-example');
    Route::get('/register-example', RegisterExample::class)->name('register-example');
    Route::get('/forgot-password-example', ForgotPasswordExample::class)->name('forgot-password-example');
    Route::get('/reset-password-example', ResetPasswordExample::class)->name('reset-password-example');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/transactions', Transactions::class)->name('transactions');
    Route::get('/bootstrap-tables', BootstrapTables::class)->name('bootstrap-tables');
    Route::get('/lock', Lock::class)->name('lock');
    Route::get('/buttons', Buttons::class)->name('buttons');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/forms', Forms::class)->name('forms');
    Route::get('/modals', Modals::class)->name('modals');
    Route::get('/typography', Typography::class)->name('typography');
    Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('students.index');
    Route::get('/dossiers', function () {
        return view('dossiers.index');
    })->name('dossiers');
    
    // Add cloture route
    Route::get('/cloture', function () {
        return view('pages.cloture');
    })->name('cloture');
    
    // Course routes
    Route::get('/courses', function () {
        return view('pages.courses');
    })->name('courses.index');
    
    Route::get('/dossier/{id}/courses/print', function ($id) {
        $dossier = App\Models\Dossier::with(['student', 'courses'])->findOrFail($id);
        return view('pdf.courses', ['dossier' => $dossier]);
    })->name('dossier.courses.print');

    Route::get('/comptabilite/report/{year}/{month}', function ($year, $month) {
        $comptabilite = new App\Http\Livewire\Comptabilite();
        $comptabilite->currentYear = (int)$year;
        $comptabilite->currentMonth = (int)$month;
        $comptabilite->selectedMonth = sprintf('%d-%02d', $year, $month);
        
        return view('livewire.monthly-report', [
            'currentYear' => $year,
            'currentMonth' => $month,
            'reportData' => $comptabilite->getMonthlyReportData()
        ]);
    })->name('comptabilite.report');
});

// Student Management Routes
Route::middleware(['auth'])->group(function () {
    // Student routes
    Route::controller(StudentController::class)->group(function () {
        Route::get('/students', 'index')->name('students.index');
        Route::get('/students/create', 'create')->name('students.create');
        Route::post('/students', 'store')->name('students.store');
        Route::get('/students/{student}', 'show')->name('students.show');
        Route::get('/students/{student}/edit', 'edit')->name('students.edit');
        Route::put('/students/{student}', 'update')->name('students.update');
        Route::delete('/students/{student}', 'destroy')->name('students.destroy');
        Route::get('/students/{student}/profile', 'profile')->name('students.profile');
        Route::get('/students/{student}/export', 'export')->name('students.export');
        Route::post('/students/import', 'import')->name('students.import');
        Route::get('/students/{student}/photo', 'downloadPhoto')->name('students.photo.download');
        Route::delete('/students/{student}/photo', 'removePhoto')->name('students.photo.remove');
    });

    // Dossier routes
    Route::controller(DossierController::class)->group(function () {
        Route::get('/dossiers/{id}/contract', 'generateContractPdf')->name('dossier.contract.pdf');
        Route::get('/dossiers/{id}/invoice', 'generateInvoice')->name('dossier.invoice');
        Route::get('/dossiers/{id}/external-payment', 'generateExternalPayment')->name('dossier.external.payment');
        Route::get('/exam/{examId}/fiche', 'generateExamFiche')->name('exam.fiche');
    });
});

Route::get('/comptabilite', function () {
    return view('pages.comptabilite');
})->name('comptabilite');

