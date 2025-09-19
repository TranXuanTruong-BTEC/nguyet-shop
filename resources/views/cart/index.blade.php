@extends('layouts.app')

@section('title', 'Giỏ hàng - Nguyệt Shop')
@section('description', 'Xem và quản lý giỏ hàng của bạn tại Nguyệt Shop. Thêm, xóa, cập nhật số lượng sản phẩm một cách dễ dàng.')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3 bg-light">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Giỏ hàng</li>
        </ol>
    </div>
</nav>

<!-- Cart Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Giỏ hàng của bạn</h2>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div id="cart-items">
                    <!-- Cart items will be loaded here by JavaScript -->
                </div>
                
                <!-- Empty Cart -->
                <div id="empty-cart" class="text-center py-5" style="display: none;">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>Giỏ hàng trống</h5>
                    <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            </div>
            
            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-6">
                                <span class="text-muted">Tạm tính:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span id="subtotal" class="fw-bold">0đ</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <span class="text-muted">Phí vận chuyển:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span id="shipping" class="fw-bold">30,000đ</span>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row mb-4">
                            <div class="col-6">
                                <span class="fs-5 fw-bold">Tổng cộng:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span id="total" class="fs-5 fw-bold text-primary">0đ</span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg py-3" id="checkout-btn">
                                <i class="fas fa-credit-card me-2"></i>Thanh toán
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary py-2">
                                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Promo Code -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-tag me-2"></i>Mã giảm giá
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" placeholder="Nhập mã giảm giá" id="promo-code">
                            <button class="btn btn-outline-primary" type="button" onclick="applyPromoCode()">
                                Áp dụng
                            </button>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Mã giảm giá sẽ được áp dụng khi thanh toán
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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

    .cart-item {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .cart-item:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #f8f9fa;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        justify-content: center;
    }

    .quantity-controls button {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-weight: bold;
        color: #6c757d;
    }

    .quantity-controls button:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: scale(1.1);
    }

    .quantity-controls input {
        width: 60px;
        text-align: center;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
    }

    .quantity-controls input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .remove-item {
        color: #dc3545;
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-radius: 50%;
    }

    .remove-item:hover {
        color: #c82333;
        background: #f8d7da;
        transform: scale(1.1);
    }

    .price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .price-old {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .cart-item {
            padding: 1rem;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
        }
        
        .quantity-controls {
            gap: 0.5rem;
        }
        
        .quantity-controls button {
            width: 30px;
            height: 30px;
        }
        
        .quantity-controls input {
            width: 50px;
            padding: 0.25rem;
        }
    }

    /* Sticky summary improvements */
    .sticky-top {
        position: sticky !important;
        top: 20px !important;
        z-index: 10;
    }

    /* Card improvements */
    .card {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        padding: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Button improvements */
    .btn-lg {
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    }

    /* Text improvements */
    .fs-5 {
        font-size: 1.25rem !important;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    /* Input group improvements */
    .input-group .form-control {
        border-radius: 8px 0 0 8px;
        border: 2px solid #dee2e6;
        padding: 0.75rem;
    }

    .input-group .btn {
        border-radius: 0 8px 8px 0;
        border: 2px solid #dee2e6;
        border-left: none;
        padding: 0.75rem 1.5rem;
    }

    .input-group .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
// Load cart items on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();
});

// Load cart items from localStorage
function loadCartItems() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const cartItemsContainer = document.getElementById('cart-items');
    const emptyCartDiv = document.getElementById('empty-cart');
    
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '';
        emptyCartDiv.style.display = 'block';
        updateCartSummary(0);
        return;
    }
    
    emptyCartDiv.style.display = 'none';
    
    let html = '';
    cart.forEach((item, index) => {
        const totalPrice = item.price * item.quantity;
        html += `
            <div class="cart-item" data-index="${index}">
                <div class="row align-items-center g-3">
                    <div class="col-md-2 col-3">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image w-100" 
                             onerror="this.src='https://via.placeholder.com/100x100?text=No+Image'">
                    </div>
                    <div class="col-md-4 col-9">
                        <h6 class="mb-1 fw-bold">${item.name}</h6>
                        <small class="text-muted">Mã sản phẩm: ${item.id}</small>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="price">${formatPrice(item.price)}đ</div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="quantity-controls">
                            <button onclick="updateQuantity(${index}, -1)" title="Giảm số lượng">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" value="${item.quantity}" min="1" 
                                   onchange="updateQuantity(${index}, 0, this.value)" 
                                   title="Số lượng">
                            <button onclick="updateQuantity(${index}, 1)" title="Tăng số lượng">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-1 col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price">${formatPrice(totalPrice)}đ</div>
                            <button class="btn btn-sm remove-item" onclick="removeItem(${index})" 
                                    title="Xóa sản phẩm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    cartItemsContainer.innerHTML = html;
    updateCartSummary();
}

// Update quantity
function updateQuantity(index, change, newValue = null) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    if (newValue !== null) {
        cart[index].quantity = parseInt(newValue);
    } else {
        cart[index].quantity += change;
    }
    
    if (cart[index].quantity < 1) {
        cart[index].quantity = 1;
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCartItems();
    updateCartCount();
}

// Remove item from cart
function removeItem(index) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCartItems();
        updateCartCount();
        
        showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'info');
    }
}

// Update cart summary
function updateCartSummary() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    const shipping = 30000;
    const total = subtotal + shipping;
    
    document.getElementById('subtotal').textContent = formatPrice(subtotal) + 'đ';
    document.getElementById('shipping').textContent = formatPrice(shipping) + 'đ';
    document.getElementById('total').textContent = formatPrice(total) + 'đ';
    
    // Disable checkout if cart is empty
    const checkoutBtn = document.getElementById('checkout-btn');
    if (cart.length === 0) {
        checkoutBtn.classList.add('disabled');
        checkoutBtn.onclick = function(e) { e.preventDefault(); };
    } else {
        checkoutBtn.classList.remove('disabled');
        checkoutBtn.onclick = null;
    }
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

// Apply promo code
function applyPromoCode() {
    const promoCode = document.getElementById('promo-code').value;
    
    if (!promoCode) {
        showNotification('Vui lòng nhập mã giảm giá!', 'warning');
        return;
    }
    
    // Simulate promo code validation
    const validCodes = ['WELCOME10', 'SAVE20', 'NEWUSER'];
    
    if (validCodes.includes(promoCode.toUpperCase())) {
        showNotification('Mã giảm giá đã được áp dụng!', 'success');
    } else {
        showNotification('Mã giảm giá không hợp lệ!', 'error');
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed`;
    notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times-circle' : 'info-circle'} me-2"></i>
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
