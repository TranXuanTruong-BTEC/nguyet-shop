@extends('layouts.admin')

@section('title', 'Dashboard - Admin Nguyệt Shop')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary me-3">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['total_products'] }}</h3>
                    <p class="text-muted mb-0">Tổng sản phẩm</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success me-3">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['total_categories'] }}</h3>
                    <p class="text-muted mb-0">Danh mục</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info me-3">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['total_orders'] }}</h3>
                    <p class="text-muted mb-0">Tổng đơn hàng</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning me-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['pending_orders'] }}</h3>
                    <p class="text-muted mb-0">Đơn hàng chờ xử lý</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Đơn hàng gần đây</h5>
            </div>
            <div class="card-body">
                @if($recent_orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold">{{ $order->customer_name }}</div>
                                        <small class="text-muted">{{ $order->customer_email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ number_format($order->total, 0, ',', '.') }}đ</span>
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
                                    <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h6>Chưa có đơn hàng nào</h6>
                    <p class="text-muted">Các đơn hàng sẽ hiển thị ở đây</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thao tác nhanh</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                    </a>
                    <a href="{{ route('admin.categories') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tags me-2"></i>Quản lý danh mục
                    </a>
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Xem đơn hàng
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-external-link-alt me-2"></i>Xem website
                    </a>
                </div>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin hệ thống</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Laravel Version:</span>
                    <span class="text-muted">{{ app()->version() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>PHP Version:</span>
                    <span class="text-muted">{{ PHP_VERSION }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Database:</span>
                    <span class="text-muted">SQLite</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Environment:</span>
                    <span class="badge bg-success">{{ app()->environment() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
