@extends('layouts.app')

@section('title', 'Thanh toán - Nguyệt Shop')
@section('description', 'Hoàn tất đơn hàng của bạn tại Nguyệt Shop. Thông tin giao hàng và thanh toán an toàn.')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3 bg-light">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active">Thanh toán</li>
        </ol>
    </div>
</nav>

<!-- Checkout Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Thanh toán</h2>
            </div>
        </div>
        
        <form id="checkout-form" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="row g-4">
                <!-- Checkout Form -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="customer_name" class="form-label">Họ và tên *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_phone" class="form-label">Số điện thoại *</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                                </div>
                                <div class="col-12">
                                    <label for="shipping_address" class="form-label">Địa chỉ giao hàng *</label>
                                    <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="notes" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Ghi chú thêm cho đơn hàng..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Phương thức thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2"></i>Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                        <label class="form-check-label" for="bank_transfer">
                                            <i class="fas fa-university me-2"></i>Chuyển khoản ngân hàng
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bank Transfer Info -->
                            <div id="bank-info" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <h6>Thông tin chuyển khoản:</h6>
                                    <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                    <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                                    <p class="mb-0"><strong>Chủ tài khoản:</strong> NGUYET SHOP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card sticky-top" style="top: 20px;">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div id="order-items">
                                <!-- Order items will be loaded here by JavaScript -->
                            </div>
                            
                            <hr class="my-3">
                            
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
                            
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3">
                                <i class="fas fa-credit-card me-2"></i>Hoàn tất đơn hàng
                            </button>
                            
                            <small class="text-muted d-block mt-3 text-center">
                                <i class="fas fa-shield-alt me-1"></i>
                                Bằng cách đặt hàng, bạn đồng ý với 
                                <a href="#" class="text-decoration-none">điều khoản sử dụng</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

    .order-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin: 0 -1rem;
    }

    .order-item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
        border: 2px solid #f8f9fa;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
    }

    .order-item-price {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .form-check-label {
        cursor: pointer;
        padding: 1rem;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
    }

    .form-check-input:checked + .form-check-label {
        border-color: var(--primary-color);
        background-color: rgba(0, 123, 255, 0.1);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-check-label:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
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

    /* Sticky summary improvements */
    .sticky-top {
        position: sticky !important;
        top: 20px !important;
        z-index: 10;
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

    /* Form improvements */
    .form-control {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    /* Text improvements */
    .fs-5 {
        font-size: 1.25rem !important;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .order-item {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        
        .order-item-image {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
        
        .form-check-label {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Load order items on page load
document.addEventListener('DOMContentLoaded', function() {
    loadOrderItems();
    
    // Handle payment method change
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankInfo = document.getElementById('bank-info');
            if (this.value === 'bank_transfer') {
                bankInfo.style.display = 'block';
            } else {
                bankInfo.style.display = 'none';
            }
        });
    });
});

// Load order items from cart
function loadOrderItems() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const orderItemsContainer = document.getElementById('order-items');
    
    if (cart.length === 0) {
        window.location.href = '{{ route("cart.index") }}';
        return;
    }
    
    let html = '';
    let subtotal = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        html += `
            <div class="order-item">
                <img src="${item.image}" alt="${item.name}" class="order-item-image" 
                     onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                <div class="order-item-info">
                    <div class="order-item-name">${item.name}</div>
                    <small class="text-muted">Số lượng: ${item.quantity}</small>
                </div>
                <div class="order-item-price">${formatPrice(itemTotal)}đ</div>
            </div>
        `;
    });
    
    orderItemsContainer.innerHTML = html;
    
    const shipping = 30000;
    const total = subtotal + shipping;
    
    document.getElementById('subtotal').textContent = formatPrice(subtotal) + 'đ';
    document.getElementById('shipping').textContent = formatPrice(shipping) + 'đ';
    document.getElementById('total').textContent = formatPrice(total) + 'đ';
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

// Handle form submission
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    if (cart.length === 0) {
        showNotification('Giỏ hàng trống!', 'warning');
        return;
    }
    
    // Validate form
    const requiredFields = ['customer_name', 'customer_email', 'customer_phone', 'shipping_address'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        showNotification('Vui lòng điền đầy đủ thông tin!', 'warning');
        return;
    }
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
    submitBtn.disabled = true;
    
    // Simulate order processing
    setTimeout(() => {
        // Clear cart
        localStorage.removeItem('cart');
        
        // Show success message
        showNotification('Đơn hàng đã được đặt thành công!', 'success');
        
        // Redirect to order confirmation
        setTimeout(() => {
            window.location.href = '{{ route("home") }}';
        }, 2000);
    }, 2000);
});

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed`;
    notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush
