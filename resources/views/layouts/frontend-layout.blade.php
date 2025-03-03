<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
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
                    <img src="https://codingyaar.com/wp-content/uploads/coding-yaar-logo.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('preview-product.all-products') }}">All Products</a>
                        </li>
                        <li class="nav-item d-flex align-items-center cart-li">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    <script>
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
        })

        function cart() {
            $.ajax({
                url: "{{ route('preview-product.cart') }}",
                type: "GET",
                success: function(res) {
                    $('.cart-li').css('cursor', 'pointer');
                    $('.cart-li').html(res.html);
                }
            })
        }
    </script>
</body>

</html>
