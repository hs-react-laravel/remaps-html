<!doctype html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    </head>
    <style>
        .btn-custom {
            border-color: #{{ $color }} !important;
            background: #{{ $color }} !important;
            color: #{{ $btextcolor }} !important;
        }
        .btn-custom:hover {
            background: #{{ $color }}80 !important;
        }
        @media (max-width: 576px) {
            .search-control {
                padding-bottom: 1rem;
            }
        }
    </style>
    <body data-bs-theme="{{ $theme }}" style="@if($background) background: #{{ $background }}; @endif padding: {{ $py }}px {{ $px }}px">
        <div class="container-fluid py-2">
            <h5 style="color: #{{ $color }}">Search your vehicle</h5>
            <form action="{{ route('api.snippet.search.post') }}" method="post" id="frm">
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="domain" id="domain">
                <input type="hidden" name="theme" value="{{ $theme }}">
                <input type="hidden" name="color" value="{{ $color }}">
                <input type="hidden" name="btextcolor" value="{{ $btextcolor }}">
                <input type="hidden" name="px" value="{{ $px }}">
                <input type="hidden" name="py" value="{{ $py }}">
                <input type="hidden" name="dm" value="{{ $dm }}">
                <div class="row">
                    <div class="col-md-4 search-control">
                        <select class="form-select" id="model" name="model">
                            <option value="">--Choose a Model--</option>
                            @foreach ($models as $model => $id)
                                <option value="{{ $model }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 search-control">
                        <select class="form-select" id="generation" name="generation">
                        <option value="">--Choose a Generation--</option>
                        </select>
                    </div>
                    <div class="col-md-4 search-control">
                        <select class="form-select" id="engine" name="engine">
                        <option value="">--Choose a Engine--</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-2">
                    <button id="btnSubmit" class="btn btn-dark btn-custom" type="button" onclick="onSubmit()" disabled>Search</button>
                </div>
            </form>
		</div>
    </body>
    <script src="{{ asset('customjs/iframeResizer.contentWindow.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        $('#model').change(function() {
            updateNextOption('model', 'generation');
        });
        $('#generation').change(function() {
            updateNextOption('generation', 'engine');
        });
        $('#engine').change(function() {
            var engine = $(this).val();
            $("#btnSubmit").prop('disabled', !engine);
        })
        function updateNextOption(fromKey, toKey)  {
            $("#model").prop('disabled', 'disabled');
            $("#generation").prop('disabled', 'disabled');
            $("#engine").prop('disabled', 'disabled');

            if (fromKey === 'make') {
                $('#model').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
                $('#generation').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
                $('#engine').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
            } else if (fromKey === 'model') {
                $('#generation').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
                $('#engine').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
            } else if (fromKey === 'generation') {
                $('#engine').html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`);
            }

            if ($(`#${fromKey}`).val() !== '') {
            $.ajax({
                type: 'POST',
                url: "{{ route('api.car.query') }}",
                data: {
                    make: '{{ $make }}',
                    model: $('#model').val(),
                    generation: $('#generation').val(),
                    engine: $('#engine').val(),
                },
                success: function(result) {
                    $(`#${toKey}`).html(`<option value="">--Choose a ${capitalizeFirstLetter(toKey)}--</option>`)
                    for(const item of result){
                        if (toKey === 'engine') {
                            $(`#${toKey}`).append(`<option value='${item.id}'>${item.engine_type + ' ' + item.std_bhp}</option>`)
                        } else {
                            $(`#${toKey}`).append(`<option value='${item}'>${item}</option>`)
                        }
                    }
                    $("#model").prop('disabled', false);
                    $("#generation").prop('disabled', false);
                    $("#engine").prop('disabled', false);
                    $(`#${toKey}`).trigger('change');
                }
            })
            } else {
                $("#model").prop('disabled', false);
                $("#generation").prop('disabled', false);
                $("#engine").prop('disabled', false);
            }
            // updateButtonLink();
        }
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        function onSubmit() {
            var parentDomain = document.location.ancestorOrigins[0];
            $('#domain').val(parentDomain);
            $('#frm').submit();
        }
    </script>
</html>
