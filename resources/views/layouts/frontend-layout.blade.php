<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" />

    <style>
        .navbar {
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand img {
            max-width: 100px;
        }

        .navbar .navbar-nav .nav-link {
            color: #000;
        }

        .bold-icon {
            font-size: 1.3em;
            /* Increase size */
            font-weight: bold;
            /* Attempt to make it bolder */
        }

        @media screen and (min-width: 1024px) {
            .navbar {
                letter-spacing: 0.1em;
            }

            .navbar .navbar-nav .nav-link {
                padding: 0.5em 1em;
            }
        }

        @media screen and (min-width: 768px) {
            .navbar .navbar-brand img {
                max-width: 7em;
            }

            .navbar .navbar-collapse {
                display: flex;
                flex-direction: column-reverse;
                align-items: flex-end;
            }
        }

        .cart i {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md bg-body-tertiary">
            <div class="container-xl">
                <a class="navbar-brand" href="#">
                    {{-- <img src="https://codingyaar.com/wp-content/uploads/coding-yaar-logo.png" alt=""> --}}
                    <h1>
                        <i>
                            <strong>
                                RR Marbles
                            </strong>
                        </i>
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ route('preview-product.all-products') }}">All Products</a>
                        </li>
                        <li class="nav-item d-flex align-items-center cart-li">
                            <a href="#" class="nav-link scan-other-product" aria-current="page"
                                style="display: none;">
                                Scan Other Product
                            </a>
                        </li>

                        <!-- Scanner Modal -->
                        <div id="scanner-container" style="display: none;">
                            <div id="qr-reader" style="width: 300px;"></div>
                            <button id="close-scanner">Close</button>
                        </div>
                        <li class="nav-item d-flex align-items-center">
                            <a class="btn btn-danger d-flex fw-bold align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <span class="align-middle">Log Out </span>
                                <i class='bi bi-box-arrow-right ms-2 bold-icon'></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
    <div class="container">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    @yield('scripts')

    <script>
        @if (Session::has('success'))

            toastr.success("{{ Session::get('success') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        
        @if (Session::has('error'))

            toastr.error("{{ Session::get('error') }}");
        @endif
        
        $(document).ready(function() {
            cart()
            $("body").on("click", ".increment, .decrement", function(event) {
                event.preventDefault(); // Prevent unwanted reloads

                let $button = $(this);
                let productId = $button.data("product-id");
                let $input = $(".quantity[data-product-id='" + productId + "']");
                let currentValue = parseInt($input.val()) || 0;

                if ($button.hasClass("increment")) {
                    console.log("Incrementing value for product:", productId, "Current value:",
                        currentValue);
                    $input.val(currentValue + 1);
                } else if ($button.hasClass("decrement")) {
                    console.log("Decrementing value for product:", productId, "Current value:",
                        currentValue);
                    console.log(Math.max(0, currentValue - 1));
                    $input.val(Math.max(0, currentValue - 1)); // Ensures value never goes below 1
                }
            });

            let html5QrCode; // Declare globally

            // Function to detect mobile devices
            function isMobileDevice() {
                return /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);
            }

            // Show the button only if the device is mobile
            function isMobileDevice() {
                return /Mobi|Android/i.test(navigator.userAgent);
            }

            if (isMobileDevice()) {
                $('.scan-other-product').show();
            }

            $('.scan-other-product').on('click', function(event) {
                event.preventDefault(); // Prevent default link behavior

                // Show scanner container
                $('#scanner-container').show();

                // Initialize the QR scanner
                html5QrCode = new Html5Qrcode("qr-reader");

                Html5Qrcode.getCameras().then(devices => {
                    console.log(devices);
                    if (devices && devices.length) {
                        // Try to find the back camera (rear camera)
                        let backCamera = devices.find(device => device.label.toLowerCase().includes(
                                'back') || device.label.toLowerCase().includes('rear') || device
                            .id.includes('1'));

                        let cameraId = backCamera ? backCamera.id : devices[0]
                            .id; // Use back camera if available, otherwise default

                        html5QrCode.start(
                            cameraId, {
                                fps: 10,
                                qrbox: {
                                    width: 250,
                                    height: 250
                                }
                            },
                            (decodedText) => {
                                window.open(decodedText, '_blank');
                                html5QrCode.stop().then(() => {
                                    $('#scanner-container').hide();
                                }).catch(err => console.log("Error stopping scanner:", err));
                            },
                            (errorMessage) => {
                                console.log(errorMessage);
                            }
                        );
                    }
                }).catch(err => console.log("No camera found: ", err));
            });

            // Close scanner when clicking close button
            $('#close-scanner').on('click', function() {
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        $('#scanner-container').hide();
                    }).catch(err => console.log("Error stopping scanner:", err));
                } else {
                    $('#scanner-container').hide();
                }
            });


        })

        function cart() {
            // $.ajax({
            //     url: "{{ route('preview-product.cart') }}",
            //     type: "GET",
            //     success: function(res) {
            //         $('.cart-li').css('cursor', 'pointer');
            //         $('.cart-li').html(res.html);
            //     }
            // })
        }
    </script>
</body>

</html>
