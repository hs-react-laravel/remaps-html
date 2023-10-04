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

    @if(isset($role))
    function fetchCounts() {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.sidebar.counts') }}",
            data: {
                userid: '{{ $user->id }}'
            },
            success: function(res) {
                if (res.tickets > 0) {
                    $('#ticket_badge').show();
                    $('#ticket_badge').html(res.tickets);
                } else {
                    $('#ticket_badge').hide();
                }
                if (res.chats > 0) {
                    $('#badge-chat').show();
                    $('#badge-chat').html(res.chats);
                } else {
                    $('#badge-chat').hide();
                }
            }
        })
    }
    fetchCounts()
    $(document).ready(function($) {
      setInterval(() => {
        fetchCounts()
      }, 5 * 1000);
    })
    @endif

    @if(isset($role) && $role == 'customer')
    var notifiesArr = [];
    function fetchNotifies() {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.notifies') }}",
            data: {
                userid: '{{ $user->id }}'
            },
            success: function(notifies) {
                notifies = Object.keys(notifies).map(key => notifies[key]);
                var newNotifies = notifies.map(x => x.id).filter(x => !notifiesArr.includes(x));
                notifiesArr = notifiesArr.concat(newNotifies);
                const showNotifies = notifies.filter(x => newNotifies.includes(x.id));
                for (const n of showNotifies) {
                    if (n.icon == 0) {
                        toastr.error(n.body, n.subject, {
                            closeButton : true,
                            tapToDismiss : false,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            escapeHtml: false,
                            onHidden: function() {
                                $.ajax({
                                    url: '{{ route("dashboard.notifications.read") }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: n.id
                                    },
                                    dataType: 'JSON',
                                    success: function (data) {

                                    }
                                });
                            }
                        });
                    } else if (n.icon == 1) {
                        toastr.warning(n.body, n.subject, {
                            closeButton : true,
                            tapToDismiss : false,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            escapeHtml: false,
                            onHidden: function() {
                                $.ajax({
                                    url: '{{ route("dashboard.notifications.read") }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: n.id
                                    },
                                    dataType: 'JSON',
                                    success: function (data) {

                                    }
                                });
                            }
                        });
                    } else if (n.icon == 2) {
                        toastr.info(n.body, n.subject, {
                            closeButton : true,
                            tapToDismiss : false,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            escapeHtml: false,
                            onHidden: function() {
                                $.ajax({
                                    url: '{{ route("dashboard.notifications.read") }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: n.id
                                    },
                                    dataType: 'JSON',
                                    success: function (data) {

                                    }
                                });
                            }
                        });
                    } else if (n.icon == 3) {
                        toastr.success(n.body, n.subject, {
                            closeButton : true,
                            tapToDismiss : false,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            escapeHtml: false,
                            onHidden: function() {
                                $.ajax({
                                    url: '{{ route("dashboard.notifications.read") }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: n.id
                                    },
                                    dataType: 'JSON',
                                    success: function (data) {

                                    }
                                });
                            }
                        });
                    }
                }
            }
        })
    }

    fetchNotifies()
    $(document).ready(function($) {
      setInterval(() => {
        fetchNotifies()
      }, 5 * 1000);
    })

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


</script>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
