<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index_view')->name('jobs.index');
    Route::post("/add_new_job", "add_new_job")->name("add_new_job")->middleware("check_user_type:1");
    Route::get("/all/jobs/view", "index_view")->name("jobs_view")->middleware("check_user_type:1,2");
    Route::get("/get_all_jobs", "index")->name("get_all_jobs")->middleware("check_user_type:1,2");
    Route::post('/jobs/{id}/delete','destroy')->name('jobs_delete')->middleware("check_user_type:1");
    Route::get("/jobs/{id}/edit","edit")->name('jobs_edit')->middleware("check_user_type:1");
    Route::post('/jobs/{id}/update','update')->name('jobs_update')->middleware("check_user_type:1");
    Route::get('/jobs/{id}/show','show')->name('show_job')->middleware("check_user_type:1,2");
    Route::post('/apply_job/{id}','apply_job')->name('apply_job')->middleware("check_user_type:1");
    Route::get("/my/jobs","my_jobs")->name("my_jobs")->middleware("check_user_type:1");
    Route::get("my/jobs/view","my_jobs_view")->name("my_jobs_view")->middleware("check_user_type:1");
    Route::get("/jobs/filter","jobs_filter")->name("jobs_filter")->middleware("check_user_type:1,2");
    Route::get('/jobs/autosearch', 'autosearch')
        ->middleware("check_user_type:1,2");
})->middleware("auth");
