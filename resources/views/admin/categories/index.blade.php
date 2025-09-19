@extends('layouts.admin')

@section('title', 'Quản lý danh mục - Admin Nguyệt Shop')
@section('page-title', 'Quản lý danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Danh sách danh mục</h4>
        <p class="text-muted mb-0">Quản lý các danh mục sản phẩm</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm danh mục mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Số sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>
                            @if($category->image)
                            <img src="{{ $category->image }}" 
                                 alt="{{ $category->name }}" 
                                 class="rounded" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-folder text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $category->name }}</div>
                                <small class="text-muted">{{ $category->slug }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted" style="max-width: 200px;">
                                {{ Str::limit($category->description, 50) }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $category->products_count }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $category->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-outline-secondary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.delete', $category) }}" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này? Tất cả sản phẩm trong danh mục sẽ bị xóa!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
        </div>
        @endif
        
        @else
        <div class="text-center py-5">
            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
            <h5>Chưa có danh mục nào</h5>
            <p class="text-muted mb-4">Hãy thêm danh mục đầu tiên để tổ chức sản phẩm</p>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Thêm danh mục đầu tiên
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
