<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset(mix('vendors/js/ui/jquery.sticky.js'))}}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if($configData['blankPage'] === false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@php
    // dd(session('message'))
@endphp
<script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
    toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
    @if($errors->any())
    toastr.error("{!! implode('', $errors->all('<div>:message</div>')) !!}");
    @endif
</script>
<script>
    $('.layout-name').on('click', function () {
        var $this = $(this);
        var currentLayout = $this.data('layout');
        apiStyling('theme', currentLayout);
    });
    // Full Width Layout
    $('#layout-width-full').on('click', function () {
        apiStyling('layoutWidth', 'full');
    });
    // Boxed Layout
    $('#layout-width-boxed').on('click', function () {
        apiStyling('layoutWidth', 'boxed');
    });
    $('#customizer-navbar-colors .color-box').on('click', function () {
        var $this = $(this);
        var navbarColor = $this.data('navbar-color');
        apiStyling('navbarColor', navbarColor);
    })
    $('input[name="navType"]').on('click', function () {
        var $this = $(this);
        var navbarType = $this.data('type');
        apiStyling('navbarType', navbarType);
    })
    $('input[name="footerType"]').on('click', function () {
        var $this = $(this);
        var footerType = $this.data('footer');
        apiStyling('footerType', footerType);
    })

    function apiStyling(type, value) {
        $.ajax({
            type: 'POST',
            url: "{{ route('api.style') }}",
            data: {
                company: "{{ isset($company) ? $company->id : '' }}",
                type: type,
                value: value
            },
            success: function(result) {
                console.log(result);
            }
        })
    }

    $('#button-message-send').on('click', function() {
        sendMessageNav()
    });
    $('#message-box').on('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessageNav()
        }
    })

    function sendMessageNav() {
        const msg = $('#message-box').val();
        $('#message-box').val('');
        if (!msg) return

        $.ajax({
            type: 'POST',
            url: "{{ route('api.chat.send') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}",
                target: "{{ isset($user) ? $user->id : '' }}",
                to: 1,
                message: msg
            }
        })
    }
    var chatNavWrapper = $('.chat-nav-wrapper')
    var chatListScroll = $('.chat-list-scrollable')
    let lastSide = ''
    if (chatNavWrapper.length > 0) {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.chat.messages') }}",
            data: {
                company_id: "{{ isset($company) ? $company->id : '' }}",
                target: "{{ isset($user) ? $user->id : '' }}",
            },
            success: function(result) {
                let msgHtml = '';
                for(const [key, msgDateGroup] of Object.entries(result.message)) {
                    msgDateGroup.forEach(msgUserGroup => {
                        if (msgUserGroup[0].to) {
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
                        } else {
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
                        }
                        lastSide = msgUserGroup[0].to
                    })
                }
                $(chatNavWrapper).html(msgHtml);
                const chatWrapperHeight = $(chatListScroll).height()
                const chatListHeight = $(chatNavWrapper).height()
                console.log(chatWrapperHeight, chatListHeight)
                if (chatListHeight > chatWrapperHeight)
                    $(chatListScroll).scrollTop($(chatListHeight).height());
                else
                    $(chatListScroll).scrollTop(0);
            }
        })

        var pusher = new Pusher('fac85360afc52d12009f', {
        cluster: 'eu'
        });

        var channel = pusher.subscribe('chat-channel');
        channel.bind('chat-event', function(data) {
            console.log(data, lastSide)
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
                        $('.chat-nav-wrapper').append(`
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
                        $('.chat-nav-wrapper').append(`
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
            }
            $('.user-chats').scrollTop($('.user-chats > .chats').height());
        });
    }
</script>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
