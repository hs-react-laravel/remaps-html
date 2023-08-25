<!doctype html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    </head>
    <style>
        .brand-link:hover {
          transform: scale(1.05, 1.05);
        }
        .brand-item {
            padding: 6px;
        }
        .brand-link {
          float: left;
          box-sizing: border-box;

          position: relative;
          z-index: 1;
          overflow: hidden;
          display: block;
          background-color: #fff;
          border-radius: 4px;
          box-shadow: 0 0 4px rgba(0,0,0,.4);
          transform: scale(1, 1);
          transition: transform .3s ease;
          width: 100%; /* This if for the object-fit */
          height: 100%; /* This if for the object-fit */
        }
        .brand-link img {
          width: 100%; /* This if for the object-fit */
          height: 100%; /* This if for the object-fit */
          object-fit: cover; /* Equivalent of the background-size: cover; of a background-image */
          object-position: center;
        }
        @media (max-width: 576px) {
            .brand-item {
                width: 25%;
            }
        }
    </style>

    <body data-bs-theme="{{ $theme }}" style="background: #{{ $background }}; padding: {{ $py }}px {{ $px }}px">
        <div class="container-fluid py-2">
            <h5 style="color: #{{ $color }}">Please select the make of your car below.</h5>
            <div class="row">
                @foreach($brands as $brand)
                <div class="brand-item col-sm-4 col-md-2 col-xl-1">
                    <a href="{{ route('api.snippet.search', ['id' => $id,'brand' => $brand['brand'], 'theme' => $theme, 'color' => $color, 'btextcolor' => $btextcolor, 'background' => $background, 'px' => $px, 'py' => $py, 'dm' => $domain]) }}" class="brand-link">
                        <img class="brand-img" src="{{ $brand['logo'] }}">
                    </a>
                </div>
                @endforeach
            </div>
		</div>
    </body>
    <script src="{{ asset('customjs/iframeResizer.contentWindow.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</html>
