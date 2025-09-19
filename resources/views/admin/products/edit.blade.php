@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm - Admin Nguyệt Shop')
@section('page-title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin sản phẩm</h5>
            </div>
            <div class="card-body">
                <form id="product-form" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sku" class="form-label">Mã sản phẩm *</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Giá gốc (VNĐ) *</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sale_price" class="form-label">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0">
                        </div>
                        <div class="col-md-6">
                            <label for="stock_quantity" class="form-label">Số lượng tồn kho *</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label">Kích thước</label>
                            <input type="text" class="form-control" id="size" name="size" value="{{ old('size', $product->size) }}" placeholder="VD: S, M, L, XL">
                        </div>
                        <div class="col-md-6">
                            <label for="color" class="form-label">Màu sắc</label>
                            <input type="text" class="form-control" id="color" name="color" value="{{ old('color', $product->color) }}" placeholder="VD: Đỏ, Xanh, Trắng">
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="images" class="form-label">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <small class="text-muted">Chọn hình ảnh mới để thay thế (có thể chọn nhiều hình)</small>
                            
                            @if($product->images)
                            <div class="mt-3">
                                <label class="form-label">Hình ảnh hiện tại:</label>
                                <div class="row g-2">
                                    @foreach(json_decode($product->images) as $image)
                                    <div class="col-md-3">
                                        <img src="{{ Storage::url($image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/100x100?text=No+Image'">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Sản phẩm nổi bật
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Hiển thị trên website
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Cập nhật sản phẩm
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
                <h5 class="mb-0">Thông tin sản phẩm</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <strong>Mã sản phẩm:</strong>
                        <p class="text-muted">{{ $product->sku }}</p>
                    </div>
                    <div class="col-6">
                        <strong>Slug:</strong>
                        <p class="text-muted">{{ $product->slug }}</p>
                    </div>
                    <div class="col-6">
                        <strong>Ngày tạo:</strong>
                        <p class="text-muted">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-6">
                        <strong>Cập nhật:</strong>
                        <p class="text-muted">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
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
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
    submitBtn.disabled = true;
});
</script>
@endpush
