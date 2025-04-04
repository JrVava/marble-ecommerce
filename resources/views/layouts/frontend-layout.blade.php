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
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .navbar {
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
            
        }

        .navbar .navbar-brand {
            flex-grow: 1;
        }
        .navbar .navbar-nav {
            display: flex !important;
            align-items: center;
        }

        .navbar .navbar-nav .nav-link {
            color: #000;
        }

        .bold-icon {
            font-size: 1.3em;
            font-weight: bold;
        }

        /* Desktop View (≥1024px) */
        @media screen and (min-width: 1024px) {
            .navbar .container-xl {
                display: flex;
                justify-content: space-between;
            }

            .navbar .navbar-collapse {
                flex-grow: 1;
                display: flex;
                justify-content: center;
            }
        }

        /* Mobile & Tablet View (≤1024px) */
        @media screen and (max-width: 1024px) {

            /* Hide the navbar menu in the header */
            .navbar-toggler {
                display: none !important;
            }

            .navbar-collapse {
                display: none !important;
            }

            /* Menu fixed at bottom */
            .mobile-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background: #fff;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                padding: 10px 0;
                z-index: 1000;
            }

            .mobile-nav ul {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: space-around;
            }

            .mobile-nav ul li a {
                text-decoration: none;
                color: #000;
                font-size: 1.1rem;
            }
        }

        .mobile-nav ul {
            padding: 0;
            list-style: none;
            background: #fff;
        }

        .mobile-nav ul li {
            text-align: center;
            flex: 1;
        }

        .mobile-nav ul li a {
            display: flex !important;
            flex-direction: column-reverse;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: black;
            font-size: 14px;
            padding: 10px;
        }

        .mobile-nav ul li a i {
            font-size: 24px;
            /* Adjust icon size */
            margin-bottom: 5px;
            /* Space between icon and text */
        }

        .mobile-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md bg-body-tertiary">
            <div class="container-xl d-flex align-items-center justify-content-between">
                <!-- Logo on the left -->
                <a class="navbar-brand" href="#">
                    <h1><i><strong>RR Marbles</strong></i></h1>
                </a>

                <!-- Toggler for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu (Centered on Desktop, Moved to Bottom on Mobile) -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex gap-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('preview-product.all-products') }}">All
                                Products</a>
                        </li>
                        <li class="nav-item d-flex align-items-center cart-li">
                            <a href="#" class="nav-link scan-other-product" style="display: none;">
                                Scan
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center cart-li">
                            <a href="{{ route('preview-product.all-products') }}" class="nav-link scan-other-product" style="display: none;">
                                History
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link d-flex align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span>Log Out</span>
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

    <!-- Menu for mobile (separate for bottom position) -->
    <nav class="mobile-nav d-md-none">
        <ul class="d-flex justify-content-around">
            <li>
                <a href="{{ route('preview-product.all-products') }}">
                    All Products
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li>
                <a href="#" class="scan-other-product" style="display: none;">
                    Scan
                    <i class="bi bi-qr-code-scan"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('histories') }}" style="display: none;">
                    History
                    <i class="bi bi-clock-history"></i>
                </a>
            </li>
            <li>
                <a class="d-flex fw-bold align-items-center" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span>Log Out</span>
                    <i class='bi bi-box-arrow-right ms-2 bold-icon'></i>
                </a>
            </li>
        </ul>
    </nav>
    <div id="scanner-container" style="display: none;">
        <div id="qr-reader" style="width: 300px;"></div>
        <button id="close-scanner">Close</button>
    </div>
    <div class="container">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
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
