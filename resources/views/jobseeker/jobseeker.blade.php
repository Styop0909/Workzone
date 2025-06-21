@extends('layouts.app')

@section('page_title')
    Job Search
@endsection

<style>
    body {
        overflow-x: hidden;
        overflow-y: auto;
    }
    .small{
        display: none;
    }
    .box {
        display: flex;
        justify-content: space-between;
        min-height: 600px;
        gap: 1.5rem;
        align-items: flex-start;
        padding: 1rem;
    }

    /* Updated Filter Section - Matching first file's design */
    .job-filter {
        position: sticky;
        top: 1rem;
        width: 500px;
        padding: 1.5rem;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        z-index: 10;
        opacity: 0;
        transform: translateY(10px);
        animation: filterSlideIn 0.5s 0.2s forwards;
    }

    @keyframes filterSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .job-filter:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
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

    .filter-group {
        margin-bottom: 1.25rem;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #4a5568;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .filter-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background-color: rgba(248, 250, 252, 0.8);
    }

    .filter-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        outline: none;
        background-color: white;
        transform: translateY(-1px);
    }

    .filter-control:hover {
        border-color: #c3dafe;
    }

    /* Buttons */
    .btn-filter {
        width: 100%;
        padding: 0.8rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4299e1, #3182ce);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(66, 153, 225, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #3182ce, #2b6cb0);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(66, 153, 225, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #718096, #4a5568);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(113, 128, 150, 0.2);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #4a5568, #2d3748);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(113, 128, 150, 0.3);
    }

    /* Rest of your existing styles... */
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
        font-size: 0.8rem;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-container ul {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination-container a,
    .pagination-container span {
        padding: 0.5rem 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        color: #4299e1;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination-container a:hover {
        background-color: #ebf8ff;
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
        <div class="job-filter border p-3" style="max-height: 820px">
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

        <div id="cards_parent"></div>
    </div>

    <!-- Ջնջման Modal -->
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
        function renderJobs(jobs, levelMap = {}, formatMap = {}, paginationHTML = '') {
            const cardsParent = $("#cards_parent");
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
                const experience = job.work_experience ?? 0;
                const hours = job.working_hours ?? 0;

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
                    ${(job.job_creator_id == currentUserId || currentUserRole === "1") ? `
                        <button type="button" class="btn btn-danger delete-btn" data-id="${job.id}">
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

            if (paginationHTML) {
                cardsParent.append(`
            <div class="pagination-container" style="width: 100%; text-align: center; margin-top: 1rem;">
                ${paginationHTML}
            </div>
        `);
            }
        }

        const currentUserId = {{ auth()->id() }};
        const currentUserRole = "{{ auth()->user()->user_role }}";

        $(document).ready(function () {
            const cardsParent = $("#cards_parent");
            const alertPlaceholder = $('#alertPlaceholder');
            const deleteModalEl = document.getElementById('deleteConfirmModal');
            const deleteModal = new bootstrap.Modal(deleteModalEl);
            let deleteJobId = null;
            let searchTimeout;

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

            function performSearch(searchText) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    cardsParent.css('opacity', '0.5');

                    $.ajax({
                        url: '/jobs/autosearch',
                        method: 'GET',
                        data: { search: searchText },
                        success: function(data) {
                            renderJobs(data.jobs, data.levels, data.formats, data.links);
                            const queryString = new URLSearchParams();
                            if (searchText) queryString.append('job_title', searchText);
                            history.replaceState(null, null, `?${queryString.toString()}`);
                        },
                        complete: function() {
                            cardsParent.css('opacity', '1');
                        }
                    });
                }, 500);
            }

            $('#job_search_input').on('input', function() {
                const searchText = $(this).val().trim();
                $('#filter_job_title').val(searchText);
                performSearch(searchText);
            });

            $('#filter_job_title').on('input', function() {
                const searchText = $(this).val().trim();
                $('#job_search_input').val(searchText);
                performSearch(searchText);
            });

            const urlParams = new URLSearchParams(window.location.search);
            const initialSearch = urlParams.get('job_title') || '';

            if (initialSearch) {
                $('#filter_job_title').val(initialSearch);
                $('#job_search_input').val(initialSearch);
                performSearch(initialSearch);
            } else {
                performSearch('');
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
                loadJobsWithAllFilters(filters);
            });

            function loadJobsWithAllFilters(filters = {}) {
                cardsParent.css('opacity', '0.5');

                $.ajax({
                    url: '/jobs/filter',
                    method: 'GET',
                    data: filters,
                    success: function(data) {
                        renderJobs(data.jobs, data.levels, data.formats);
                    },
                    complete: function() {
                        cardsParent.css('opacity', '1');
                    }
                });
            }

            $('#clear_filters').on('click', function() {
                $('.job-filter input').val('');
                $('.job-filter select').val('');
                localStorage.removeItem('jobFilters');
                performSearch('');
            });
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (!url) return;

            $('#cards_parent').css('opacity', '0.5');

            $.get(url, function(data) {
                renderJobs(data.jobs, data.levels, data.formats, data.links);
            }).always(() => {
                $('#cards_parent').css('opacity', '1');
            });
        });
    </script>
@endsection
