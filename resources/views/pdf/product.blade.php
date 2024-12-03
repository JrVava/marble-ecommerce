<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        /* Global styling */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #2a2a2a;
        }

        .section {
            margin-bottom: 25px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section strong {
            font-size: 16px;
            color: #555;
        }

        .section div {
            font-size: 14px;
            color: #333;
            margin-top: 5px;
        }

        .images {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .images img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Styling for optional fields */
        .optional {
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>

    <h1>Product Details</h1>

    @if(isset($product_name))
        <div class="section"><strong>Product Name:</strong> {{ $product_name }}</div>
    @else
        <div class="section optional">Product Name: Not available</div>
    @endif

    @if(isset($sku))
        <div class="section"><strong>SKU:</strong> {{ $sku }}</div>
    @else
        <div class="section optional">SKU: Not available</div>
    @endif

    @if(isset($product_origin))
        <div class="section"><strong>Product Origin:</strong> {{ $product_origin }}</div>
    @else
        <div class="section optional">Product Origin: Not available</div>
    @endif

    @if(isset($thickness))
        <div class="section"><strong>Thickness:</strong> {{ $thickness }}</div>
    @else
        <div class="section optional">Thickness: Not available</div>
    @endif

    @if(isset($product_height))
        <div class="section"><strong>Product Height:</strong> {{ $product_height }}</div>
    @else
        <div class="section optional">Product Height: Not available</div>
    @endif

    @if(isset($product_width))
        <div class="section"><strong>Product Width:</strong> {{ $product_width }}</div>
    @else
        <div class="section optional">Product Width: Not available</div>
    @endif

    @if(isset($shape))
        <div class="section"><strong>Shape:</strong> {{ $shape }}</div>
    @else
        <div class="section optional">Shape: Not available</div>
    @endif

    @if(isset($edges))
        <div class="section"><strong>Edges:</strong> {{ $edges }}</div>
    @else
        <div class="section optional">Edges: Not available</div>
    @endif

    @if(isset($total_qty))
        <div class="section"><strong>Total Quantity:</strong> {{ $total_qty }}</div>
    @else
        <div class="section optional">Total Quantity: Not available</div>
    @endif

    @if(isset($no_of_slabs))
        <div class="section"><strong>No of Slabs:</strong> {{ $no_of_slabs }}</div>
    @else
        <div class="section optional">No of Slabs: Not available</div>
    @endif

    @if(isset($rate))
        <div class="section"><strong>Rate:</strong> {{ $rate }}</div>
    @else
        <div class="section optional">Rate: Not available</div>
    @endif

    @if(isset($discount))
        <div class="section"><strong>Discount:</strong> {{ $discount }}</div>
    @else
        <div class="section optional">Discount: Not available</div>
    @endif

    @if(isset($description))
        <div class="section"><strong>Description:</strong> {!! $description !!}</div>
    @else
        <div class="section optional">Description: Not available</div>
    @endif

    @if(isset($images) && $images->isNotEmpty())
        <div class="section">
            <strong>Images:</strong>
            <div class="images">
                @foreach($images as $image)
                    <img src="{{ public_path('storage/product_images/' . $image->product_id . '/' . $image->image) }}" alt="Product Image">
                @endforeach
            </div>
        </div>
    @else
        <div class="section optional">No images available</div>
    @endif

</body>
</html>
