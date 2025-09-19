@extends('layouts.app')

@section('title', $product->name . ' - Nguyệt Shop')
@section('description', $product->description ?: 'Khám phá ' . $product->name . ' tại Nguyệt Shop. Sản phẩm thời trang nữ cao cấp với chất lượng tốt và giá cả hợp lý.')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3 bg-light">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-images">
                    <div class="main-image mb-3">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage($product, '600x600') }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded-3 shadow" 
                             id="main-image">
                    </div>
                    
                    @if($product->images && count(json_decode($product->images)) > 1)
                    <div class="thumbnail-images d-flex gap-2">
                        @foreach(json_decode($product->images) as $index => $image)
                        <img src="{{ $image }}" 
                             alt="{{ $product->name }}" 
                             class="img-thumbnail thumbnail-image {{ $index === 0 ? 'active' : '' }}" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage('{{ $image }}', this)">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                        @if($product->is_featured)
                        <span class="badge bg-danger ms-2">Nổi bật</span>
                        @endif
                    </div>
                    
                    <h1 class="h2 mb-3">{{ $product->name }}</h1>
                    
                    <div class="price-section mb-4">
                        @if($product->sale_price)
                        <div class="d-flex align-items-center gap-3">
                            <span class="h3 text-primary mb-0">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                            <span class="h5 text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                            <span class="badge bg-success">-{{ $product->discount_percentage }}%</span>
                        </div>
                        @else
                        <span class="h3 text-primary">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>

                    @if($product->description)
                    <div class="product-description mb-4">
                        <h5>Mô tả sản phẩm</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Product Details -->
                    <div class="product-details mb-4">
                        <div class="row g-3">
                            @if($product->sku)
                            <div class="col-6">
                                <strong>Mã sản phẩm:</strong>
                                <span class="text-muted">{{ $product->sku }}</span>
                            </div>
                            @endif
                            @if($product->size)
                            <div class="col-6">
                                <strong>Kích thước:</strong>
                                <span class="text-muted">{{ $product->size }}</span>
                            </div>
                            @endif
                            @if($product->color)
                            <div class="col-6">
                                <strong>Màu sắc:</strong>
                                <span class="text-muted">{{ $product->color }}</span>
                            </div>
                            @endif
                            <div class="col-6">
                                <strong>Tình trạng:</strong>
                                <span class="text-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock_quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    @if($product->stock_quantity > 0)
                    <div class="add-to-cart-section">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Số lượng:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-3">
                            <button class="btn btn-primary btn-lg flex-fill add-to-cart" 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->current_price }}"
                                    data-product-image="{{ $product->images ? json_decode($product->images)[0] : 'https://images.unsplash.com/photo-' . rand(1500000000000, 1600000000000) . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                            </button>
                            <button class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Sản phẩm hiện đang hết hàng. Vui lòng liên hệ để được thông báo khi có hàng.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Sản phẩm liên quan</h2>
            <p class="text-muted">Những sản phẩm tương tự bạn có thể thích</p>
        </div>
        
        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="{{ $relatedProduct->images ? json_decode($relatedProduct->images)[0] : 'https://images.unsplash.com/photo-' . rand(1500000000000, 1600000000000) . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" 
                             alt="{{ $relatedProduct->name }}" 
                             class="card-img-top">
                        @if($relatedProduct->sale_price)
                        <div class="product-badge">-{{ $relatedProduct->discount_percentage }}%</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                        <p class="card-text text-muted small">{{ $relatedProduct->category->name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($relatedProduct->sale_price)
                                <span class="price">{{ number_format($relatedProduct->sale_price, 0, ',', '.') }}đ</span>
                                <span class="price-old">{{ number_format($relatedProduct->price, 0, ',', '.') }}đ</span>
                                @else
                                <span class="price">{{ number_format($relatedProduct->price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: var(--text-light);
    }

    .thumbnail-image {
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail-image:hover,
    .thumbnail-image.active {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }

    .product-details .row > div {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .product-details .row > div:last-child {
        border-bottom: none;
    }

    .input-group button {
        width: 40px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
// Change main image when thumbnail is clicked
function changeMainImage(imageSrc, element) {
    document.getElementById('main-image').src = imageSrc;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-image').forEach(img => img.classList.remove('active'));
    element.classList.add('active');
}

// Quantity controls
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const maxQuantity = {{ $product->stock_quantity }};
    const currentValue = parseInt(quantityInput.value);
    
    if (currentValue < maxQuantity) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
}

// Add to cart functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const productName = this.dataset.productName;
        const productPrice = parseFloat(this.dataset.productPrice);
        const productImage = this.dataset.productImage;
        const quantity = parseInt(document.getElementById('quantity').value);
        
        // Get current cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        
        // Check if product already exists in cart
        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: quantity
            });
        }
        
        // Save cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Update cart count
        updateCartCount();
        
        // Show success message
        showNotification(`Đã thêm ${quantity} sản phẩm vào giỏ hàng!`, 'success');
        
        // Add animation to button
        this.classList.add('btn-success');
        this.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm';
        setTimeout(() => {
            this.classList.remove('btn-success');
            this.innerHTML = '<i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng';
        }, 2000);
    });
});

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed`;
    notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Update cart count function
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const count = cart.reduce((total, item) => total + item.quantity, 0);
    document.getElementById('cart-count').textContent = count;
}
</script>
@endpush
