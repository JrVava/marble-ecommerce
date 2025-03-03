<!-- Cart Icon (Triggers Modal) -->
<a class="nav-link position-relative" href="#" data-bs-toggle="modal" data-bs-target="#cartModal">
    <div class="user-icons d-flex mb-2 me-2 position-relative">
        <div class="cart position-relative">
            <i class="bi bi-cart3 fs-4"></i>
            <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cart_count }}
            </span>
        </div>
    </div>
</a>

<!-- Shopping Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Cart Items -->
                <div class="cart-items overflow-auto" style="max-height: 400px;">
                    @foreach ($products as $product)
                        <div class="cart-item d-flex align-items-center mb-3 border-bottom pb-2">
                            <img src="{{ Storage::url('product_images/' . $product->id . '/' . $product->firstImage->image) }}"
                                class="cart-item-img rounded me-3" alt="Product"
                                style="width: 60px; height: 60px; object-fit: cover;">

                            <div class="cart-item-details flex-grow-1">
                                <a href="{{ route('preview-product.index', ['product_id' => $product->id]) }}" 
                                   class="d-block text-decoration-none text-dark">
                                    <p class="mb-0 fw-bold">{{ $product->product_name }}</p>
                                </a>
                                <small class="text-muted">Total in cart:</small>

                                <!-- Quantity Controls -->
                                <div class="d-flex align-items-center mt-1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary decrement" data-product-id="{{ $product->id }}">-</button>
                                    <input type="text" class="form-control text-center mx-2 quantity" data-product-id="{{ $product->id }}" value="{{ $carts->where('product_id', $product->id)->count() }}" style="width: 50px;" readonly>
                                    <button type="button" class="btn btn-sm btn-outline-secondary increment" data-product-id="{{ $product->id }}">+</button>
                                </div>
                            </div>

                            <button class="btn btn-sm btn-danger ms-2 remove-item" data-product-id="{{ $product->id }}">&times;</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <a href="/checkout" class="btn btn-primary w-100">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>

