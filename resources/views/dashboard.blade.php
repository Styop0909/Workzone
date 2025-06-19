@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')

@section('page_title')
    axper karas pul anes qo main um
@endsection

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: #f7f9fc;
        opacity: 0;
        animation: fadeIn 0.5s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .dashboard-card {
        transition: all 0.3s ease-in-out;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transform: translateY(20px);
        opacity: 0;
        animation: cardSlideUp 0.6s ease-out forwards;
    }

    @keyframes cardSlideUp {
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .dashboard-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .gradient-blue {
        background: linear-gradient(135deg, #4e73df, #375ac2);
        color: #fff;
        animation-delay: 0.1s;
    }

    .gradient-green {
        background: linear-gradient(135deg, #1cc88a, #17a673);
        color: #fff;
        animation-delay: 0.2s;
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f6c23e, #dda20a);
        color: #fff;
        animation-delay: 0.3s;
    }

    .avatar {
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .avatar:hover {
        transform: scale(1.1);
    }

    /* Page transition overlay */
    .page-transition {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        transform: translateY(100%);
        pointer-events: none;
    }

    /* Smooth content transitions */
    .smooth-transition {
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    /* Loading spinner */
    .loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10000;
        display: none;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

@section('page_content')
    <!-- Loading Spinner -->
    <div class="loading-spinner">
        <div class="spinner"></div>
    </div>

    <!-- Page transition overlay -->
    <div class="page-transition"></div>

    <div class="container py-5 smooth-transition">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-dark">Welcome back, <span class="text-primary">{{ auth()->user()->name }}</span></h2>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d6efd&color=fff&size=128"
                 width="50" alt="avatar" class="avatar">
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card dashboard-card gradient-blue text-center h-100">
                    <div class="card-body py-4">
                        <i class="fas fa-briefcase fa-2x mb-3"></i>
                        <h5 class="fw-bold mb-1">Total Jobs</h5>
                        <p class="fs-4 fw-semibold">--</p>
                        <small>All jobs you've added</small>
                    </div>
                </div>
            </div>

            @if(Auth::user()->user_type == 1)
                <div class="col-md-4">
                    <a href="{{ route('add_new_job_blade') }}" class="text-decoration-none smooth-link">
                        <div class="card dashboard-card gradient-green text-center h-100">
                            <div class="card-body py-4">
                                <i class="fas fa-plus-circle fa-2x mb-3"></i>
                                <h5 class="fw-bold mb-1">Add New Job</h5>
                                <p class="fs-6">Post your next opportunity</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <div class="col-md-4">
                <a href="{{ route('jobs_view') }}" class="text-decoration-none smooth-link">
                    <div class="card dashboard-card gradient-orange text-center h-100">
                        <div class="card-body py-4">
                            <i class="fas fa-list fa-2x mb-3"></i>
                            <h5 class="fw-bold mb-1">View All Jobs</h5>
                            <p class="fs-6">See everything in one place</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="mt-5">
            <div class="card shadow-sm border-0 rounded-4 bg-white smooth-transition" style="animation-delay: 0.4s;">
                <div class="card-body py-4 px-4">
                    <h5 class="fw-bold mb-2">📊 Quick Overview</h5>
                    <p class="text-muted mb-1">This panel will soon show charts, stats and productivity insights.</p>
                    <p class="text-muted">Stay organized and track your job flow with WorkZone 🚀</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pageTransition = document.querySelector('.page-transition');
            if (pageTransition) {
                setTimeout(() => {
                    pageTransition.style.transform = 'translateY(-100%)';
                    setTimeout(() => pageTransition.remove(), 1000);
                }, 100);
            }

            document.querySelectorAll('.smooth-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') return;

                    e.preventDefault();
                    const targetUrl = this.getAttribute('href');

                    document.querySelector('.loading-spinner').style.display = 'block';

                    document.querySelectorAll('.smooth-transition').forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(20px)';
                    });

                    const newTransition = document.createElement('div');
                    newTransition.className = 'page-transition';
                    newTransition.style.transform = 'translateY(0)';
                    document.body.appendChild(newTransition);

                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 500);
                });
            });

            window.addEventListener('beforeunload', function() {
                document.querySelector('.loading-spinner').style.display = 'block';
            });
        });
    </script>
@endsection
