@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng - Admin Nguyệt Shop')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Danh sách đơn hàng</h4>
        <p class="text-muted mb-0">Quản lý tất cả đơn hàng của khách hàng</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select" style="width: auto;">
            <option value="">Tất cả trạng thái</option>
            <option value="pending">Chờ xử lý</option>
            <option value="processing">Đang xử lý</option>
            <option value="shipped">Đã giao</option>
            <option value="delivered">Hoàn thành</option>
            <option value="cancelled">Đã hủy</option>
        </select>
        <button class="btn btn-outline-primary">
            <i class="fas fa-download me-2"></i>Xuất Excel
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $order->order_number }}</div>
                                <small class="text-muted">#{{ $order->id }}</small>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $order->customer_name }}</div>
                                <small class="text-muted">{{ $order->customer_email }}</small>
                                <br>
                                <small class="text-muted">{{ $order->customer_phone }}</small>
                            </div>
                        </td>
                        <td>
                            <div>
                                @foreach($order->orderItems->take(2) as $item)
                                <div class="d-flex align-items-center mb-1">
                                    <img src="{{ \App\Helpers\ImageHelper::getProductImage($item->product, '50x50') }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="rounded me-2" 
                                         style="width: 30px; height: 30px; object-fit: cover;">
                                    <div>
                                        <div class="small">{{ $item->product->name }}</div>
                                        <small class="text-muted">x{{ $item->quantity }}</small>
                                    </div>
                                </div>
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                <small class="text-muted">+{{ $order->orderItems->count() - 2 }} sản phẩm khác</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold text-primary">{{ number_format($order->total, 0, ',', '.') }}đ</div>
                                <small class="text-muted">Phí ship: {{ number_format($order->shipping_fee, 0, ',', '.') }}đ</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge status-{{ $order->status }}">
                                @switch($order->status)
                                    @case('pending')
                                        Chờ xử lý
                                        @break
                                    @case('processing')
                                        Đang xử lý
                                        @break
                                    @case('shipped')
                                        Đã giao
                                        @break
                                    @case('delivered')
                                        Hoàn thành
                                        @break
                                    @case('cancelled')
                                        Đã hủy
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <div>
                                <div class="small">{{ $order->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary" title="Cập nhật trạng thái">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info" title="In hóa đơn">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
        @endif
        
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h5>Chưa có đơn hàng nào</h5>
            <p class="text-muted mb-4">Các đơn hàng từ khách hàng sẽ hiển thị ở đây</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-external-link-alt me-2"></i>Xem website
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
