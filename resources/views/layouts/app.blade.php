@php use Illuminate\Support\Facades\Auth; @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield("page_title")</title>
    <link rel="icon" href="{{ asset('/assets/img/favicon-32x32.png') }}" type="image/png"
          style="width: 1px;height: 1px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="title" content="WorkZone v4 | Dashboard"/>
    <meta name="author" content="ColorlibHQ"/>
    <meta name="description"
          content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."/>
    <meta name="keywords"
          content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
          integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
          integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{ asset("/css/adminlte.css") }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-button@4.6.3/dist/index.min.css">
    <script src="https://cdn.jsdelivr.net/npm/emoji-button@4.6.3/dist/index.min.js"></script>
<style>
    #globalSearchForm {
        gap: 0.5rem;
        border: 1px solid #ced4da;
        border-radius: 999px;
        padding: 0.25rem 0.5rem;
        background: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    #globalSearchForm:focus-within {
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        border-color: #0d6efd;
    }

    #globalSearchForm input[type="text"] {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
        padding: 0.25rem 0.5rem;
        font-size: 0.9rem;
        width: 160px;
        transition: width 0.3s ease;
    }

    #globalSearchForm input[type="text"]:focus {
        width: 200px;
    }

    #globalSearchForm button {
        border: none;
        background: #0d6efd;
        color: white;
        padding: 0.35rem 0.6rem;
        border-radius: 999px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
    }

    #globalSearchForm button:hover {
        background: #0b5ed7;
    }
    .app-header{
        position: sticky;
        top: 0;
    }
</style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Start Navbar Links-->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center">
                    <form id="globalSearchForm" class="d-flex" role="search">
                        <input type="text" id="job_search_input" placeholder="Որոնել աշխատանքը..." class="form-control">
                        <button type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <input type="hidden" id="job_title_filter_input" name="job_title">
                </li>


                @auth
                    <li class="nav-item dropdown" id="chat-dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text"></i>
                            <span class="navbar-badge badge text-bg-danger" id="message-count">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" id="chat-dropdown-menu">
                            <div id="chat-dropdown-items"></div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('view_chat') }}" class="dropdown-item dropdown-footer">See All
                                Messages</a>
                        </div>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                        <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                        <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                    </a>
                </li>
                <li class="nav-item dropdown user-menu">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center gap-2" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=36"
                                class="rounded-circle shadow-sm" alt="avatar" width="36" height="36">
                            <i class="bi bi-chevron-down text-primary"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 p-3 mt-2 border-0"
                            style="min-width: 260px;" aria-labelledby="userDropdown">
                            <li class="text-center mb-3">
                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=72"
                                    class="rounded-circle shadow mb-2 border border-2 border-white" alt="avatar"
                                    width="72" height="72">
                                <div class="fw-semibold fs-6">{{ Auth::user()->name }}</div>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                                <div class="text-muted small">
                                    {{ config('user.user_type')[Auth::user()->user_type] ?? 'Չսահմանված' }}
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   class="btn btn-outline-danger w-100 rounded-3 fw-medium">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </a>

                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('view_login') }}">Login</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('view_register') }}">Register</a>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand px-3 py-3 d-flex align-items-center">
            <a href="{{ route('view_dashboard') }}" class="d-flex align-items-center text-decoration-none">
                <div class="d-flex align-items-center">
                    <img
                        src="{{ asset('/assets/img/WorkZone1.png') }}"
                        alt="W Logo"
                        style="width: 142px; height: 142px; object-fit: contain; margin-right: -3px;"
                    />
                </div>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2" id="mainContent">
                <ul
                    class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <li class="nav-item">
                        <a href="{{ route("view_dashboard") }}" class="nav-link">
                            <i class="nav-icon bi bi-palette"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @auth
                        <li class="nav-item {{ request()->routeIs("add_new_job_blade","search_job_blade") ? "menu-open" : "" }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs("add_new_job","search_job_blade") ? "active" : "" }}">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Աշխատանք
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            @endauth
                            <ul class="nav nav-treeview">
                                @auth
                                    @if(Auth::user()->user_type==1)
                                        <li class="nav-item">
                                            <a href="{{ route("add_new_job_blade") }}"
                                               class="nav-link  {{ request()->routeIs("add_new_job_blade") ? "active" : "" }}">
                                                <i class="nav-icon bi bi-circle"></i>
                                                <p>Ավելացնել աշխատանք</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route("search_job_blade") }}"
                                               class="nav-link  {{ request()->routeIs("search_job_blade") ? "active" : "" }}">
                                                <i class="nav-icon bi bi-circle"></i>
                                                <p>Բոլոր Աշխատատեղերը</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route("my_jobs_view") }}"
                                               class="nav-link  {{ request()->routeIs("my_jobs_view") ? "active" : "" }}">
                                                <i class="nav-icon bi bi-circle"></i>
                                                <p>Իմ Հայտարարությունները</p>
                                            </a>
                                        </li>
                                    @endif
                                @endauth
                                @auth
                                    @if(Auth::user()->user_type==2)
                                        <li class="nav-item">
                                            <a href="{{ route("search_job_blade") }}"
                                               class="nav-link  {{ request()->routeIs("search_job_blade") ? "active" : "" }}">
                                                <i class="nav-icon bi bi-circle"></i>
                                                <p>Որոնել աշխատանք</p>
                                            </a>
                                        </li>
                                    @endif
                                @endauth
                            </ul>
                        </li>
                </ul>
            </nav>
        </div>
    </aside>
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">@yield("page_title")</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route("view_dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield("page_title")</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                @yield('page_content')
            </div>
        </div>
    </main>
    <footer class="app-footer">
        <div class="float-end d-none d-sm-inline"></div>
        <strong>
            Copyright &copy; 2025&nbsp;
            <a href="{{ route("view_dashboard") }}" class="text-decoration-none">WorkZone</a>.
        </strong>
        All rights reserved.
    </footer>
