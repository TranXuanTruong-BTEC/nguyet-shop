@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục - Admin Nguyệt Shop')
@section('page-title', 'Chỉnh sửa danh mục')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin danh mục</h5>
            </div>
            <div class="card-body">
                <form id="category-form" method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên danh mục *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug (URL) *</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
                            <small class="text-muted">VD: ao-so-mi, vay, quan</small>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Mô tả danh mục</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="image" class="form-label">Hình ảnh danh mục</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Chọn hình ảnh mới để thay thế</small>
                            
                            @if($category->image)
                            <div class="mt-3">
                                <label class="form-label">Hình ảnh hiện tại:</label>
                                <div>
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="width: 200px; height: 150px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/200x150?text=No+Image'">
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Hiển thị trên website
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Cập nhật danh mục
                        </button>
                        <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary">
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
                <h5 class="mb-0">Thông tin danh mục</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <strong>Số sản phẩm:</strong>
                        <p class="text-muted">{{ $category->products_count ?? 0 }} sản phẩm</p>
                    </div>
                    <div class="col-6">
                        <strong>Slug:</strong>
                        <p class="text-muted">{{ $category->slug }}</p>
                    </div>
                    <div class="col-6">
                        <strong>Ngày tạo:</strong>
                        <p class="text-muted">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-6">
                        <strong>Cập nhật:</strong>
                        <p class="text-muted">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '') // Remove accents
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

document.getElementById('category-form').addEventListener('submit', function(e) {
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
    submitBtn.disabled = true;
});
</script>
@endpush
