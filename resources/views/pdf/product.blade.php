<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
            color: #2a2a2a;
        }

        .section {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        .section strong {
            font-size: 16px;
            color: #555;
        }

        /* Page Layout for Images */
        .page {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .page img {
            width: 700px;
            height: 500px;
            object-fit: cover;
            display: block;
            margin-bottom: 10px;
        }

        .page:not(:last-of-type) {
            page-break-after: always; /* Apply page break except for the last page */
        }

    </style>
</head>
<body>

    <h1>Product Details</h1>

    @if(isset($product_name))
        <div class="section"><strong>Product Name:</strong> {{ $product_name }}</div>
    @endif

    @if(isset($sku))
        <div class="section"><strong>SKU:</strong> {{ $sku }}</div>
    @endif

    @if(isset($product_origin))
        <div class="section"><strong>Product Origin:</strong> {{ $product_origin }}</div>
    @endif

    @if(isset($thickness))
        <div class="section"><strong>Thickness:</strong> {{ $thickness }}</div>
    @endif

    @if(isset($product_height))
        <div class="section"><strong>Product Height:</strong> {{ $product_height }}</div>
    @endif

    @if(isset($product_width))
        <div class="section"><strong>Product Width:</strong> {{ $product_width }}</div>
    @endif

    @if(isset($shape))
        <div class="section"><strong>Shape:</strong> {{ $shape }}</div>
    @endif

    @if(isset($edges))
        <div class="section"><strong>Edges:</strong> {{ $edges }}</div>
    @endif

    @if(isset($total_qty))
        <div class="section"><strong>Total Quantity:</strong> {{ $total_qty }}</div>
    @endif

    @if(isset($no_of_slabs))
        <div class="section"><strong>No of Slabs:</strong> {{ $no_of_slabs }}</div>
    @endif

    @if(isset($rate))
        <div class="section"><strong>Rate:</strong> {{ $rate }}</div>
    @endif

    @if(isset($discount))
        <div class="section"><strong>Discount:</strong> {{ $discount }}</div>
    @endif

    @if(isset($description))
        <div class="section"><strong>Description:</strong> {!! $description !!}</div>
    @endif
    
    @if(isset($images) && $images->isNotEmpty())
    <div style="page-break-before: always;"></div> <!-- Ensure images always start on a new page -->
    @foreach($images->chunk(2) as $index => $imagePair)
        <div class="page" @if($index < ceil($images->count() / 2) - 1) style="page-break-after: always;" @endif>
            @foreach($imagePair as $image)
                <img src="{{ public_path('storage/product_images/' . $image->product_id . '/' . $image->image) }}" alt="Product Image">
            @endforeach
        </div>
    @endforeach
@endif


</body>
</html>
