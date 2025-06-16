<!doctype html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Register</title>
    <link rel="icon" href="{{ asset('/assets/img/WorkZone1.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Register Page v2" />
    <meta name="author" content="ColorlibHQ" />
    <meta
        name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
        name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
        crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
        crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset("css/adminlte.css") }}" />
    <!--end::Required Plugin(AdminLTE)-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="register-page bg-body-secondary">
<div class="register-box">
    <!-- /.register-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header d-flex align-items-center justify-content-center" style="gap: 8px;">
            <a href="{{ route('view_dashboard') }}" class="d-flex align-items-center text-decoration-none">
                <img
                    src="{{ asset('/assets/img/WorkZone1.png') }}"
                    alt="WorkZone Logo"
                    style="width: 152px; height: 25px; object-fit: contain;"
                    class="me-1"
                />
            </a>
        </div>

        <div class="card-body register-card-body">
            <h3 class="register-box-msg" style="font-size: 1.6rem; height: 40px">
                Register
            </h3>
                <form action="{{ route("register") }}" method="post">
                @csrf
                <div class="input-group mb-1">
                    <div class="form-floating">
                        <select name="user_type" class="form-control @if($errors->has("user_type")) is-invalid @endif" id="registerUserType">
                            <option value="" disabled selected>Ընտրեք օգտատիրոջ տիպը</option>
                            <option value="1" {{ old("user_type") == "1" ? "selected" : "" }}>Կազմակերպություն</option>
                            <option value="2" {{ old("user_type") == "2" ? "selected" : "" }}>Գործ որոնող</option>
                        </select>
                        <label for="registerUserType">User Type</label>
                        @if($errors->has("user_type"))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first("user_type") }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group-text"><span class="bi bi-person-bounding-box"></span></div>
                </div>
                <div class="input-group mb-1">
                    <div class="form-floating">
                        <input id="registerFullName" name="name" type="text" class="form-control @if($errors->has("name")) is-invalid @endif" value="{{ old("name") }}"  placeholder="" />
                        <label for="registerFullName">Full Name</label>
                        @if($errors->has("name"))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first("name") }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group-text"><span class="bi bi-person"></span></div>
                </div>
                <div class="input-group mb-1">
                    <div class="form-floating">
                        <input id="registerEmail" name="email" type="email" class="form-control @if($errors->has("email")) is-invalid @endif" value="{{ old("email") }}" placeholder="" />
                        <label for="registerEmail">Email</label>
                        @if($errors->has("email"))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first("email") }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                <div class="input-group mb-1">
                    <div class="form-floating">
                        <input id="registerPassword" name="password" type="password" class="form-control @if($errors->has("password")) is-invalid @endif" placeholder="" />
                        <label for="registerPassword">Password</label>
                        @if($errors->has("password"))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first("password") }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>

                <!--begin::Row-->
                <div class="row mt-2 mb-2">
                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </form>
            <!-- /.social-auth-links -->
            <p class="mb-0">
                <a href="{{ route("view_login") }}" class="link-primary text-center"> I already have a membership </a>
            </p>
        </div>
        <!-- /.register-card-body -->
    </div>
</div>
<!-- /.register-box -->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"
></script>
<!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"
></script>
<!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"
></script>
<!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
<script src="{{ asset("js/adminlte.js") }}"></script>
<!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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
</script>
<!--end::OverlayScrollbars Configure-->
<!--end::Script-->
</body>
<!--end::Body-->
</html>
