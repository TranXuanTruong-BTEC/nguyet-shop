@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng - Admin Nguyệt Shop')
@section('page-title', 'Chi tiết đơn hàng')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin đơn hàng #{{ $order->order_number }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Mã đơn hàng:</strong>
                        <p class="text-muted">{{ $order->order_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Trạng thái:</strong>
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
                    </div>
                    <div class="col-md-6">
                        <strong>Ngày đặt:</strong>
                        <p class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tổng tiền:</strong>
                        <p class="text-primary fw-bold">{{ number_format($order->total, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Họ và tên:</strong>
                        <p class="text-muted">{{ $order->customer_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p class="text-muted">{{ $order->customer_email }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Số điện thoại:</strong>
                        <p class="text-muted">{{ $order->customer_phone }}</p>
                    </div>
                    <div class="col-12">
                        <strong>Địa chỉ giao hàng:</strong>
                        <p class="text-muted">{{ $order->shipping_address }}</p>
                    </div>
                    @if($order->notes)
                    <div class="col-12">
                        <strong>Ghi chú:</strong>
                        <p class="text-muted">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sản phẩm trong đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ \App\Helpers\ImageHelper::getProductImage($item->product, '50x50') }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="rounded me-3" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <small class="text-muted">{{ $item->product->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">{{ number_format($item->total, 0, ',', '.') }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                                <td class="fw-bold">{{ number_format($order->subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                <td class="fw-bold">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</td>
                            </tr>
                            <tr class="table-primary">
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td class="fw-bold">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Status Update -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật trạng thái</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái đơn hàng</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã giao</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Cập nhật trạng thái
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Tóm tắt đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Số sản phẩm:</span>
                    <span>{{ $order->orderItems->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Phí vận chuyển:</span>
                    <span>{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Tổng cộng:</strong>
                    <strong class="text-primary">{{ number_format($order->total, 0, ',', '.') }}đ</strong>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Thao tác</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                    <button class="btn btn-outline-info" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>In hóa đơn
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-pending {
        background-color: #ffc107;
        color: #000;
    }

    .status-processing {
        background-color: #17a2b8;
        color: white;
    }

    .status-shipped {
        background-color: #28a745;
        color: white;
    }

    .status-delivered {
        background-color: #6c757d;
        color: white;
    }

    .status-cancelled {
        background-color: #dc3545;
        color: white;
    }
</style>
@endpush
