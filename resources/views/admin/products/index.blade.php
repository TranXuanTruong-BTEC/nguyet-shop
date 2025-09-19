@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm - Admin Nguyệt Shop')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Danh sách sản phẩm</h4>
        <p class="text-muted mb-0">Quản lý tất cả sản phẩm trong cửa hàng</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($products->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ \App\Helpers\ImageHelper::getProductImage($product, '50x50') }}" 
     alt="{{ $product->name }}" 
     class="rounded" 
     style="width: 50px; height: 50px; object-fit: cover;"
     onerror="this.src='https://via.placeholder.com/50x50?text=No+Image'">
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $product->name }}</div>
                                <small class="text-muted">{{ $product->sku }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $product->category->name }}</span>
                        </td>
                        <td>
                            <div>
                                @if($product->sale_price)
                                <div class="fw-bold text-primary">{{ number_format($product->sale_price, 0, ',', '.') }}đ</div>
                                <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}đ</small>
                                @else
                                <div class="fw-bold text-primary">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                </span>
                                @if($product->is_featured)
                                <span class="badge bg-warning">Nổi bật</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-sm btn-outline-secondary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.delete', $product) }}" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
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
        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
        @endif
        
        @else
        <div class="text-center py-5">
            <i class="fas fa-box fa-3x text-muted mb-3"></i>
            <h5>Chưa có sản phẩm nào</h5>
            <p class="text-muted mb-4">Hãy thêm sản phẩm đầu tiên để bắt đầu bán hàng</p>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm đầu tiên
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
