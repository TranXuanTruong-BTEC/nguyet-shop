@extends('layouts.app')

@section('title', 'Nguyệt Shop - Thời trang nữ cao cấp')
@section('description', 'Khám phá bộ sưu tập thời trang nữ cao cấp tại Nguyệt Shop. Những sản phẩm đẹp, chất lượng tốt với giá cả hợp lý.')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content slide-in-left">
                    <h1 class="display-4 fw-bold mb-4">
                        Thời trang nữ <br>
                        <span class="text-primary">cao cấp</span>
                    </h1>
                    <p class="lead mb-4">
                        Khám phá bộ sưu tập thời trang nữ đẹp nhất tại Nguyệt Shop. 
                        Những sản phẩm được thiết kế tinh tế, chất lượng cao với giá cả hợp lý.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Mua sắm ngay
                        </a>
                        <a href="#featured" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-eye me-2"></i>Xem sản phẩm
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image slide-in-right">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Nguyệt Shop - Thời trang nữ cao cấp" 
                         class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5" id="categories">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Danh mục sản phẩm</h2>
            <p class="text-muted">Khám phá các danh mục thời trang đa dạng</p>
        </div>
        
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="{{ \App\Helpers\ImageHelper::getCategoryImage($category, '500x300') }}" 
                             alt="{{ $category->name }}" 
                             class="card-img-top"
                             onerror="this.src='https://via.placeholder.com/500x300?text=No+Image'">
                        <div class="product-badge">{{ $category->products_count }} sản phẩm</div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text text-muted">{{ $category->description }}</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="btn btn-outline-primary">
                            Xem sản phẩm
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có danh mục nào</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-light" id="featured">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Sản phẩm nổi bật</h2>
            <p class="text-muted">Những sản phẩm được yêu thích nhất</p>
        </div>
        
        <div class="row g-4">
            @forelse($featuredProducts as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage($product, '300x300') }}" 
                             alt="{{ $product->name }}" 
                             class="card-img-top">
                        @if($product->sale_price)
                        <div class="product-badge">-{{ $product->discount_percentage }}%</div>
                        @endif
                        @if($product->is_featured)
                        <div class="product-badge" style="top: 50px; background: #e74c3c;">Nổi bật</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small">{{ $product->category->name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->sale_price)
                                <span class="price">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                <span class="price-old">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                @else
                                <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                            <button class="btn btn-sm btn-outline-primary add-to-cart" 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->current_price }}"
                                    data-product-image="{{ \App\Helpers\ImageHelper::getProductImage($product, '300x300') }}">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có sản phẩm nổi bật nào</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                Xem tất cả sản phẩm
            </a>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="py-5" id="latest">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Sản phẩm mới nhất</h2>
            <p class="text-muted">Những sản phẩm vừa được thêm vào</p>
        </div>
        
        <div class="row g-4">
            @forelse($latestProducts as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage($product, '300x300') }}" 
                             alt="{{ $product->name }}" 
                             class="card-img-top">
                        <div class="product-badge" style="background: #27ae60;">Mới</div>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small">{{ $product->category->name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->sale_price)
                                <span class="price">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                <span class="price-old">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                @else
                                <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                            <button class="btn btn-sm btn-outline-primary add-to-cart" 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->current_price }}"
                                    data-product-image="{{ \App\Helpers\ImageHelper::getProductImage($product, '300x300') }}">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có sản phẩm mới nào</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                     alt="Về Nguyệt Shop" 
                     class="img-fluid rounded-3 shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title text-start">Về Nguyệt Shop</h2>
                <p class="lead mb-4">
                    Nguyệt Shop là thương hiệu thời trang nữ cao cấp, được thành lập với mong muốn 
                    mang đến cho phụ nữ Việt Nam những sản phẩm thời trang đẹp, chất lượng và phù hợp.
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-gem"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Chất lượng cao</h6>
                                <small class="text-muted">Sản phẩm chất lượng tốt</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Giao hàng nhanh</h6>
                                <small class="text-muted">Trong 24h</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-undo"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Đổi trả dễ dàng</h6>
                                <small class="text-muted">Trong 7 ngày</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Hỗ trợ 24/7</h6>
                                <small class="text-muted">Luôn sẵn sàng</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5" id="contact">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Liên hệ với chúng tôi</h2>
            <p class="text-muted">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                    </div>
                    <h5>Địa chỉ</h5>
                    <p class="text-muted">123 Đường ABC, Quận 1, TP.HCM</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                        <i class="fas fa-phone fa-2x"></i>
                    </div>
                    <h5>Điện thoại</h5>
                    <p class="text-muted">0123 456 789</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                    <h5>Email</h5>
                    <p class="text-muted">info@nguyetshop.com</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Add to cart functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const productName = this.dataset.productName;
        const productPrice = parseFloat(this.dataset.productPrice);
        const productImage = this.dataset.productImage;
        
        // Get current cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        
        // Check if product already exists in cart
        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        }
        
        // Save cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Update cart count
        updateCartCount();
        
        // Show success message
        showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
        
        // Add animation to button
        this.classList.add('btn-success');
        this.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => {
            this.classList.remove('btn-success');
            this.innerHTML = '<i class="fas fa-cart-plus"></i>';
        }, 1000);
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
