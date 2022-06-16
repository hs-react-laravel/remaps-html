
@extends('layouts/contentLayoutMaster')

@section('title', 'Chat Application')

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection

@section('content-sidebar')
@include('pages/chats/app-chat-sidebar')
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
        <div class="d-flex align-items-center">
          <div class="sidebar-toggle d-block d-lg-none me-1">
            <i data-feather="menu" class="font-medium-5"></i>
          </div>
          <div class="avatar avatar-border user-profile-toggle m-0 me-1">
            <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="avatar" height="36" width="36" />
            <span class="avatar-status-busy"></span>
          </div>
          <h6 class="mb-0">Kristopher Candy</h6>
        </div>
        <div class="d-flex align-items-center">
          <i data-feather="phone-call" class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
          <i data-feather="video" class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
          <i data-feather="search" class="cursor-pointer d-sm-block d-none font-medium-2"></i>
          <div class="dropdown">
            <button
              class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i data-feather="more-vertical" id="chat-header-actions" class="font-medium-2"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
              <a class="dropdown-item" href="#">View Contact</a>
              <a class="dropdown-item" href="#">Mute Notifications</a>
              <a class="dropdown-item" href="#">Block Contact</a>
              <a class="dropdown-item" href="#">Clear Chat</a>
              <a class="dropdown-item" href="#">Report</a>
            </div>
          </div>
        </div>
      </header>
    </div>
    <!--/ Chat Header -->

    <!-- User Chat messages -->
    <div class="user-chats" style="background: transparent">
      <div class="chats">
        {{-- <div class="chat">
          <div class="chat-avatar">
            <span class="avatar box-shadow-1 cursor-pointer">
              <img
                src="{{asset('images/portrait/small/avatar-s-11.jpg')}}"
                alt="avatar"
                height="36"
                width="36"
              />
            </span>
          </div>
          <div class="chat-body">
            <div class="chat-content">
              <p>How can we help? We're here for you! 😄</p>
            </div>
          </div>
        </div>
        <div class="chat chat-left">
          <div class="chat-avatar">
            <span class="avatar box-shadow-1 cursor-pointer">
              <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="avatar" height="36" width="36" />
            </span>
          </div>
          <div class="chat-body">
            <div class="chat-content">
              <p>Hey John, I am looking for the best admin template.</p>
              <p>Could you please help me to find it out? 🤔</p>
            </div>
            <div class="chat-content">
              <p>It should be Bootstrap 4 compatible.</p>
            </div>
          </div>
        </div>
        <div class="divider">
          <div class="divider-text">Yesterday</div>
        </div> --}}
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

