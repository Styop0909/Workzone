@extends('layouts.app')

@section('page_title')
    Job Search
@endsection

    <style>
        body {
            overflow: hidden;
        }
        .box {
            display: flex;
            justify-content: space-between;
            height: 600px;
            gap: 1.5rem;
            align-items: flex-start;
            padding: 1rem;
        }

        .job-filter {
            position: sticky;
            top: 80px;
            left: 1rem;
            width: 400px;
            padding: 1.5rem;
            border: 1px solid rgba(224, 224, 224, 0.8);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            animation: filterSlideIn 0.6s ease-out forwards;
            z-index: 10;
        }

        @keyframes filterSlideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .job-filter:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .job-filter h5 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            font-size: 1.3rem;
            position: relative;
        }

        .job-filter h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 25%;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, #4299e1, #9f7aea);
            border-radius: 3px;
            transition: all 0.4s ease;
        }

        .job-filter:hover h5::after {
            width: 60%;
            left: 20%;
        }

        .job-filter .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .job-filter .form-control,
        .job-filter .form-select {
            border-radius: 10px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background-color: rgba(248, 250, 252, 0.8);
            padding: 0.75rem 1rem;
        }

        .job-filter .form-control:focus,
        .job-filter .form-select:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
            outline: none;
            background-color: white;
            transform: translateY(-1px);
        }

        .job-filter .form-control:hover,
        .job-filter .form-select:hover {
            border-color: #c3dafe;
        }

        .job-filter .btn-primary {
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 600;
            background: linear-gradient(135deg, #4299e1, #3182ce);
            border: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.2);
        }

        .job-filter .btn-primary:hover {
            background: linear-gradient(135deg, #3182ce, #2b6cb0);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(66, 153, 225, 0.3);
        }

        .job-filter .btn-primary:active {
            transform: translateY(0);
        }

        #clear_filters {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: linear-gradient(135deg, #718096, #4a5568);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(113, 128, 150, 0.2);
        }

        #clear_filters:hover {
            background: linear-gradient(135deg, #4a5568, #2d3748);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(113, 128, 150, 0.3);
        }

        #cards_parent {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: flex-start;
            align-content: flex-start;
            transition: opacity 0.4s ease;
        }

        .job-card {
            flex: 1 1 calc(50% - 1.5rem);
            min-width: 300px;
            max-width: calc(50% - 1.5rem);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(237, 242, 247, 0.8);
            opacity: 0;
            animation: cardFadeIn 0.6s forwards;
            animation-delay: calc(var(--delay) * 0.1s);
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .job-card:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(203, 213, 224, 0.6);
        }

        .job-card-header {
            border-bottom: 1px solid rgba(237, 242, 247, 0.8);
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8), white);
            transition: all 0.3s ease;
        }

        .job-card:hover .job-card-header {
            background: linear-gradient(135deg, rgba(226, 232, 240, 0.8), white);
        }

        .job-card-header h4 {
            margin: 0;
            font-weight: 600;
            color: #2d3748;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .job-card:hover .job-card-header h4 {
            color: #1a365d;
        }

        .job-card-body {
            padding: 1.5rem;
            color: #4a5568;
            flex-grow: 1;
            font-size: 0.95rem;
        }

        .job-card-body p {
            margin: 0.75rem 0;
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        .job-card:hover .job-card-body p {
            color: #2d3748;
        }

        .job-card-footer {
            display: flex;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            background-color: rgba(248, 250, 252, 0.8);
            border-top: 1px solid rgba(237, 242, 247, 0.8);
            border-radius: 0 0 16px 16px;
            transition: all 0.3s ease;
        }

        .job-card:hover .job-card-footer {
            background-color: rgba(226, 232, 240, 0.8);
        }

        .job-card-footer a,
        .job-card-footer button {
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .job-card-footer .btn-delete {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.2);
        }

        .job-card-footer .btn-delete:hover {
            background: linear-gradient(135deg, #e53e3e, #c53030);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 101, 101, 0.3);
        }

        .job-card-footer .btn-edit {
            background: linear-gradient(135deg, #f6e05e, #d69e2e);
            color: #744210;
            box-shadow: 0 4px 12px rgba(246, 224, 94, 0.2);
        }

        .job-card-footer .btn-edit:hover {
            background: linear-gradient(135deg, #d69e2e, #b7791f);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(246, 224, 94, 0.3);
            color: #5f370e;
        }

        .job-card-footer .btn-view {
            background: linear-gradient(135deg, #63b3ed, #4299e1);
            color: white;
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.2);
        }

        .job-card-footer .btn-view:hover {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(66, 153, 225, 0.3);
        }

        .loading-state {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(8px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .loading-state.active {
            opacity: 1;
            pointer-events: all;
        }

        .dots-loader {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .dots-loader div {
            position: absolute;
            top: 33px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4299e1, #9f7aea);
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.4);
        }

        .dots-loader div:nth-child(1) {
            left: 8px;
            animation: dots-loader1 0.6s infinite;
        }

        .dots-loader div:nth-child(2) {
            left: 8px;
            animation: dots-loader2 0.6s infinite;
        }

        .dots-loader div:nth-child(3) {
            left: 32px;
            animation: dots-loader2 0.6s infinite;
        }

        .dots-loader div:nth-child(4) {
            left: 56px;
            animation: dots-loader3 0.6s infinite;
        }

        @keyframes dots-loader1 {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        @keyframes dots-loader2 {
            0% { transform: translateX(0); }
            100% { transform: translateX(24px); }
        }

        @keyframes dots-loader3 {
            0% { transform: scale(1); }
            100% { transform: scale(0); }
        }

        @media (max-width: 1200px) {
            .box {
                flex-direction: column;
                height: auto;
            }

            .job-filter {
                position: static;
                width: 100%;
                margin-bottom: 1.5rem;
            }

            .job-card {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .job-filter {
                padding: 1.25rem;
            }

            .job-card-footer {
                flex-direction: column;
                gap: 0.75rem;
            }

            .job-card-footer a,
            .job-card-footer button {
                width: 100%;
                justify-content: center;
            }
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .spinner-container {
            text-align: center;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(13, 110, 253, 0.2);
            border-top-color: #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        .loading-text {
            margin-top: 15px;
            font-size: 1.1rem;
            color: #0d6efd;
            font-weight: 500;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@section('page_content')
    <div class="box">
        <div class="job-filter">
            <h5>🔍 Աշխատանքների ֆիլտրում</h5>

            <div class="mb-3">
                <label for="filter_job_title" class="form-label">Աշխատանքի անվանում</label>
                <input type="text" id="filter_job_title" class="form-control" name="filter_job_title" placeholder="Օրինակ՝ Ծրագրավորող">
            </div>

            <div class="mb-3">
                <label for="filter_employee_level" class="form-label">Աշխատողի մակարդակ</label>
                <select id="filter_employee_level" class="form-select">
                    <option value="">Ընտրել մակարդակը</option>
                    <option value="1">1 — Սկսնակ</option>
                    <option value="2">2 — Միջին</option>
                    <option value="3">3 — Ավագ</option>
                    <option value="4">4 — Չնշված</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="filter_work_experience" class="form-label">Աշխատանքային փորձ (տարի)</label>
                <input type="number" id="filter_work_experience" name="work_experience" class="form-control"
                       min="0" max="50" step="1" placeholder="0"
                       oninput="validity.valid||(value='');">
            </div>

            <div class="mb-3">
                <label for="filter_work_hours" class="form-label">Աշխատանքային ժամեր (օրական)</label>
                <input type="number" id="filter_work_hours" name="working_hours" class="form-control"
                       min="0" max="24" step="1" placeholder="0"
                       oninput="validity.valid||(value='');">
            </div>
            <div class="mb-3">
                <label for="filter_work_format" class="form-label">Աշխատանքի ձևաչափ</label>
                <select id="filter_work_format" class="form-select">
                    <option value="">Ընտրել ձևաչափը</option>
                    <option value="1">1 — Հեռավար</option>
                    <option value="2">2 — Աշխատանքի վայրում</option>
                    <option value="3">3 — Հիբրիդ</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="filter_sort" class="form-label">Դասավորել ըստ</label>
                <select id="filter_sort" class="form-select">
                    <option value="">Հիմնական</option>
                    <option value="newest">Նոր հայատարարությունների</option>
                    <option value="oldest">Հին հայատարարությունների</option>
                </select>
            </div>
            <button id="filter_btn" class="btn btn-primary w-100">Ֆիլտրել 🔎</button>
            <button id="clear_filters" class="btn btn-secondary w-100 mt-2">
                <i class="fas fa-broom"></i> Մաքրել ֆիլտրերը
            </button>
        </div>

        <div id="cards_parent"></div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Ջնջման հաստատում</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Փակել"></button>
                </div>
                <div class="modal-body">
                    Դուք համոզվա՞ծ եք, որ ցանկանում եք ջնջել այս աշխատանքը։
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Չեղարկել</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ջնջել</button>
                </div>
            </div>
        </div>
    </div>

    <div id="alertPlaceholder" style="position: fixed; top: 1rem; right: 1rem; z-index: 1055; min-width: 300px;"></div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function () {
            const cardsParent = $("#cards_parent");
            const loadingSpinner = $('#loading-spinner');
            const alertPlaceholder = $('#alertPlaceholder');
            const deleteModalEl = document.getElementById('deleteConfirmModal');
            const deleteModal = new bootstrap.Modal(deleteModalEl);
            const currentUserId = {{ auth()->id() }};
            const currentUserRole = "{{ auth()->user()->user_role }}";
            let deleteJobId = null;

            function showAlert(message, type = 'success') {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                alertPlaceholder.append(wrapper);

                setTimeout(() => {
                    $(wrapper).fadeOut(400, () => wrapper.remove());
                }, 3000);
            }

            function renderJobs(jobs, levelMap = {}, formatMap = {}) {
                cardsParent.empty();

                if (!jobs || jobs.length === 0) {
                    cardsParent.html(`
                        <div class="job-card" style="flex: 1 1 100%; max-width: 100%; text-align: center; padding: 2rem; opacity: 1;">
                            <div class="job-card-body">
                                <i class="fas fa-briefcase" style="font-size: 3rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                                <h4 style="color: #718096;">Աշխատանքային հայտարարություններ չեն գտնվել</h4>
                                <p style="color: #a0aec0;">Փորձեք փոխել ձեր ֆիլտրերը</p>
                            </div>
                        </div>
                    `);
                    return;
                }

                jobs.forEach((job, index) => {
                    const experience = job.work_experience !== undefined ? job.work_experience : 0;
                    const hours = job.working_hours !== undefined ? job.working_hours : 0;
                    const jobCard = $(`
                        <div class="job-card" data-id="${job.id}" style="--delay: ${index}">
                            <div class="job-card-header">
                                <h4>${job.job_title}</h4>
                            </div>
                            <div class="job-card-body">
                                <p><strong>Մակարդակ:</strong> ${levelMap[job.employee_level] || job.employee_level}</p>
                                <p><strong>Փորձ:</strong> ${experience} տարի</p>
                                <p><strong>Ժամեր:</strong> ${hours} ժամ</p>
                                <p><strong>Ձևաչափ:</strong> ${formatMap[job.work_format] || job.work_format}</p>
                            </div>
                            <div class="job-card-footer">
                                ${job.job_creator_id == currentUserId || currentUserRole === "1" ?
                        `<button type="button" class="btn btn-danger delete-btn" data-id="${job.id}">
                                    <i class="fas fa-trash"></i> Ջնջել
                                </button>
                                <a href="/jobs/${job.id}/edit" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Խմբագրել
                                </a>` : ''}
                                <a href="/jobs/${job.id}/show" class="btn btn-view">
                                    <i class="fas fa-eye"></i> Դիտել
                                </a>
                            </div>
                        </div>
                    `);
                    cardsParent.append(jobCard);
                });
            }

            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            function loadAllJobs() {
                loadingSpinner.addClass('active');
                cardsParent.css('opacity', '0.5');

                $.ajax({
                    url: "{{ route('get_all_jobs') }}",
                    method: "GET",
                    success: function(data) {
                        data.jobs = shuffleArray(data.jobs);
                        renderJobs(data.jobs, data.levels, data.formats);
                    },
                    complete: function() {
                        loadingSpinner.removeClass('active');
                        cardsParent.css('opacity', '1');
                    }
                });
            }

            function loadJobs(filters = {}) {
                loadingSpinner.addClass('active');
                cardsParent.css('opacity', '0.5');

                const processedFilters = {
                    job_title: filters.job_title || '',
                    employee_level: filters.employee_level || '',
                    work_experience: filters.work_experience ? parseInt(filters.work_experience) : null,
                    working_hours: filters.working_hours ? parseInt(filters.working_hours) : null,
                    work_format: filters.work_format || '',
                    sort: filters.sort || ''
                };

                const cleanFilters = Object.fromEntries(
                    Object.entries(processedFilters).filter(([_, v]) => v !== null && v !== '')
                );

                $.ajax({
                    url: '/jobs/filter',
                    method: 'GET',
                    data: cleanFilters,
                    success: function(data) {
                        if (data.jobs && data.jobs.length > 0) {
                            if (filters.sort === 'newest') {
                                data.jobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                            } else if (filters.sort === 'oldest') {
                                data.jobs.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                            } else {
                                data.jobs = shuffleArray(data.jobs);
                            }
                            renderJobs(data.jobs, data.levels, data.formats);
                        } else {
                            renderJobs([]);
                        }
                    },
                    error: function(xhr) {
                        console.error("Filter error:", xhr.responseText);
                        showAlert('Ֆիլտրման սխալ։ Խնդրում ենք փորձել ավելի ուշ։', 'danger');
                    },
                    complete: function() {
                        loadingSpinner.removeClass('active');
                        cardsParent.css('opacity', '1');
                    }
                });
            }

            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                deleteJobId = $(this).data('id');
                deleteModal.show();
            });

            $('#confirmDeleteBtn').on('click', function () {
                if (!deleteJobId) return;

                $.ajax({
                    url: `/jobs/${deleteJobId}/delete`,
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            $(`.job-card[data-id="${deleteJobId}"]`).fadeOut(300, function() {
                                $(this).remove();
                                if ($('.job-card').length === 0) {
                                    renderJobs([]);
                                }
                            });
                        } else {
                            showAlert('Ջնջումը չի հաջողվել։', 'danger');
                        }
                    },
                    error: function () {
                        showAlert('Սխալ տեղի ունեցավ։', 'danger');
                    },
                    complete: function () {
                        deleteModal.hide();
                        deleteJobId = null;
                    }
                });
            });

            $('#filter_btn').on('click', function() {
                const filters = {
                    job_title: $('#filter_job_title').val(),
                    employee_level: $('#filter_employee_level').val(),
                    work_experience: $('#filter_work_experience').val(),
                    working_hours: $('#filter_work_hours').val(),
                    work_format: $('#filter_work_format').val(),
                    sort: $('#filter_sort').val()
                };

                localStorage.setItem('jobFilters', JSON.stringify(filters));
                loadJobs(filters);
            });

            function restoreFilters() {
                const savedFilters = localStorage.getItem('jobFilters');
                if (savedFilters) {
                    try {
                        const filters = JSON.parse(savedFilters);
                        $('#filter_job_title').val(filters.job_title || '');
                        $('#filter_employee_level').val(filters.employee_level || '');
                        $('#filter_work_experience').val(filters.work_experience || '');
                        $('#filter_work_hours').val(filters.working_hours || '');
                        $('#filter_work_format').val(filters.work_format || '');
                        $('#filter_sort').val(filters.sort || '');
                        return filters;
                    } catch (e) {
                        localStorage.removeItem('jobFilters');
                    }
                }
                return null;
            }

            const savedFilters = restoreFilters();
            if (savedFilters) {
                loadJobs(savedFilters);
            } else {
                loadAllJobs();
            }

            $('#clear_filters').on('click', function() {
                $('.job-filter input').val('');
                $('.job-filter select').val('');
                loadAllJobs();
                localStorage.removeItem('jobFilters');
            });
        });
        // Show loading
        function showLoading() {
            $('#loading-spinner').fadeIn(300);
        }

        // Hide loading
        function hideLoading() {
            $('#loading-spinner').fadeOut(300);
        }

        // Օրինակ օգտագործման
        showLoading();
        // Կատարել AJAX հարցում...
        hideLoading();
    </script>
@endsection
