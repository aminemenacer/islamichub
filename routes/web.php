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
use App\Http\Controllers\MailingListController;
use App\Http\Controllers\CorrectionController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\JoinUsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UpdatesController;
use App\Http\Controllers\AdminController;


// Auth routes
Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Other admin routes...
});

Route::get('api/userId', [UserController::class, 'getUserId']);

Route::middleware(['auth'])->group(function () {
    //bookmark
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::get('api/fetch-bookmarks', [BookmarkController::class, 'getBookmarks']);
    Route::delete('api/delete-bookmarks/{id}',  [BookmarkController::class, 'deleteBookmarks']);

    Route::get('api/fetch-bookmarks/{userId}', [BookmarkController::class, 'getBookmarks']);

    // notes
    Route::get('/notes', [NotesController::class, 'index']);
    // Route::get('api/fetch-notes', [NotesController::class, 'getNotes']);
    Route::post('api/submit-note', [NotesController::class, 'store']);
    Route::post('api/update-notes/{id}',  [NotesController::class, 'updateNotes']);
    Route::delete('api/delete-notes/{id}',  [NotesController::class, 'deleteNotes']);

    Route::get('api/fetch-notes/{userId}', [NotesController::class, 'getNotes']);

});


Route::get('/ayahs', [QuranController::class, 'index']);

//join us
Route::get('/join_us', [JoinUsController::class, 'index']);



// Example: Restrict access to a route to authenticated users
Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware('auth');

Route::get('/', function () {
    return view('quran');
});
Route::get('/welcome', function () {
    return view('home');
});

Route::get('/audio-files/{id}', [ContactController::class, 'fetchAudioFile']);

//updates
Route::get('/updates', [UpdatesController::class, 'index']);

//facebook sign-in
Route::get('/auth/facebook', [LoginController::class, 'redirectToFacebook'])->name('fb-auth');
Route::get('/auth/facebook/callback', [LoginController::class, 'loginWithFacebook']);

// google sign-in
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

// linked sign-in
Route::get('auth/linkedin', [LoginController::class, 'redirectToLinkedin'])->name('linkedin-auth');
Route::get('auth/linkedin/callback', [LoginController::class, 'handleLinkedinCallback']);



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
Route::post('/search', [AhadithController::class, 'search'])->name('search');
// Route::get('/hadith/{id}/fetch', [AhadithController::class, 'getAhadiths']);

//quran
Route::get('/get_surat', [SurahController::class, 'getSurat']);
Route::get('/get_ayat', [SurahController::class, 'getAyat']);
Route::get('/get_informations', [SurahController::class, 'getInformations']);
Route::get('/tafseer/{id}/fetch', [SurahController::class, 'getTafseers']);
Route::post('/search', [SurahController::class, 'search'])->name('search');




// mailing list
Route::get('/mailing_list', [MailingListController::class, 'index'])->name('mailing_list');
Route::get('api/fetch-mail', [MailingListController::class, 'getMail'])->name('mailing_list');
Route::post('api/subscribe', [MailingListController::class, 'create']);
Route::post('api/submit-mail', [MailingListController::class, 'submitMail']);

// correction
Route::post('api/submit-correction', [CorrectionController::class, 'submit']);
Route::get('/correction', [CorrectionController::class, 'index']);
Route::get('api/fetch-corrections', [CorrectionController::class, 'getCorrections']);
Route::delete('api/delete-correction/{id}',  [CorrectionController::class, 'deleteCorrections']);

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
// contact
Route::get('/contact', [ContactController::class, 'index']);
// pricing
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
// charity
Route::get('/charity', [CharityController::class, 'index'])->name('charity');
// volunteer
Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer');
// about
Route::get('/about', [AboutController::class, 'index'])->name('about');