<!-- User Chat profile right area -->
<div class="user-profile-sidebar">
  <header class="user-profile-header">
    <span class="close-icon">
      <i data-feather="x"></i>
    </span>
    <!-- User Profile image with name -->
    <div class="header-profile-sidebar">
      <div class="avatar box-shadow-1 avatar-border avatar-xl">
        <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="user_avatar" height="70" width="70" />
        <span class="avatar-status-busy avatar-status-lg"></span>
      </div>
      <h4 class="chat-user-name">Kristopher Candy</h4>
      <span class="user-post">UI/UX Designer 👩🏻‍💻</span>
    </div>
    <!--/ User Profile image with name -->
  </header>
  <div class="user-profile-sidebar-area">
    <!-- About User -->
    <h6 class="section-label mb-1">About</h6>
    <p>Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop.</p>
    <!-- About User -->
    <!-- User's personal information -->
    <div class="personal-info">
      <h6 class="section-label mb-1 mt-3">Personal Information</h6>
      <ul class="list-unstyled">
        <li class="mb-1">
          <i data-feather="mail" class="font-medium-2 me-50"></i>
          <span class="align-middle">kristycandy@email.com</span>
        </li>
        <li class="mb-1">
          <i data-feather="phone-call" class="font-medium-2 me-50"></i>
          <span class="align-middle">+1(123) 456 - 7890</span>
        </li>
        <li>
          <i data-feather="clock" class="font-medium-2 me-50"></i>
          <span class="align-middle">Mon - Fri 10AM - 8PM</span>
        </li>
      </ul>
    </div>
    <!--/ User's personal information -->

    <!-- User's Links -->
    <div class="more-options">
      <h6 class="section-label mb-1 mt-3">Options</h6>
      <ul class="list-unstyled">
        <li class="cursor-pointer mb-1">
          <i data-feather="tag" class="font-medium-2 me-50"></i>
          <span class="align-middle">Add Tag</span>
        </li>
        <li class="cursor-pointer mb-1">
          <i data-feather="star" class="font-medium-2 me-50"></i>
          <span class="align-middle">Important Contact</span>
        </li>
        <li class="cursor-pointer mb-1">
          <i data-feather="image" class="font-medium-2 me-50"></i>
          <span class="align-middle">Shared Media</span>
        </li>
        <li class="cursor-pointer mb-1">
          <i data-feather="trash" class="font-medium-2 me-50"></i>
          <span class="align-middle">Delete Contact</span>
        </li>
        <li class="cursor-pointer">
          <i data-feather="slash" class="font-medium-2 me-50"></i>
          <span class="align-middle">Block Contact</span>
        </li>
      </ul>
    </div>
    <!--/ User's Links -->
  </div>
</div>
<input type="hidden" id="currentUser">
<!--/ User Chat profile right area -->
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/pages/app-chat.js')) }}"></script>
<script>
    loadChatUsers()
    function loadChatUsers() {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.chat.users') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}"
            },
            success: function(result) {
                let filterKey = $('#chat-search').val()
                result.m.forEach(user => {
                    $('.chat-list').append(
                        `<li style="align-items:center" data-id="${user.id}">
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
                            <small class="float-end mb-25 chat-time">${user.date}</small>
                            <span class="badge bg-danger rounded-pill float-end">${user.count > 0 ? user.count : ''}</span>
                            </div>
                        </li>`
                    )
                });
                result.c.forEach(user => {
                    $('.contact-list').append(
                    `<li style="align-items:center">
                        <span class="avatar" style="width:32px; height:32px">
                            <div class="avatar" style="background-color: #${user.avatar.color}; width:32px; height:32px">
                                <div class="avatar-content">${user.avatar.name}</div>
                            </div>
                        </span>
                        <div class="chat-info">
                        <h5 class="mb-0">${user.name}</h5>
                        </div>
                    </li>`)
                })
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
                    target: $('#currentUser').val(),
                    to: 0,
                    message: message
                },
                success: function(result) {
                    $('.user-chats').scrollTop($('.user-chats > .chats').height());
                }
            })
        }
    }
    let lastSide = ''
    $('.chat-application .chat-user-list-wrapper').on('click', 'ul li', function() {
        $('#currentUser').val($(this).data('id'))
        $.ajax({
            type: 'GET',
            url: "{{ route('api.chat.messages') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}",
                target: $('#currentUser').val(),
            },
            success: function(result) {
                let msgHtml = '';
                for(const [key, msgDateGroup] of Object.entries(result.message)) {
                    msgDateGroup.forEach(msgUserGroup => {
                        if (msgUserGroup[0].to) {
                            msgHtml += `
                            <div class="chat chat-left">
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
                        } else {
                            msgHtml += `
                            <div class="chat">
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
                target: $('#currentUser').val()
            }
        })
    })
    var pusher = new Pusher('fac85360afc52d12009f', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('chat-channel');
    channel.bind('chat-event', function(data) {
        const message = data.message
        if (message.company_id === {{ $company->id }}) {
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
            }
            lastSide = message.to
        }
        $('.user-chats').scrollTop($('.user-chats > .chats').height());
    });
</script>
@endsection
