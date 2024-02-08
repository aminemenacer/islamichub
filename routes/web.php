<?php

use App\Http\Controllers\AhadithController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\HadithQudsiController;
use App\Http\Controllers\HadithShahController;
use App\Http\Controllers\MailingListController;
use App\Http\Controllers\CorrectionController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\SurahController;

// Auth routes
Auth::routes();

Route::get('/', function () {
    return view('home');
});
Route::get('/welcome', function () {
    return view('home');
});

// stripe payment
Route::post('payment/initiate', [CharityController::class, 'initiatePayment']);
Route::post('payment/complete', [CharityController::class, 'completePayment']);
Route::post('payment/failure', [CharityController::class, 'failPayment']);

// users
Route::get('/users', [UserController::class, 'index']);
Route::get('api/fetch-users', [UserController::class, 'getUsers']);
Route::post('api/create-users', [UserController::class, 'createUsers']);
Route::post('api/update-users/{id}',  [UserController::class, 'updateUsers']);
Route::delete('api/delete-users/{id}',  [UserController::class, 'deleteUsers']);
Route::get('/profile', [UserController::class, 'getProfile']);

//ahadith
Route::get('/get_imams', [AhadithController::class, 'getImams']);
Route::get('/get_chapters', [AhadithController::class, 'getChapters']);
Route::get('/ahadith/{id}/fetch', [AhadithController::class, 'getAhadith']);
Route::get('/get_ahadiths', [AhadithController::class, 'getAhadiths']);
Route::get('/ahadith', [AhadithController::class, 'index']);
// Route::get('/hadith/{id}/fetch', [AhadithController::class, 'getAhadiths']);

//quran
Route::get('/get_surahs', [SurahController::class, 'getSurahs']);
Route::get('/get_ayahs', [SurahController::class, 'getAyahs']);
Route::get('/get_informations', [SurahController::class, 'getInformations']);
Route::get('/tafseer/{id}/fetch', [SurahController::class, 'getTafseer']);

//search
Route::post('/search', [AhadithController::class, 'search'])->name('search');
Route::post('/search_chapter', [AhadithController::class, 'searchChapter'])->name('searchChapter');

// frontend json files
Route::get('/hadith_qudsi', [HadithQudsiController::class, 'index']);
Route::get('/hadith_shah', [HadithShahController::class, 'index']);

// mailing list
Route::get('/mailing_list', [MailingListController::class, 'index'])->name('mailing_list');
Route::get('api/fetch-mail', [MailingListController::class, 'getMail'])->name('mailing_list');
Route::post('api/subscribe', [MailingListController::class, 'create']);

// correction
Route::post('api/submit-correction', [CorrectionController::class, 'submit']);
Route::get('/correction', [CorrectionController::class, 'index']);
Route::get('api/fetch-corrections', [CorrectionController::class, 'getCorrections']);
Route::delete('api/delete-correction/{id}',  [CorrectionController::class, 'deleteCorrections']);

// contact
Route::get('/contact', [ContactController::class, 'index']);
// pricing
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
// charity
Route::get('/charity', [CharityController::class, 'index'])->name('charity');
// volunteer
Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer');

// dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('api/fetch-dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');

// feedback
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::get('api/fetch-feedbacks', [FeedbackController::class, 'getFeedbacks']);
Route::post('api/send-message', [FeedbackController::class, 'sendMessage']);

// payment
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('api/fetch-payments', [PaymentController::class, 'getPayments']);

// donations
Route::get('/donations', [DonationController::class, 'index']);
Route::get('api/fetch-donations', [DonationController::class, 'getDonations']);

// quran
Route::get('/quran', [QuranController::class, 'index']);


