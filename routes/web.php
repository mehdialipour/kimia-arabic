<?php

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

/* Login Routes */
Route::get('sms', 'HomeController@sms');

Route::get('login', 'UserController@login')->name('login');
Route::post('verify', 'UserController@verify')->name('verify');
Route::get('logout', 'UserController@logout');
Route::get('users/search','UserController@search');

Route::post('deploy', 'DeployController@deploy');
Route::get('change', 'HomeController@changeNames');
Route::post('status', 'TurnController@updateStatus');
Route::get('iran','TurnController@iran');
/* End Login Routes */


Route::middleware('session')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('insurances', 'InsuranceController');

    Route::resource('services', 'ServiceController');

    Route::any('patients/{id}/questions','PatientController@questions');
    Route::resource('questions','QuestionController');

    Route::post('search', 'PatientController@search');
    Route::post('search-turn', 'PatientController@searchTurn');
    
    Route::get('patients/search-patients','PatientController@searchPatients');
    Route::get('patients/search', 'PatientController@patientSearch');
    Route::any('patients/{id}/scan-files', 'PatientController@scanFiles');
    Route::any('patients/{id}/before-after-files', 'PatientController@beforeAfter');
    Route::get('before-after-files/delete/{id}','PatientController@deleteBeforeAfter');
    Route::resource('patients', 'PatientController');

    Route::get('patients/delete-image/{id}', 'PatientController@deleteImage');
    Route::post('patients/change-insurance', 'PatientController@changeInsurance');
    Route::post('patients/national-id-check', 'PatientController@nationalIdCheck');
    Route::post('patients/mobile-check', 'PatientController@mobileCheck');
    Route::any('patients/{id}/questions', 'PatientController@questions');
    Route::any('patients/{id}/answers', 'PatientController@answers');

    Route::get('patients/{id}/to-wait', 'PatientController@toWait');
    Route::get('patients/{id}/to-office', 'PatientController@toOffice');
    Route::get('patients/{id}/to-therapist', 'PatientController@toTherapist');


    Route::get('patient-files', 'ReceptionController@files');
    Route::get('patient-files/{id}/delete', 'ReceptionController@deleteFile');
    Route::get('receptions/stats','ReceptionController@stats');
    Route::resource('receptions', 'ReceptionController');
    Route::get('receptions/{id}/perception', 'ReceptionController@perception');
    Route::get('receptions/{id}/diagnosis', 'ReceptionController@diagnosis');
    Route::get('receptions/{id}/release', 'ReceptionController@release');
    Route::post('receptions/collect', 'ReceptionController@collect');

    Route::post('receptions/load', 'ReceptionController@loadReceptions');
    Route::post('receptions/upload', 'ReceptionController@doUpload');
    Route::post('receptions/submit-diagnosis', 'ReceptionController@submitDiagnosis');
    Route::get('receptions/diagnosis/delete/{id}', 'ReceptionController@deleteDiagnosis');
    Route::get('receptions/diagnosis/edit/{diagnosis_id}', 'ReceptionController@editDiagnosis');
    Route::post('receptions/diagnosis/update/{diagnosis_id}', 'ReceptionController@updateDiagnosis');

    Route::get('receptions/medicines/edit/{medicine_id}', 'ReceptionController@editMedicine');
    Route::post('receptions/medicines/update/{medicine_id}', 'ReceptionController@updateMedicine');
    Route::get('receptions/medicines/delete/{medicine_id}', 'ReceptionController@deleteMedicine');

    Route::get('previous-turns', 'TurnController@previousTurns');
    Route::post('turns/user-services', 'TurnController@userServices');
    Route::get('turns/{turn_id}/invoice-details', 'TurnController@invoiceDetails');
    Route::get('turns/release/{id}', 'TurnController@release');
    Route::get('turns/create-clinic', 'TurnController@createClinic');
    Route::post('turns/store-clinic', 'TurnController@storeClinic');
    Route::get('turns/toggle/{turn_id}', 'TurnController@toggle');
    Route::get('turns/{id}/money', 'TurnController@receiveMoney');
    Route::post('turns/discount/{id}', 'TurnController@discount');
    Route::post('turns/updateTurn', 'TurnController@updateTurn');
    Route::post('turns/load-waiters', 'TurnController@loadWaiters');
    Route::post('turns/load-office', 'TurnController@loadOffice');
    Route::post('turns/load-release', 'TurnController@loadRelease');
    Route::post('turns/load-therapist', 'TurnController@loadTherapist');
    Route::get('turns/future', 'TurnController@future_turns');
    Route::get('turns/canceled_turns', 'TurnController@canceledTurns');

    Route::get('turns/show-future/{date}','TurnController@showFuture');
    Route::post('turns/future-status', 'TurnController@futureStatus');

    Route::get('turns/{id}/turn-future', 'TurnController@turnFuture');

    Route::get('turns/delete/{id}', 'TurnController@destroy');
    Route::post('turns/count-turns', 'TurnController@countTurns');
    Route::any('turns/therapist/{id}', 'TurnController@therapist');
    Route::post('turns/calculate-services', 'TurnController@calculateServices');

    Route::get('turns/clinic/{service_turn_id}','TurnController@clinic');
    Route::get('nurse-description/edit/{id}','TurnController@editNurseDescription');
    Route::post('turns/submit-description','TurnController@submitDescription');

    Route::get('turns/clinic-edit/{id}','TurnController@editClinic');
    Route::post('turns/update-description','TurnController@updateDescription');

    Route::post('turns/add-suggestion','TurnController@addSuggestion');
    Route::post('turns/delete-suggestion','TurnController@deleteSuggestion');
    Route::post('turns/service-discount','TurnController@serviceDiscount');
    Route::get('turns/suggestion/{service_turn_id}','TurnController@suggestion');
    Route::get('turns/print/{service_turn_id}','TurnController@printFile');

    Route::post('turns/add-medicines','TurnController@addMedicines');
    Route::get('turns/receive-debt/{id}','TurnController@receiveDebt');

    Route::get('turns/receive-single-debt/{id}','TurnController@receiveSingleDebt');

    Route::resource('turns', 'TurnController');

    Route::get('fund', 'AccountantController@index');
    Route::get('debts','AccountantController@debts');
    Route::get('debts/send-sms/{id}','TurnController@sendDebtSms');
    Route::get('insurance-daily', 'AccountantController@insurancesDailyDetail');
    Route::any('insurance-all', 'AccountantController@insurancesDetail');
    Route::any('fund/doctors-detail', 'AccountantController@dailyFundByDoctors');
    Route::any('fund/doctors-hourly', 'AccountantController@hourlyFundByDoctors');
    Route::any('fund/services-detail', 'AccountantController@dailyFundByServices');
    Route::get('fund/users','AccountantController@users');
    Route::get('fund/doctors','AccountantController@doctors');

    Route::any('fund/deliver', 'AccountantController@deliver');
    Route::any('fund/receive', 'AccountantController@receive');
    Route::any('fund/collect', 'AccountantController@collect');

    Route::post('medicines/add', 'MedicineController@add');
    Route::resource('medicines', 'MedicineController');
    Route::get('medicines/delete/{id}', 'MedicineController@destroy');

    Route::resource('questions', 'QuestionController');
    Route::resource('roles', 'RoleController');
    Route::get('permissions', 'PermissionController@index');
    Route::post('permissions/update', 'PermissionController@update');

    Route::get('users/{id}/toggle', 'UserController@toggle');
    Route::resource('users', 'UserController');


    Route::get('storage/search','DrugStorageController@search');
    Route::get('storage/add/{id}','DrugStorageController@add');
    Route::post('storage/update-drug','DrugStorageController@updateDrug');

    Route::get('storage/internal','DrugStorageController@internalStorage');
    Route::get('storage/shelf','DrugStorageController@shelfStorage');

    Route::get('storage/transfer/{id}','DrugStorageController@transfer');
    Route::post('storage/submit-transfer','DrugStorageController@submitTransfer');

    Route::get('storage/transfer-to-shelf/{id}','DrugStorageController@transferToShelf');
    Route::post('storage/submit-transfer-to-shelf','DrugStorageController@submitTransferToShelf');

    Route::get('drug-store','DrugStoreController@index');
    Route::get('drug-store/{service_turn_id}/seen','DrugStoreController@seen');
    Route::get('drug-store/{service_turn_id}/invoice','DrugStoreController@invoice');

    Route::resource('storage', 'DrugStorageController');
    Route::resource('cheques', 'ChequeController');

    Route::resource('paid-cheques', 'ChequeSerialController');

    Route::post('online-users', 'UserController@onlineUsers');
    Route::get('user/logout/{id}', 'UserController@logoutUser');

    Route::resource('settings','SettingController');

    Route::resource('bank-accounts','BankAccountController');

    Route::get('payment/form','PaymentController@form');

    Route::get('gateway','PaymentController@gateway');
    Route::get('callback','PaymentController@callback');

    Route::get('premium', function () {
        return view('premium');
    });

    Route::any('my-wallet', 'AccountantController@myWallet');

    Route::get('sms', function () {
        return view('my-wallet');
    });

    Route::get('ticket', function () {
        return view('my-wallet');
    });

    Route::get('return', function () {
        return view('return');
    });

    Route::get('about', function () {
        return view('about');
    });

    Route::get('insurance', function () {
        return view('insurance');
    });
});



    Route::resource('file-types', 'FileTypeController');
