
@extends('layouts/contentLayoutMaster')

@section('title', 'Chat Application')

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection

@section('content-sidebar')
@include('pages/consumers/chat/app-chat-sidebar')
@endsection

@section('content')
<div class="body-content-overlay"></div>
<!-- Main chat area -->
<section class="chat-app-window">
  <!-- To load Conversation -->
  <div class="start-chat-area" style="background: transparent">
    <div class="mb-1 start-chat-icon">
      <i data-feather="message-square"></i>
    </div>
    <h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>
  </div>
  <!--/ To load Conversation -->

  <!-- Active Chat -->
  <div class="active-chat d-none">
    <!-- Chat Header -->
    <div class="chat-navbar">
      <header class="chat-header">
      </header>
    </div>
    <!--/ Chat Header -->

    <!-- User Chat messages -->
    <div class="user-chats" style="background: transparent">
      <div class="chats">

      </div>
    </div>
    <!-- User Chat messages -->

    <!-- Submit Chat form -->
    <form class="chat-app-form" action="javascript:void(0);" onsubmit="sendChat();">
      <div class="input-group input-group-merge me-1 form-send-message">
        <span class="speech-to-text input-group-text"><i data-feather="mic" class="cursor-pointer"></i></span>
        <input type="text" class="form-control message" placeholder="Type your message or use speech to text" />
        <span class="input-group-text">
          <label for="attach-doc" class="attachment-icon form-label mb-0">
            <i data-feather="image" class="cursor-pointer text-secondary"></i>
            <input type="file" id="attach-doc" hidden /> </label
        ></span>
      </div>
      <button type="button" class="btn btn-primary send" onclick="sendChat();">
        <i data-feather="send" class="d-lg-none"></i>
        <span class="d-none d-lg-block">Send</span>
      </button>
    </form>
    <!--/ Submit Chat form -->
  </div>
  <!--/ Active Chat -->
