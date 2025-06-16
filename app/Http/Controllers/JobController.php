<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Workplace;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index_view()
    {
        return view("jobseeker.jobseeker");
    }
    public function index(Request $request)
    {
        $jobs = Workplace::with("user")->get()->toArray();
        return response()->json([
            'jobs' => $jobs,
            'levels' => config('job.levels'),
            'formats' => config('job.formats'),
        ]);
    }


    public function show($id)
    {
        $job = Workplace::with("user")->findOrFail($id);
        return view('jobseeker.show_job', ['job' => $job]);
    }

    public function create()
    {
        return view('jobs.add_new_job');
    }

    public function add_new_job(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string',
            'employee_level' => 'required|not_in:0',
            'work_experience' => 'required|string',
            'working_hours' => 'required|string',
            'work_format' => 'required|not_in:0',
        ]);

        Workplace::create([
            'job_title' => $request->input('job_title'),
            'employee_level' => $request->input('employee_level'),
            'work_experience' => $request->input('work_experience'),
            'working_hours' => $request->input('working_hours'),
            'work_format' => $request->input('work_format'),
            'job_creator_id' => Auth::user()->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Աշխատանքային հայտարարությունը ստեղծված է։']);
    }
    public function jobs_filter(Request $request)
    {
        $query = Workplace::query();

        if ($request->filled('job_title')) {
            $query->where('job_title', 'like', '%' . $request->job_title . '%');
        }
        if ($request->filled('employee_level')) {
            $query->where('employee_level', $request->employee_level);
        }
        if ($request->filled('work_experience')) {
            $query->where('work_experience', '>=', (int)$request->work_experience);
        }
        if ($request->filled('working_hours')) {
            $query->where('working_hours', (int)$request->working_hours); // Ճիշտ 9 ժամ
        }
        if ($request->filled('work_format')) {
            $query->where('work_format', $request->work_format);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $jobs = $query->get();

        return response()->json([
            'jobs' => $jobs,
            'levels' => config('job.levels'),
            'formats' => config('job.formats'),
        ]);
    }


    public function edit($id)
    {
        $job = Workplace::where('job_creator_id', Auth::user()->id)->findOrFail($id);
        if ($job) {
            return view('jobseeker.edit', ["job" => $job]);
        } else {
            return back()->withErrors(["message" => "Այս հայտարարությունը պատկանում է ուրիշին դուք այն չեք կարող խմբագրել"]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'employee_level' => 'required|string',
            'work_experience' => 'required|integer',
            'working_hours' => 'required|integer',
            'work_format' => 'required|string',
        ]);

        $job = Workplace::where('job_creator_id', auth()->id())->findOrFail($id);

        $job->update([
            'job_title' => $request->job_title,
            'employee_level' => $request->employee_level,
            'work_experience' => $request->work_experience,
            'working_hours' => $request->working_hours,
            'work_format' => $request->work_format,
        ]);

        return redirect()->route('jobs_view')->with('success', 'Հայտարարությունը թարմացվել է։');
    }


    public function destroy($id)
    {
        $job = Workplace::findOrFail($id);
        if (Auth::user()->id !== $job->job_creator_id && Auth::user()->user_role !== 1) {
            return response()->json(['error' => 'Թույլատրված չէ'], 403);
        }
        $job->delete();
        return response()->json(['success' => true, 'message' => 'Աշխատանքը հաջողությամբ ջնջվեց։']);
    }

    public function apply_job(Request $request,$id)
    {
        $job = Workplace::findOrFail($id);
        $receiver_id = $job->job_creator_id;
        $sender_id = Auth::user()->id;
        $job_name = $job->job_title;
        $message = Message::create([
           "sender_id" => $sender_id,
           "receiver_id" => $receiver_id,
           "message" => "Բարև ձեզ ես դիմում եմ $job_name-ի հայտարարության համար"
        ]);
        if ($message){
            return response()->json(['success' => true, 'message' => 'Նամակը  հաջողությամբ ուղղարկվեց։']);
        }
    }

    public function my_jobs_view()
    {
        return view('jobseeker.my_jobs');
    }
    public function my_jobs()
    {
        $my_id = Auth::user()->id;
        $my_jobs = Workplace::where('job_creator_id', $my_id)->latest()->get();
        return response()->json([
            "data" => $my_jobs,
            'levels' => config('job.levels'),
            'formats' => config('job.formats'),
            ]);
    }
}
