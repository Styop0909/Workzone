@extends('layouts.app')
@section("page_title","Show Job")
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 720px;
            margin: 10px auto 30px;
            padding: 0 20px;
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

        .job-card {
            background: white;
            border-radius: 14px;
            padding: 32px 30px;
            box-shadow: 0 12px 30px rgb(0 0 0 / 0.07);
            transition: box-shadow 0.3s ease, transform 0.2s ease;
            user-select: none;
        }

        .job-card:hover,
        .job-card:focus-within {
            box-shadow: 0 16px 40px rgb(0 0 0 / 0.12);
            transform: translateY(-4px);
        }

        .job-card h4 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: #1e293b;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
            max-width: max-content;
            user-select: text;
        }

        .creator-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 1.1rem;
            color: #475569;
            font-weight: 600;
            user-select: text;
        }

        .creator-info strong {
            min-width: 140px;
            color: #64748b;
            user-select: none;
        }

        .creator-info span.name {
            background: linear-gradient(#3d4149);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .job-card p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 12px 0;
            color: #334155;
            user-select: text;
            flex-wrap: nowrap; /* եթե շատ փոքր է էկրանը */
        }

        .job-card p strong {
            width: 235px;
            flex-shrink: 0;
            color: #64748b;
        }


        .created-at {
            font-style: italic;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-top: 22px;
            user-select: none;
        }

        #apply_job {
            margin-top: 36px;
            display: inline-block;
            min-width: 160px;
            background-color: #10b981;
            border: none;
            padding: 14px 0;
            border-radius: 28px;
            font-weight: 700;
            font-size: 1.15rem;
            color: white;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 6px 15px rgb(16 185 129 / 0.45);
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.15s ease;
            user-select: none;
            vertical-align: middle;
        }

        #apply_job:hover {
            background-color: #059669;
            box-shadow: 0 8px 20px rgb(5 150 105 / 0.6);
        }
    </style>


@section('page_content')
    <div class="container">
        @php
            $backUrl = url()->previous();
        @endphp
        <a href="{{ $backUrl }}" class="btn-back" aria-label="Վերադառնալ աշխատանքների ցանկին">
            Վերադառնալ
        </a>


        <article class="job-card" role="region" aria-labelledby="jobTitle">
            <h4 id="jobTitle" tabindex="0">{{ $job->job_title }}</h4>

            <div class="creator-info">
                <strong>Հայտարարության ստեղծող:</strong>
                <span class="name">{{ $job->user->name }}</span>
            </div>

            <p><strong>Մակարդակ:</strong> {{ config('job.levels')[$job->employee_level] }}</p>
            <p><strong>Փորձ:</strong> {{ $job->work_experience }} տարի</p>
            <p><strong>Աշխատանքային ժամեր:</strong> {{ $job->working_hours }} ժ</p>
            <p><strong>Ձևաչափ:</strong> {{ config('job.formats')[$job->work_format] }}</p>
            <p class="created-at"><strong>Ստեղծվել է:</strong> {{ $job->created_at->locale('hy')->diffForHumans() }}</p>

            @if(Auth::id() != $job->job_creator_id && Auth::user()->user_type == 2)
                <button id="apply_job" data-job-id="{{ $job->id }}" aria-label="Դիմել աշխատանքին">Դիմել</button>
            @endif
        </article>
    </div>
@endsection

@section('page_script')
    <script>
        $(function() {
            $('#apply_job').on('click', function() {
                const job_id = $(this).data('job-id');

                $.ajax({
                    url: "{{ route('apply_job', ['id' => ':id']) }}".replace(':id', job_id),
                    method: 'POST',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function() {
                        alert('Տեղի ունեցավ սխալ, փորձեք կրկին։');
                    }
                });
            });
        });
    </script>
@endsection
