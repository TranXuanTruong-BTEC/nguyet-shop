@extends('layouts.app')

@section('title', 'Sản phẩm - Nguyệt Shop')
@section('description', 'Khám phá bộ sưu tập thời trang nữ đa dạng tại Nguyệt Shop. Áo sơ mi, váy, quần và phụ kiện thời trang cao cấp.')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3 bg-light">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </div>
</nav>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Bộ lọc</h5>
                    </div>
                    <div class="card-body">
                        <!-- Search -->
                        <div class="mb-4">
                            <h6>Tìm kiếm</h6>
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tên sản phẩm..." 
                                           value="{{ request('search') }}">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-list me-2"></i>Danh mục
                            </h6>
                            <div class="list-group list-group-flush">
                                <a href="{{ route('products.index') }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !request('category') ? 'active' : '' }}">
                                    <span class="fw-medium">
                                        <i class="fas fa-th-large me-2"></i>Tất cả sản phẩm
                                    </span>
                                    <span class="badge bg-secondary rounded-pill">{{ $products->total() }}</span>
                                </a>
                                @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('category') == $category->id ? 'active' : '' }}">
                                    <span class="fw-medium">
                                        <i class="fas fa-tag me-2"></i>{{ $category->name }}
                                    </span>
                                    <span class="badge bg-primary rounded-pill">{{ $category->products_count ?? 0 }}</span>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-sort me-2"></i>Sắp xếp
                            </h6>
                            <form method="GET" action="{{ route('products.index') }}">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select name="sort" class="form-select border-2" onchange="this.form.submit()">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                        <i class="fas fa-clock"></i> Mới nhất
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                        <i class="fas fa-arrow-up"></i> Giá thấp đến cao
                                    </option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                        <i class="fas fa-arrow-down"></i> Giá cao đến thấp
                                    </option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                        <i class="fas fa-sort-alpha-down"></i> Tên A-Z
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Results Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">
                            <i class="fas fa-shopping-bag me-2"></i>Sản phẩm
                        </h4>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Hiển thị {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} 
                            trong {{ $products->total() }} sản phẩm
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary active" id="grid-view" title="Xem dạng lưới">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="btn btn-outline-primary" id="list-view" title="Xem dạng danh sách">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="row g-4" id="products-grid">
                    @forelse($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="card product-card h-100 shadow-sm border-0">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ \App\Helpers\ImageHelper::getProductImage($product, '300x300') }}" 
                                     alt="{{ $product->name }}" 
                                     class="card-img-top product-image">
                                @if($product->sale_price)
                                <div class="product-badge discount-badge">
                                    <i class="fas fa-percentage me-1"></i>-{{ $product->discount_percentage }}%
                                </div>
                                @endif
                                @if($product->is_featured)
                                <div class="product-badge featured-badge">
                                    <i class="fas fa-star me-1"></i>Nổi bật
                                </div>
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-eye me-1"></i>Xem nhanh
                                    </a>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
                                </div>
                                <h6 class="card-title fw-bold text-dark mb-2">{{ $product->name }}</h6>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        @if($product->sale_price)
                                        <span class="price fw-bold text-danger fs-5">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                        <span class="price-old text-muted text-decoration-line-through ms-2">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                        @else
                                        <span class="price fw-bold text-dark fs-5">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-box me-1"></i>{{ $product->stock_quantity }}
                                    </small>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="btn btn-primary btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                                        </a>
                                        <button class="btn btn-outline-primary btn-sm add-to-cart" 
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ $product->current_price }}"
                                                data-product-image="{{ \App\Helpers\ImageHelper::getProductImage($product, '300x300') }}"
                                                title="Thêm vào giỏ hàng">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5>Không tìm thấy sản phẩm nào</h5>
                            <p class="text-muted">Hãy thử tìm kiếm với từ khóa khác hoặc chọn danh mục khác.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                Xem tất cả sản phẩm
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @endif
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

    .list-group-item.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: all 0.3s ease;
    }

    .list-group-item.active:hover {
        background-color: var(--primary-color);
        transform: translateX(5px);
    }

    .product-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }

    .product-image {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 2;
    }

    .discount-badge {
        background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
        color: white;
        box-shadow: 0 2px 10px rgba(255, 107, 107, 0.3);
    }

    .featured-badge {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        box-shadow: 0 2px 10px rgba(231, 76, 60, 0.3);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .list-view .product-card {
        display: flex;
        flex-direction: row;
    }

    .list-view .product-card .product-image {
        width: 200px;
        height: 150px;
        object-fit: cover;
    }

    .list-view .product-card .card-body {
        flex: 1;
    }

    .price {
        color: #e74c3c;
        font-weight: bold;
    }

    .price-old {
        color: #6c757d;
        text-decoration: line-through;
    }

    .btn-outline-primary.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination .page-link {
        color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 8px;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination .page-link:hover {
        color: white;
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
// View toggle functionality
document.getElementById('grid-view').addEventListener('click', function() {
    document.getElementById('products-grid').classList.remove('list-view');
    this.classList.add('active');
    this.classList.remove('btn-outline-primary');
    this.classList.add('btn-primary');
    document.getElementById('list-view').classList.remove('active');
    document.getElementById('list-view').classList.add('btn-outline-primary');
    document.getElementById('list-view').classList.remove('btn-primary');
    
    // Save preference
    localStorage.setItem('product-view', 'grid');
});

document.getElementById('list-view').addEventListener('click', function() {
    document.getElementById('products-grid').classList.add('list-view');
    this.classList.add('active');
    this.classList.remove('btn-outline-primary');
    this.classList.add('btn-primary');
    document.getElementById('grid-view').classList.remove('active');
    document.getElementById('grid-view').classList.add('btn-outline-primary');
    document.getElementById('grid-view').classList.remove('btn-primary');
    
    // Save preference
    localStorage.setItem('product-view', 'list');
});

// Load saved view preference
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('product-view');
    if (savedView === 'list') {
        document.getElementById('list-view').click();
    }
});

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