</div>
<script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"
></script>
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"
></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset("/js/adminlte.js") }}"></script>

<script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
    $(document).ready(function () {
        $.ajax({
            url: "{{ route('recent_chats') }}",
            type: "GET",
            success: function (chats) {
                const container = $('#chat-dropdown-items');
                const countBadge = $('#message-count');

                container.empty();
                countBadge.text(chats.length);

                if (chats.length === 0) {
                    container.append('<span class="dropdown-item text-muted">Չկան նոր հաղորդագրություններ</span>');
                }
                const currentUserId = {{ auth()->id() }};

                chats.forEach(chat => {
                    const isMine = chat.last_message_sender_id === currentUserId;
                    const lastMessage = isMine
                        ? `<span style="color: gray; font-size: 0.85em;font-weight: bold">Ես։</span> ${chat.last_message}`
                        : chat.last_message;

                    const html = `
        <a href="/chat/${chat.id}" class="dropdown-item">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <img src="${chat.avatar}" alt="Avatar" class="img-size-50 rounded-circle me-3" />
                </div>
                <div class="flex-grow-1" style="min-width: 0;">
                    <h3 class="dropdown-item-title">${chat.name}</h3>
                    <div style="max-width: 200px;">
                      <p class="fs-7 mb-0 text-truncate" style="white-space: nowrap; text-overflow: ellipsis;">
                        ${lastMessage}
                      </p>
                    </div>
                    <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> ${chat.time}
                    </p>
                </div>
            </div>
        </a>
        <div class="dropdown-divider"></div>
    `;
                    container.append(html);
                });
            },
            error: function () {
                $('#chat-dropdown-items').html('<span class="dropdown-item text-danger">❌ Չհաջողվեց բեռնել հաղորդագրությունները</span>');
            }
        });
    });
    $(window).on("load", function () {
        let savedScroll = localStorage.getItem("scrollTop");

        if (savedScroll !== null && !isNaN(savedScroll)) {
            let tryScroll = () => {
                if (document.body.scrollHeight > window.innerHeight) {
                    window.scrollTo(0, parseInt(savedScroll));
                } else {
                    setTimeout(tryScroll, 100);
                }
            };
            tryScroll();
        }

        window.addEventListener("scroll", () => {
            localStorage.setItem("scrollTop", window.scrollY);
        });
    });
    document.getElementById("globalSearchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const search = document.getElementById("job_search_input").value.trim();
        const url = new URL("{{ route('jobs.index') }}", window.location.origin);
        if (search) {
            url.searchParams.set('job_title', search);
        }
        window.location.href = url.toString();
    });
    $(document).ready(function () {
        let searchTimeout;

        $('#job_search_input').on('input', function () {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(function () {
                const title = $('#job_search_input').val();
                $('#job_title_filter_input').val(title);
                loadJobs(filters);
            }, 400);
        });
    });
    function renderJobCards(jobs) {
        const container = $('#jobs_container');
        container.empty();

        if (jobs.length === 0) {
            container.append('<p class="text-muted">Չկան համապատասխան աշխատանքներ։</p>');
            return;
        }

        jobs.forEach(job => {
            const card = `
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">${job.job_title}</h5>
                    <p class="card-text"><strong>Մակարդակ:</strong> ${job.employee_level}</p>
                    <p class="card-text"><strong>Փորձ:</strong> ${job.work_experience} տարի</p>
                    <p class="card-text"><strong>Ժամեր:</strong> ${job.working_hours}</p>
                    <p class="card-text"><strong>Ձևաչափ:</strong> ${job.work_format}</p>
                </div>
            </div>
        `;
            container.append(card);
        });
    }

</script>
@yield("page_script")

</body>
</html>
