@extends("layouts.app")

@section("page_title")
    Աշխատանք ավելացնել
@endsection

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

    .alert-message {
        margin-top: 24px;
        padding: 18px 25px;
        border-radius: 18px;
        font-weight: 600;
        font-size: 1rem;
        display: none;
        user-select: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        line-height: 1.3;
        text-align: center;
        max-width: 100%;
    }

    .alert-success {
        background: #2e7d32;
        color: #d7f4e3;
    }

    .alert-error {
        background: #b71c1c;
        color: #ffdfdf;
    }

</style>

@section("page_content")
    <form id="formContent">
        @csrf
        <div class="mb-3">
            <label for="job_title" class="form-label">Պաշտոն</label>
            <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Օրինակ՝ Frontend Developer">
        </div>

        <div class="mb-3">
            <label for="employee_level" class="form-label">Աշխատակցի մակարդակ</label>
            <select class="form-control" id="employee_level" name="employee_level">
                <option value="" selected disabled>Ընտրել մակարդակ</option>
                <option value="1">Սկսնակ</option>
                <option value="2">Միջին</option>
                <option value="3">Ավագ</option>
                <option value="4">Չնշված</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="work_experience" class="form-label">Աշխատանքային փորձ (տարի)</label>
            <input type="number" class="form-control" id="work_experience" name="work_experience" placeholder="Օրինակ՝ 2">
        </div>

        <div class="mb-3">
            <label for="working_hours" class="form-label">Աշխատանքային ժամեր</label>
            <input type="number" class="form-control" id="working_hours" name="working_hours" placeholder="Օրինակ՝ 8">
        </div>

        <div class="mb-3">
            <label for="work_format" class="form-label">Աշխատանքային ձևաչափ</label>
            <select class="form-control" id="work_format" name="work_format">
                <option value="" selected disabled>Ընտրել ձևաչափ</option>
                <option value="1">Հեռավար</option>
                <option value="2">Վայրում</option>
                <option value="3">Հիբրիդ</option>
            </select>
        </div>

        <button class="btn-submit" type="submit">Ավելացնել</button>

        <div id="success-message" class="alert-message alert-success"></div>
        <div id="error-message" class="alert-message alert-error"></div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showAlert(message, type = 'success') {
            const alertDiv = $('#' + (type === 'success' ? 'success-message' : 'error-message'));
            alertDiv.text(message).slideDown();

            setTimeout(() => {
                alertDiv.slideUp();
            }, 4000);
        }

        $('#formContent').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route("add_new_job") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        $('#formContent')[0].reset();
                    } else {
                        showAlert(response.message || 'Սխալ տեղի ունեցավ', 'error');
                    }
                },
                error: function(xhr) {
                    showAlert('Խնդրում ենք ճիշտ լրացնել բոլոր դաշտերը։', 'error');
                }
            });
        });
    </script>
@endsection