</section>
<!--/ Main chat area -->
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/pages/app-chat.js')) }}"></script>
<script>
    let currentUser = ""
    function loadAdminUser() {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.chat.users.admin') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}",
                user_id: "{{ isset($user) ? $user->id : '' }}",
            },
            success: function(result) {
                let user = result[0]
                $(`.chat-application .chat-user-list-wrapper ul li.li-user`).remove();
                $('.chat-list').append(
                    `<li class="li-user li-user-chat" style="align-items:center" data-id="${user.id}" data-type="chat">
                        <span class="avatar" style="width:32px; height:32px">
                            <div class="avatar" style="background-color: #${user.avatar.color}; width:32px; height:32px">
                                <div class="avatar-content">${user.avatar.name}</div>
                            </div>
                        </span>
                        <div class="chat-info flex-grow-1">
                        <h5 class="mb-0">${user.name}</h5>
                        <p class="card-text text-truncate">
                            ${user.msg}
                        </p>
                        </div>
                        <div class="chat-meta text-nowrap">
                        <small class="float-end mb-25 chat-time chat-time-text-small">${user.date}</small>
                        <span class="badge bg-danger rounded-pill float-end">${user.count > 0 ? user.count : ''}</span>
                        </div>
                    </li>`
                )
                if (currentUser)
                    $(`.chat-application .chat-user-list-wrapper ul li[data-id=${currentUser}][data-type="chat"]`).addClass('active')
            }
        })
    }
    function sendChat(source) {
        var message = $('.message').val();
        $('.message').val('');
        if (/\S/.test(message)) {
            $.ajax({
                type: 'POST',
                url: "{{ route('api.chat.send') }}",
                data: {
                    company_id: "{{ isset($company) ? $company->id : '' }}",
                    target: "{{ isset($user) ? $user->id : '' }}",
                    to: 1,
                    message: message
                },
                success: function(result) {
                    $('.user-chats').scrollTop($('.user-chats > .chats').height());
                }
            })
        }
    }
    $('.chat-application .chat-user-list-wrapper').on('click', 'ul li', function() {
        currentUser = $(this).data('id')
        currentUserType = $(this).data('type')
        $.ajax({
            type: 'GET',
            url: "{{ route('api.chat.messages') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}",
                target: "{{ isset($user) ? $user->id : '' }}",
            },
            success: function(result) {
                let msgHtml = '';
                lastSide = '';
                for(const [key, msgDateGroup] of Object.entries(result.message)) {
                    msgDateGroup.forEach(msgUserGroup => {
                        if (!msgUserGroup[0].to) {
                            msgHtml += `
                            <div class="chat chat-left">
                                <div class="chat-avatar">
                                    <div class="avatar" style="background-color: #${result.avatarC.color}">
                                        <div class="avatar-content">${result.avatarC.name}</div>
                                    </div>
                                </div>
                                <div class="chat-body">
                                    ${msgUserGroup.map(msg =>
                                        `<div class="chat-content">
                                            <p>${msg.message}</p>
                                        </div>`
                                    ).join('')}
                                </div>
                            </div>
                            `
                        } else {
                            msgHtml += `
                            <div class="chat">
                                <div class="chat-avatar">
                                    <div class="avatar" style="background-color: #${result.avatarU.color}">
                                        <div class="avatar-content">${result.avatarU.name}</div>
                                    </div>
                                </div>
                                <div class="chat-body">
                                    ${msgUserGroup.map(msg =>
                                        `<div class="chat-content">
                                            <p>${msg.message}</p>
                                        </div>`
                                    ).join('')}
                                </div>
                            </div>
                            `
                        }
                        lastSide = msgUserGroup[0].to
                    })
                }
                $('.chats').html(msgHtml);
                const chatWrapperHeight = $('.user-chats').height()
                const chatListHeight = $('.user-chats > .chats').height()
                if (chatListHeight > chatWrapperHeight)
                    $('.user-chats').scrollTop($('.user-chats > .chats').height());
                else
                    $('.user-chats').scrollTop(0);
            }
        })
        $.ajax({
            type: 'POST',
            url: "{{ route('api.chat.read') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}",
                target: "{{ isset($user) ? $user->id : '' }}",
                to: 0
            }
        })
    })
    var pusher = new Pusher('fac85360afc52d12009f', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('chat-channel');
    channel.bind('chat-event', function(data) {
        const message = data.message
        if (message.company_id === {{ $company->id }} && message.target == {{ $user->id }}) {
            if (message.to) {
                if (message.to === lastSide) {
                    const lastChatBlock = $('.chat').last()
                    $(lastChatBlock).find('.chat-body').append(`
                        <div class="chat-content">
                            <p>${message.message}</p>
                        </div>
                    `)
                } else {
                    $('.chats').append(`
                        <div class="chat">
                            <div class="chat-avatar">
                                <div class="avatar" style="background-color: #${data.avatar.color}">
                                    <div class="avatar-content">${data.avatar.name}</div>
                                </div>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>${message.message}</p>
                                </div>
                            </div>
                        </div>
                    `)
                }
            } else { // admin message
                if (message.to === lastSide) {
                    const lastChatBlock = $('.chat').last()
                    $(lastChatBlock).find('.chat-body').append(`
                        <div class="chat-content">
                            <p>${message.message}</p>
                        </div>
                    `)
                } else {
                    $('.chats').append(`
                        <div class="chat chat-left">
                            <div class="chat-avatar">
                                <div class="avatar" style="background-color: #${data.avatar.color}">
                                    <div class="avatar-content">${data.avatar.name}</div>
                                </div>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>${message.message}</p>
                                </div>
                            </div>
                        </div>
                    `)
                }
            }
            lastSide = message.to
            $.ajax({
                type: 'POST',
                url: "{{ route('api.chat.read') }}",
                data: {
                    company_id: "{{ isset($company) ? $company->id : '' }}",
                    target: currentUser,
                    to: 1
                },
                success: function(res) {
                  loadAdminUser()
                }
            })
        } else {
            loadAdminUser()
        }
        $('.user-chats').scrollTop($('.user-chats > .chats').height());
    });
    function minuteCheck() {
      loadAdminUser()
    }
    minuteCheck()
    setInterval(minuteCheck, 60 * 1000);
</script>
@endsection
