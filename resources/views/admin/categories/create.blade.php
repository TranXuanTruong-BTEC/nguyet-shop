@extends('layouts.admin')

@section('title', 'Thêm danh mục mới - Admin Nguyệt Shop')
@section('page-title', 'Thêm danh mục mới')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin danh mục</h5>
            </div>
            <div class="card-body">
                <form id="category-form" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên danh mục *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug (URL) *</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                            <small class="text-muted">VD: ao-so-mi, vay, quan</small>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Mô tả danh mục</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="image" class="form-label">Hình ảnh danh mục</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Hình ảnh đại diện cho danh mục</small>
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
                            <i class="fas fa-save me-2"></i>Lưu danh mục
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
                <h5 class="mb-0">Hướng dẫn</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Lưu ý quan trọng:</h6>
                    <ul class="mb-0 small">
                        <li>Tên danh mục phải rõ ràng, dễ hiểu</li>
                        <li>Slug phải viết thường, không dấu, dùng dấu gạch ngang</li>
                        <li>VD: "Áo sơ mi" → slug: "ao-so-mi"</li>
                        <li>Mô tả giúp khách hàng hiểu về danh mục</li>
                        <li>Hình ảnh nên có kích thước 400x300px</li>
                    </ul>
                </div>
                
                <div class="mt-3">
                    <h6>Danh mục hiện có:</h6>
                    @foreach(\App\Models\Category::all() as $category)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $category->name }}</span>
                        <span class="badge bg-primary">{{ $category->products_count ?? 0 }} sản phẩm</span>
                    </div>
                    @endforeach
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
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...';
    submitBtn.disabled = true;
});
</script>
@endpush
