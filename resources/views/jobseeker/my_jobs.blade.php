@extends('layouts.app')

@section('page_title', 'Իմ հայտարարությունները')

<style>
    /* Main Container */
    .jobs-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding: 1.5rem 0;
    }

    /* Filter Section with Animation */
    .filter-section {
        flex: 0 0 350px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        height: fit-content;
    }

    .filter-section.collapsed {
        transform: translateX(-100%);
        opacity: 0;
        padding: 1.5rem 0;
        width: 0;
        overflow: hidden;
        border: none;
        box-shadow: none;
    }

    /* Filter Toggle Button */
    .filter-toggle {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 30;
        padding: 0.6rem 1rem;
        border-radius: 12px;
        background: #4A00E0;
        color: #fff;
        border: none;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: 0.3s;
    }


    .filter-toggle:hover {
        background: #8E2DE2;
        transform: translateY(-2px);
    }

    .filter-toggle i {
        transition: transform 0.4s ease;
    }

    .filter-toggle.collapsed i {
        transform: rotate(180deg);
    }

    .filter-content {
        transition: opacity 0.2s ease 0.1s;
    }

    .filter-section.collapsed .filter-content {
        opacity: 0;
        transition: opacity 0.1s ease;
    }

    /* Results Section Animation */

    .results-section {
        flex: 1;
        min-width: 0;
    }

    .filter-section:not(.collapsed) + .results-section {
        margin-left: 1.5rem;
    }

    .filter-group {
        margin-bottom: 1.25rem;
    }


    .filter-group label {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.4rem;
        color: #2d3748;
        display: block;
    }

    .filter-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        background: #f7fafc;
    }


    .filter-control:focus {
        border-color: #667eea;
        outline: none;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }

    /* Buttons */
    .btn-filter {
        width: 100%;
        padding: 0.8rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }


    .btn-primary {
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
        border: none;
    }

    .btn-secondary {
        background: linear-gradient(to right, #a0aec0, #718096);
        color: white;
        border: none;
    }

    .btn-primary:hover,
    .btn-secondary:hover {
        transform: translateY(-2px);
    }

    /* Job Cards */
    .job-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.25rem;
    }

    .job-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid rgba(237, 242, 247, 0.8);
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: cardAppear 0.6s forwards;
        animation-delay: calc(var(--delay) * 0.1s);
    }

    @keyframes cardAppear {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    .job-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(237, 242, 247, 0.8);
    }

    .job-card-header h4 {
        margin: 0;
        font-weight: 600;
        color: #2d3748;
        font-size: 1.2rem;
    }

    .job-card-body {
        padding: 1.5rem;
        color: #4a5568;
    }

    .job-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .job-meta-item i {
        margin-right: 0.5rem;
        color: #718096;
        width: 20px;
        text-align: center;
    }

    .job-card-footer {
        display: flex;
        padding: 1rem;
        border-top: 1px solid rgba(237, 242, 247, 0.8);
        gap: 30px;
    }

    .job-action {
        flex: 1;
        text-align: center;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .job-action:hover {
        transform: translateY(-2px);
    }

    .action-view {
        background: linear-gradient(135deg, #63b3ed, #4299e1);
        color: white;
        text-decoration: none;
    }

    .action-edit {
        background: linear-gradient(135deg, #f6e05e, #d69e2e);
        color: #744210;
        text-decoration: none;
    }

    .action-delete {
        background: linear-gradient(135deg, #f56565, #e53e3e);
        color: white;
        border: none;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
    }
    .modal .modal-content {
        border-radius: 12px;
    }

    #alertPlaceholder {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1055;
        min-width: 280px;
    }

    @media (max-width: 992px) {
        .jobs-container {
            flex-direction: column;
        }

        .filter-section {
            width: 100%;
            position: static;
        }

        .filter-toggle {
            display: none;
        }
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

    .loading-text {
        margin-top: 15px;
        font-size: 1.1rem;
        color: #4a5568;
        font-weight: 500;
    }

    /* Empty State */
    .empty-state {
        padding: 2rem;
        text-align: center;
        color: #718096;
    }

    .empty-state i {
        font-size: 3.5rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        color: #718096;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .empty-state p {
        color: #a0aec0;
    }

    /* Alert Notifications */
    #alertPlaceholder {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1055;
        min-width: 300px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .jobs-container {
            flex-direction: column;
        }

        .filter-section {
            position: static;
            width: 100% !important;
            transform: none !important;
            opacity: 1 !important;
            padding: 1.5rem !important;
            margin-bottom: 1.5rem;
        }

        .filter-toggle {
            display: none;
        }

        .filter-section:not(.collapsed) + .results-section {
            margin-left: 0;
        }
    }
    @media (max-width: 768px) {
        .filter-toggle {
            top: auto;
            bottom: 1rem;
            left: 1rem;
        }
        .filter-section {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 20;
            background: white;
        }
    }
        @media (max-width: 768px) {
        .job-cards {
            grid-template-columns: 1fr;
        }

        .job-card-footer {
            flex-direction: column;
            gap: 0.5rem;
        }

        .job-action {
            width: 100%;
        }
    }
</style>

@section('page_content')

    <div class="jobs-container">
        <button class="filter-toggle" id="filterToggle">
            <i class="fas fa-filter"></i>
            <span>Ֆիլտր</span>
        </button>
<div class="filter-section" id="filterSection">
            <div class="filter-content">
                <h5><i class="fas fa-filter"></i>ֆիլտրում</h5>
                <div class="filter-group">
                    <label for="filter_job_title">Աշխատանքի անվանում</label>
                    <input type="text" id="filter_job_title" class="filter-control" placeholder="Որոնել ըստ անվանման">
                </div>
                <div class="filter-group">
                    <label for="filter_employee_level">Աշխատողի մակարդակ</label>
                    <select id="filter_employee_level" class="filter-control">
                        <option value="">Բոլոր մակարդակները</option>
                        <option value="1">1 — Սկսնակ</option>
                        <option value="2">2 — Միջին</option>
                        <option value="3">3 — Ավագ</option>
                        <option value="4">4 — Չնշված</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filter_work_experience">Աշխատանքային փորձ (տարի)</label>
                    <input type="number" id="filter_work_experience" class="filter-control" min="0" max="50" placeholder="0">
                </div>

                <div class="filter-group">
                    <label for="filter_work_hours">Աշխատանքային ժամեր (օրական)</label>
                    <input type="number" id="filter_work_hours" class="filter-control" min="0" max="24" placeholder="0">
                </div>

                <div class="filter-group">
                    <label for="filter_work_format">Աշխատանքի ձևաչափ</label>
                    <select id="filter_work_format" class="filter-control">
                        <option value="">Բոլոր ձևաչափերը</option>
                        <option value="1">1 — Հեռավար</option>
                        <option value="2">2 — Աշխ. վայրում</option>
                        <option value="3">3 — Հիբրիդ</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filter_sort">Դասավորել ըստ</label>
                    <select id="filter_sort" class="filter-control">
                        <option value="newest">Նոր հայտարարությունների</option>
                        <option value="oldest">Հին հայտարարությունների</option>
                    </select>
                </div>

                <div class="filter-actions mt-3">
                    <button id="filter_btn" class="btn-filter btn-primary">
                        <i class="fas fa-search"></i> Ֆիլտրել
                    </button>
                    <button id="clear_filters" class="btn-filter btn-secondary mt-2">
                        <i class="fas fa-broom"></i> Մաքրել ֆիլտրերը
                    </button>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="results-section">
            <div class="job-cards" id="cards_parent">
                <!-- Job cards will be inserted here dynamically -->
            </div>
            <div id="empty-state" class="empty-state" style="display: none;">
                <i class="fas fa-briefcase"></i>
                <h4>Հայտարարություններ չեն գտնվել</h4>
                <p>Դուք չունեք Հայտարարություններ</p>
            </div>
        </div>
    </div>

    <div class="loading-overlay" id="loading-spinner" style="display: none;">
        <div class="spinner-container">
            <div class="dots-loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="loading-text">Բեռնվում է...</div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ջնջման հաստատում</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Դուք համոզվա՞ծ եք, որ ցանկանում եք ջնջել այս հայտարարությունը։ Այս գործողությունը հնարավոր չէ հետ շրջել։
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Չեղարկել</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Հաստատել ջնջումը</button>
                </div>
            </div>
        </div>
    </div>

    <div id="alertPlaceholder"></div>
@endsection

@section('page_script')
    <script>
        const cardsParent = $("#cards_parent");
        const loadingSpinner = $('#loading-spinner');
        const emptyState = $('#empty-state');
        const alertPlaceholder = $('#alertPlaceholder');
        let deleteJobId = null;
        let deleteModal = null;
        function renderJobs(jobs, levels = {}, formats = {}, paginationHTML = '') {
            cardsParent.empty();

            if (!jobs || jobs.length === 0) {
                emptyState.show();
                return;
            }

            emptyState.hide();

            jobs.forEach((job, index) => {
                const jobCard = $(`
                <div class="job-card" data-id="${job.id}" style="--delay: ${index}">
                    <div class="job-card-header">
                        <h4>${job.job_title}</h4>
                    </div>
                    <div class="job-card-body">
                        <div class="job-meta">
                            <div class="job-meta-item">
                                <i class="fas fa-layer-group"></i>
                                <span>Մակարդակ: ${levels[job.employee_level] || job.employee_level}</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="fas fa-briefcase"></i>
                                <span>Փորձ: ${job.work_experience || 0} տարի</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="fas fa-clock"></i>
                                <span>Ժամեր: ${job.working_hours || 0} ժամ</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="fas fa-laptop-house"></i>
                                <span>Ձևաչափ: ${formats[job.work_format] || job.work_format}</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-card-footer">
                        <a href="/jobs/${job.id}/show" class="job-action action-view">
                            <i class="fas fa-eye"></i> Դիտել
                        </a>
                        <a href="/jobs/${job.id}/edit" class="job-action action-edit">
                            <i class="fas fa-edit"></i> Խմբագրել
                        </a>
                        <button class="job-action action-delete delete-btn" data-id="${job.id}">
                            <i class="fas fa-trash"></i> Ջնջել
                        </button>
                    </div>
                </div>
            `);
                cardsParent.append(jobCard);
            });

            if (paginationHTML) {
                cardsParent.append(`
                <div class="pagination-container" style="width: 100%; margin-top: 20px; display: flex; justify-content: center;">
                    ${paginationHTML}
                </div>
            `);
            }
        }
        function showAlert(message, type = 'success') {
            const wrapper = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
            alertPlaceholder.append(wrapper);

            setTimeout(() => {
                $(wrapper).fadeOut(400, () => wrapper.remove());
            }, 3000);
        }
        function loadMyJobs(filters = {}) {
            loadingSpinner.fadeIn(300);
            cardsParent.css('opacity', '0.7');
            filters.creator_id = {{ auth()->id() }};
            $.ajax({
                url: '/jobs/filter',
                method: 'GET',
                data: filters,
                success: function(data) {
                    renderJobs(data.jobs, data.levels, data.formats, data.links);
                },
                error: function(xhr) {
                    console.error("Filter error:", xhr.responseText);
                    showAlert('Ֆիլտրման սխալ։ Խնդրում ենք փորձել ավելի ուշ։', 'danger');
                },
                complete: function() {
                    loadingSpinner.fadeOut(300);
                    cardsParent.css('opacity', '1');
                }
            });
        }
        function restoreFilters() {
            const savedFilters = localStorage.getItem('myJobsFilters');
            if (savedFilters) {
                try {
                    const filters = JSON.parse(savedFilters);
                    $('#filter_job_title').val(filters.job_title || '');
                    $('#filter_employee_level').val(filters.employee_level || '');
                    $('#filter_work_experience').val(filters.work_experience || '');
                    $('#filter_work_hours').val(filters.working_hours || '');
                    $('#filter_work_format').val(filters.work_format || '');
                    $('#filter_sort').val(filters.sort || 'newest');
                    return filters;
                } catch (e) {
                    localStorage.removeItem('myJobsFilters');
                }
            }
            return null;
        }
        $(document).ready(function () {
            deleteModal = new bootstrap.Modal('#deleteConfirmModal');
            $('#filterToggle').on('click', function() {
                const $filterSection = $('#filterSection');
                const $toggleBtn = $(this);
                $filterSection.toggleClass('collapsed');
                $toggleBtn.toggleClass('collapsed');
                localStorage.setItem('filterCollapsed', $filterSection.hasClass('collapsed'));
            });
            if (localStorage.getItem('filterCollapsed') === 'true') {
                $('#filterSection').addClass('collapsed');
                $('#filterToggle').addClass('collapsed');
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
                localStorage.setItem('myJobsFilters', JSON.stringify(filters));
                loadMyJobs(filters);
            });
            $('#clear_filters').on('click', function() {
                $('.filter-control').val('');
                $('#filter_sort').val('newest');
                loadMyJobs({ sort: 'newest' });
                localStorage.removeItem('myJobsFilters');
            });
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const page = url.match(/page=(\d+)/)?.[1];

                const filters = {
                    job_title: $('#filter_job_title').val(),
                    employee_level: $('#filter_employee_level').val(),
                    work_experience: $('#filter_work_experience').val(),
                    working_hours: $('#filter_work_hours').val(),
                    work_format: $('#filter_work_format').val(),
                    sort: $('#filter_sort').val(),
                    creator_id: {{ auth()->id() }},
                    page: page
                };
                loadMyJobs(filters);
            });
            const savedFilters = restoreFilters();
            if (savedFilters) {
                loadMyJobs(savedFilters);
            } else {
                loadMyJobs({ sort: 'newest' });
            }
        });
    </script>@endsection
