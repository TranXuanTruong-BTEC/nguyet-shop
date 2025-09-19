@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới - Admin Nguyệt Shop')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin sản phẩm</h5>
            </div>
            <div class="card-body">
                <form id="product-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sku" class="form-label">Mã sản phẩm *</label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Giá gốc (VNĐ) *</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sale_price" class="form-label">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price" min="0">
                        </div>
                        <div class="col-md-6">
                            <label for="stock_quantity" class="form-label">Số lượng tồn kho *</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label">Kích thước</label>
                            <input type="text" class="form-control" id="size" name="size" placeholder="VD: S, M, L, XL">
                        </div>
                        <div class="col-md-6">
                            <label for="color" class="form-label">Màu sắc</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="VD: Đỏ, Xanh, Trắng">
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="images" class="form-label">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <small class="text-muted">Có thể chọn nhiều hình ảnh cùng lúc</small>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    Sản phẩm nổi bật
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Hiển thị trên website
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Lưu sản phẩm
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Hướng dẫn</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Lưu ý quan trọng:</h6>
                    <ul class="mb-0 small">
                        <li>Tên sản phẩm phải rõ ràng, dễ hiểu</li>
                        <li>Mã sản phẩm phải duy nhất</li>
                        <li>Giá khuyến mãi phải nhỏ hơn giá gốc</li>
                        <li>Hình ảnh nên có kích thước 500x500px</li>
                        <li>Mô tả chi tiết giúp khách hàng hiểu rõ sản phẩm</li>
                    </ul>
                </div>
                
                <div class="mt-3">
                    <h6>Danh mục hiện có:</h6>
                    @foreach(\App\Models\Category::all() as $category)
                    <span class="badge bg-secondary me-1 mb-1">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('product-form').addEventListener('submit', function(e) {
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...';
    submitBtn.disabled = true;
});
</script>
@endpush
