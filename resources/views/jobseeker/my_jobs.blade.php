@extends('layouts.app')

@section('page_title', 'Իմ հայտարարությունները')

<style>
    /* Main Container */
    .jobs-container {
        display: flex;
        gap: 1.5rem;
        min-height: calc(100vh - 120px);
        padding: 1.5rem 0;
        position: relative;
    }

    /* Filter Section */
    .filter-section {
        position: sticky;
        top: 1rem;
        width: 380px;
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

    .filter-section:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .filter-section h5 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        font-size: 1.3rem;
        position: relative;
    }

    .filter-section h5::after {
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

    .filter-section:hover h5::after {
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

    /* Results Section */
    .results-section {
        flex: 1;
        opacity: 0;
        transform: translateY(10px);
        animation: contentFadeIn 0.5s 0.4s forwards;
    }

    @keyframes contentFadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .job-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    /* Job Card */
    .job-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
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
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    .job-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(237, 242, 247, 0.8);
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
        color: #4a5568;
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
        background-color: rgba(248, 250, 252, 0.8);
        border-top: 1px solid rgba(237, 242, 247, 0.8);
        transition: all 0.3s ease;
    }

    .job-card:hover .job-card-footer {
        background-color: rgba(226, 232, 240, 0.8);
    }

    .job-action {
        flex: 1;
        text-align: center;
        padding: 0.6rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .job-action:hover {
        transform: translateY(-2px);
    }

    .action-view {
        color: #4299e1;
    }

    .action-view:hover {
        background-color: rgba(66, 153, 225, 0.1);
    }

    .action-edit {
        color: #d69e2e;
    }

    .action-edit:hover {
        background-color: rgba(214, 158, 46, 0.1);
    }

    .action-delete {
        color: #f56565;
    }

    .action-delete:hover {
        background-color: rgba(245, 101, 101, 0.1);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(8px);
        transition: opacity 0.4s ease;
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

    .loading-text {
        margin-top: 15px;
        font-size: 1.1rem;
        color: #4a5568;
        font-weight: 500;
        text-align: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        width: 100%;
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

    /* Responsive */
    @media (max-width: 1200px) {
        .jobs-container {
            flex-direction: column;
        }

        .filter-section {
            position: static;
            width: 100%;
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
        <!-- Filter Section -->
        <div class="filter-section">
            <h5><i class="fas fa-filter"></i> Իմ հայտարարությունների ֆիլտրում</h5>

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

        <!-- Results Section -->
        <div class="results-section">
            <div class="job-cards" id="cards_parent">
                <!-- Job cards will be inserted here dynamically -->
            </div>

            <div id="empty-state" class="empty-state" style="display: none;">
                <i class="fas fa-briefcase"></i>
                <h4>Հայտարարություններ չեն գտնվել</h4>
                <p>Փորձեք փոխել ձեր ֆիլտրերը</p>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->


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

    <!-- Alert Notifications -->
    <div id="alertPlaceholder" style="position: fixed; top: 1rem; right: 1rem; z-index: 1055; min-width: 300px;"></div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function () {
            const cardsParent = $("#cards_parent");
            const loadingSpinner = $('#loading-spinner');
            const emptyState = $('#empty-state');
            const alertPlaceholder = $('#alertPlaceholder');
            const deleteModal = new bootstrap.Modal('#deleteConfirmModal');
            let deleteJobId = null;

            function showAlert(message, type = 'success') {
                const wrapper = $(`
                <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
                alertPlaceholder.append(wrapper);

                // Smooth fade out
                setTimeout(() => {
                    $(wrapper).fadeOut(400, () => wrapper.remove());
                }, 3000);
            }

            function renderJobs(jobs, levels = {}, formats = {}) {
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
            }

            function loadMyJobs(filters = {}) {
                loadingSpinner.fadeIn(300);
                cardsParent.css('opacity', '0.7');

                // Սահմանել timeout (օրինակ 10 վայրկյան)
                const timeout = setTimeout(() => {
                    loadingSpinner.fadeOut(300);
                    cardsParent.css('opacity', '1');
                    showAlert('Բեռնումը ժամանակավորապես խափանված է։ Խնդրում ենք փորձել ավելի ուշ։', 'warning');
                }, 10000); // 10000 միլիվայրկյան = 10 վայրկյան

                // Միշտ ֆիլտրել ըստ ընթացիկ օգտատիրոջ
                filters.creator_id = {{ auth()->id() }};

                $.ajax({
                    url: '/jobs/filter',
                    method: 'GET',
                    data: filters,
                    success: function(data) {
                        clearTimeout(timeout); // Մաքրել timeout-ը, եթե տվյալները հաջողությամբ բեռնվել են
                        if (data.jobs && data.jobs.length > 0) {
                            if (filters.sort === 'oldest') {
                                data.jobs.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                            } else {
                                // Լռելյայն՝ նորերը առաջինը
                                data.jobs.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                            }
                            renderJobs(data.jobs, data.levels, data.formats);
                        } else {
                            renderJobs([]);
                        }
                    },
                    error: function(xhr) {
                        clearTimeout(timeout); // Մաքրել timeout-ը սխալի դեպքում
                        console.error("Filter error:", xhr.responseText);
                        showAlert('Ֆիլտրման սխալ։ Խնդրում ենք փորձել ավելի ուշ։', 'danger');
                    },
                    complete: function() {
                        loadingSpinner.fadeOut(300);
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
                localStorage.setItem('myJobsFilters', JSON.stringify(filters));
                loadMyJobs(filters);
            });

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

            const savedFilters = restoreFilters();
            if (savedFilters) {
                loadMyJobs(savedFilters);
            } else {
                loadMyJobs({ sort: 'newest' });
            }

            $('#clear_filters').on('click', function() {
                $('.filter-control').val('');
                $('#filter_sort').val('newest');
                loadMyJobs({ sort: 'newest' });
                localStorage.removeItem('myJobsFilters');
            });
        });
    </script>
@endsection
