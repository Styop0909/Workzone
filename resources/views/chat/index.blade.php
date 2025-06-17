@extends('layouts.app')

@section("page_title")
    Chat

@endsection

<style>
    .container {
        max-width: 720px;
        margin: -30px auto 30px;
        padding: 0 20px;
    }

    #chat3 .form-control {
        border-color: transparent;
    }

    #chat3 .form-control:focus {
        border-color: transparent;
        box-shadow: inset 0px 0px 0px 1px transparent;
    }

    .badge-dot {
        border-radius: 50%;
        height: 10px;
        width: 10px;
        margin-left: 2.9rem;
        margin-top: -.75rem;
    }
    #chat_messages {
        height: 400px;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

</style>

@section('page_content')

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="chat3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0" style="border-right: 2px solid #dee2e6;">
                                <div class="p-3">
                                    <div class="input-group rounded mb-3">
                                        <input id="chatSearch" type="search" class="form-control rounded" placeholder="Search">
                                        <span class="input-group-text border-0" id="search-addon">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <div style="height: 400px; overflow: auto;">
                                        <ul id="all_chat" class="list-unstyled mb-0"></ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-7 col-xl-8">
                                <div id="chat_messages" class="pt-3 pe-3" style="height: 400px;overflow-y: auto"></div>

                                <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=cccccc&color=ffffff"
                                         alt="avatar" style="width: 40px;">
                                    <input type="text" class="form-control form-control-lg mx-2" id="exampleFormControlInput2"  placeholder="Type message">
                                    <a class="ms-1 text-muted" href="#" data-bs-toggle="modal" data-bs-target="#fileUploadModal">
                                        <i class="fas fa-paperclip"></i>
                                    </a>
                                    <a class="ms-3 text-muted" href="#" id="emojiBtn"><i class="fas fa-smile"></i></a>
                                    <a class="ms-3" href="#" id="sendBtn"><i class="fas fa-paper-plane"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="fileUploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileUploadModalLabel">Կցել ֆայլ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Փակել"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ուղարկել</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section("page_script")
    <script type="module">
        import { EmojiButton } from "https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js";

        const picker = new EmojiButton();
        const trigger = document.querySelector('.fa-smile');
        const inputField = document.getElementById('exampleFormControlInput2');

        picker.on('emoji', selection => {
            inputField.value += selection.emoji;
            inputField.focus();
        });

        trigger.addEventListener('click', () => picker.togglePicker(trigger));
        const parts = window.location.pathname.split('/');
        const receiverId = parts[2];
        $.ajax({
            url: `/chat/${receiverId}`,
            method: 'GET',
            success: function (data) {
                $('#messages_container').html(data.html);
            }
        });
        const currentUserName = @json(auth()->user()->name);
        const currentUserId = {{ auth()->id() }};

        function getTimeSince(dateString) {
            const inputDate = new Date(dateString + 'Z');
            const now = new Date();
            const diffMilliseconds = now - inputDate;
            if (diffMilliseconds < 0) return "Future date";
            const diffSeconds = Math.floor(diffMilliseconds / 1000);
            const diffMinutes = Math.floor(diffSeconds / 60);
            const diffHours = Math.floor(diffMinutes / 60);
            const diffDays = Math.floor(diffHours / 24);
            if (diffDays > 0) return `${diffDays} day(s) ago`;
            else if (diffHours > 0) return `${diffHours} hour(s) ago`;
            else if (diffMinutes > 0) return `${diffMinutes} min(s) ago`;
            else return `${diffSeconds} sec(s) ago`
        }

        function truncateText(text, maxLength = 20) {
            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        }

        function get_all_chat() {
            let all_chat = $("#all_chat");
            all_chat.empty();
            $.ajax({
                url: "{{ route('get_all_chat') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    for (let chat of data) {
                        let short_message;
                        if (chat.is_file) {
                            short_message = "file was send";
                        } else {
                            short_message = truncateText(chat.message,15);
                        }

                        let chat_json = JSON.stringify(chat);
                        const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(chat.receiver_name)}&background=cccccc&color=ffffff`;
                        all_chat.append(`
                    <li class="p-2 border-bottom chat-item" data-chat='${chat_json}'>
                        <a href="#!" class="d-flex justify-content-between">
                            <div class="d-flex flex-row">
                                <div>
                                    <img src="${avatarUrl}" class="d-flex align-self-center me-3" width="65" style="border-radius: 50%">
                                    <span class="badge bg-warning badge-dot"></span>
                                </div>
                                <div class="pt-1">
                                    <p class="fw-bold mb-0">${truncateText(chat.receiver_name,10)}</p>
                                    <p class="small text-muted">${short_message}</p>
                                </div>
                            </div>
                            <div class="pt-1">
                                <p class="small text-muted mb-1">${getTimeSince(chat.created_at)}</p>
                            </div>
                        </a>
                    </li>
                `);
                    }
                },
                error: function(err) {
                    console.error("Error fetching chats", err);
                }
            });
        }

        const scrollThreshold = 200;

        function loadMessages(userId) {
            const chatContainer = $('#chat_messages');

            chatContainer.html(`
        <div class="d-flex justify-content-center align-items-center" style="height: 100px;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);
            const oldScrollTop = chatContainer.scrollTop();
            const oldScrollHeight = chatContainer[0].scrollHeight;
            const containerHeight = chatContainer.innerHeight();
            $.ajax({
                url: "{{ route('get_messages') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: userId
                },
                success: function(data) {
                    chatContainer.empty();

                    for (let msg of data) {


                        const isMine = msg.sender_id === currentUserId;
                        const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(isMine ? currentUserName : msg.sender_name)}&background=cccccc&color=ffffff`;
                        const timeAgo = getTimeSince(msg.created_at);

                        let messageContent = '';
                        if (msg.is_file == '1' || msg.is_file === 1 || msg.is_file === true) {
                            const fileName = msg.filename || 'file';
                            const filePath = msg.file_path || '';
                            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                            const ext = fileName.split('.').pop().toLowerCase();
                            if (imageExtensions.includes(ext)) {
                                messageContent = `
                            <p class="mb-1">
                                <a href="${filePath}" target="_blank">
                                    <img src="${filePath}" alt="${fileName}" style="max-width:150px; max-height:150px; border-radius: 10px;"/>
                                </a>
                            </p>
                        `;
                            } else {
                                messageContent = `<p class="mb-1"><a href="${filePath}" target="_blank">📎 ${fileName}</a></p>`;
                            }
                        } else {
                            messageContent = `<p class="mb-1">${msg.message}</p>`;
                        }

                        chatContainer.append(`
                    <div class="d-flex align-items-end mb-3 ${isMine ? 'justify-content-end' : 'justify-content-start'}">
                        ${!isMine ? `<img src="${avatarUrl}" class="rounded-circle me-2" width="40" alt="avatar">` : ''}
                        <div style="max-width: 70%; padding: 10px 15px; border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); background-color: ${isMine ? '#0d6efd' : '#f1f1f1'}; color: ${isMine ? 'white' : 'black'};">
                            ${messageContent}
                            <small style="font-size: 0.75rem;">${timeAgo}</small>
                        </div>
                        ${isMine ? `<img src="${avatarUrl}" class="rounded-circle ms-2" width="40" alt="avatar">` : ''}
                    </div>
                `);
                    }

                    const newScrollHeight = chatContainer[0].scrollHeight;
                    const distanceFromBottom = oldScrollHeight - (oldScrollTop + containerHeight);

                    if (distanceFromBottom < scrollThreshold) {
                        chatContainer.scrollTop(newScrollHeight);
                    } else {
                        chatContainer.scrollTop(oldScrollTop + (newScrollHeight - oldScrollHeight));
                    }
                },
                error: function(err) {
                    console.error("Error loading messages", err);
                }
            });
        }

        $(document).ready(function () {
            const chatContainer = $('#chat_messages');

            let savedScroll = localStorage.getItem('chatScrollPos');

            if (savedScroll !== null) {
                chatContainer.scrollTop(parseInt(savedScroll, 10));
            } else {
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }

            chatContainer.on('scroll', function() {
                localStorage.setItem('chatScrollPos', $(this).scrollTop());
            });
        });




        $(document).on("click", ".chat-item a", function(e) {
            e.preventDefault();
            const userId = $(this).closest('li.chat-item').data('chat').receiver_id;
            loadMessages(userId);
            history.pushState({ userId: userId }, '', `/chat/${userId}`);
        });
        window.addEventListener('popstate', function(event) {
            if (event.state && event.state.userId) {
                loadMessages(event.state.userId);
            } else {
                $('#chat_messages').empty();
            }
        });

        $(document).ready(function () {

            get_all_chat();

            let currentChatUserId = null;

            $('#chatSearch').on('keyup', function () {
                const value = $(this).val().toLowerCase();
                $('#all_chat li').filter(function () {
                    $(this).toggle(
                        $(this).find('p.fw-bold').text().toLowerCase().indexOf(value) > -1
                    );
                });
            });

            $(document).on('click', '.chat-item', function () {
                const chat = $(this).data('chat');
                currentChatUserId = chat.receiver_id;
                loadMessages(currentChatUserId);
            });

            if (receiverId && !isNaN(receiverId)) {
                currentChatUserId = parseInt(receiverId);
                loadMessages(currentChatUserId);
            }

            $('#sendBtn').on('click', function () {
                const input = $('#exampleFormControlInput2');
                const message = input.val().trim();

                if (!message) return alert("Խնդրում ենք գրեք հաղորդագրություն։");
                if (!currentChatUserId) return alert("Ընտրեք օգտատիրոջը՝ հաղորդագրություն ուղարկելու համար։");

                $.ajax({
                    url: "{{ route('send_message') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        receiver_id: currentChatUserId,
                        message: message,
                    },
                    success: function (response) {
                        if (response.success) {
                            loadMessages(currentChatUserId);
                            get_all_chat();
                            input.val('');
                        } else {
                            alert("Չհաջողվեց ուղարկել նամակը։");
                        }
                    },
                    error: function () {
                        alert("Սխալ տեղի ունեցավ հաղորդագրությունը ուղարկելիս։");
                    }
                });
            });

            $('#fileUploadForm').on('submit', function(e) {
                e.preventDefault();

                if (!currentChatUserId) return alert("Ընտրեք օգտատիրոջը՝ ֆայլ ուղարկելու համար։");

                let formData = new FormData(this);
                formData.append("receiver_id", currentChatUserId);
                formData.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('send_file_message') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            loadMessages(currentChatUserId);
                            get_all_chat();
                            $('#fileUploadModal').modal('hide');
                            $('#fileUploadForm')[0].reset();
                        } else {
                            alert("Չհաջողվեց ուղարկել ֆայլը։");
                        }
                    },
                    error: function() {
                        alert("Սխալ տեղի ունեցավ ֆայլը ուղարկելիս։");
                    }
                });
            });
        });
    </script>
@endsection
