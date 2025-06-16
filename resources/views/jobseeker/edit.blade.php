@extends('layouts.app')

@section('page_title', 'Խմբագրել Աշխատանք')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    #formContent {
        justify-content: flex-start;
        align-items: flex-start;
        max-width: 530px;
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 16px 50px rgba(0, 0, 0, 0.08);
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        font-size: 1rem;
        color: #2563eb;
        text-decoration: none;
        cursor: pointer;
        user-select: none;
        transition: color 0.3s ease;
        margin-bottom: 24px; /* Ավելացրեցի այս տողը */
        position: relative;
        overflow: hidden;
    }

    .btn-back::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 1px;
        width: 100%;
        background: linear-gradient(to right, #2563eb, #1e40af);
        transform: translateX(-100%);
        transition: transform 0.4s ease-in-out;
    }

    .btn-back:hover::after {
        transform: translateX(0);
    }

    .btn-back::before {
        content: '←';
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1;
    }
    h2 {
        text-align: center;
        margin-bottom: 35px;
        color: #212121;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        user-select: none;
    }

    .form-label {
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
        display: block;
        font-size: 1rem;
        letter-spacing: 0.02em;
        user-select: none;
    }

    .form-control, select.form-control {
        border: none;
        border-radius: 20px;
        padding: 14px 20px;
        background: #f7f9fb;
        font-size: 1rem;
        color: #333;
        box-shadow: inset 0 0 0 1.5px #d1d9e6;
        transition: box-shadow 0.3s ease, background-color 0.3s ease;
        width: 100%;
        user-select: text;
    }

    .form-control::placeholder {
        color: #aab3be;
        font-weight: 400;
        font-style: italic;
    }

    .form-control:focus, select.form-control:focus {
        box-shadow: 0 0 8px 3px rgba(33, 150, 243, 0.3);
        background: #fff;
        outline: none;
        color: #222;
    }

    .btn-submit {
        background: linear-gradient(135deg, #2196f3, #21cbf3);
        border: none;
        color: white;
        font-weight: 700;
        width: 100%;
        padding: 16px 0;
        margin-top: 28px;
        border-radius: 25px;
        font-size: 1.15rem;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(33, 203, 243, 0.5);
        transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        user-select: none;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #1976d2, #00bcd4);
        box-shadow: 0 12px 30px rgba(0, 188, 212, 0.7);
        transform: translateY(-3px);
    }

    .btn-submit:active {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(33, 203, 243, 0.4);
    }

    .btn-cancel {
        margin-top: 16px;
        width: 100%;
        text-align: center;
        display: inline-block;
        padding: 12px 0;
        background: #d5deec;
        color: #333;
        font-weight: 600;
        border-radius: 25px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-cancel:hover {
        background: #999ba1;
    }

</style>

@section('page_content')
    @php
        $backUrl = url()->previous();
    @endphp
    <a href="{{ $backUrl }}" class="btn-back" aria-label="Վերադառնալ աշխատանքների ցանկին">
        Վերադառնալ
    </a>
    <form id="formContent" method="POST" action="{{ route('jobs_update', $job->id) }}">
        @csrf
        <div class="mb-3">
            <label for="job_title" class="form-label">Պաշտոն</label>
            <input type="text" id="job_title" name="job_title" class="form-control"
                   value="{{ old('job_title', $job->job_title) }}" placeholder="Օրինակ՝ Backend Developer">
        </div>

        <div class="mb-3">
            <label for="employee_level" class="form-label">Աշխատակցի մակարդակ</label>
            <select id="employee_level" name="employee_level" class="form-control">
                <option value="" disabled>Ընտրել մակարդակ</option>
                @foreach(config('job.levels') as $key => $value)
                    <option value="{{ $key }}" @if(old('employee_level', $job->employee_level) == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="work_experience" class="form-label">Աշխատանքային փորձ (տարի)</label>
            <input type="number" id="work_experience" name="work_experience" class="form-control"
                   value="{{ old('work_experience', $job->work_experience) }}" placeholder="Օրինակ՝ 2">
        </div>

        <div class="mb-3">
            <label for="working_hours" class="form-label">Աշխատանքային ժամեր</label>
            <input type="number" id="working_hours" name="working_hours" class="form-control"
                   value="{{ old('working_hours', $job->working_hours) }}" placeholder="Օրինակ՝ 8">
        </div>

        <div class="mb-3">
            <label for="work_format" class="form-label">Աշխատանքային ձևաչափ</label>
            <select id="work_format" name="work_format" class="form-control">
                <option value="" disabled>Ընտրել ձևաչափ</option>
                @foreach(config('job.formats') as $key => $value)
                    <option value="{{ $key }}" @if(old('work_format', $job->work_format) == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn-submit" type="submit">Թարմացնել</button>
        <a href="{{ route('jobs_view') }}" class="btn-cancel">Չեղարկել</a>
    </form>
@endsection
