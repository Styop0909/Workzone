<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
Route::controller(RouteController::class)->group(function () {
    Route::get('/', 'view_dashboard')->name('view_dashboard')->middleware("check_user_type:1,2");
//    Route::get("/employer_blade", "employer_blade")->name("employer_blade")->middleware("check_user_type:1");
    Route::get("/jobseeker_blade", "jobseeker_blade")->name("jobseeker_blade")->middleware("check_user_type:2");
    Route::get("/add_new_job_blade","add_new_job_blade")->name("add_new_job_blade")->middleware("check_user_type:1");
    Route::get("/search_job_blade", "search_job_blade")->name("search_job_blade")->middleware("check_user_type:1");

})->middleware("auth");
