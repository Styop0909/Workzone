<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function view_dashboard()
    {
        return view('dashboard');
    }


    public function jobseeker_blade()
    {
        return view('jobseeker.jobseeker');
    }

    public function add_new_job_blade()
    {
        return view('jobseeker.add_new_job');
    }

    public function search_job_blade()
    {
        return view('jobseeker.jobseeker');
    }
}
