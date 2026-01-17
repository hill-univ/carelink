@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar">
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.doctors.index') }}">
                            <i class="bi bi-person-badge"></i> {{ __('messages.doctors') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.clinics.index') }}">
                            <i class="bi bi-hospital"></i> {{ __('messages.clinics') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.medicines.index') }}">
                            <i class="bi bi-capsule"></i> {{ __('messages.medicines') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.consultations.index') }}">
                            <i class="bi bi-calendar-check"></i> Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-bag-check"></i> Medicine Orders
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Medicine Orders</h1>
            </div>

            <!-- Filter Tabs -->
            <!-- <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        All ({{ $orders->total() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">
                        Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'processing']) }}">
                        Processing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'shipped']) }}">
                        Shipped
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'delivered']) }}">
                        Delivered
                    </a>
                </li> -->
            </ul>

            <div class="card">
                <div class="card-body">
                    @forelse($orders as $order)
                    <div class="card mb-3 border">
                        <div class="card-header bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <strong>{{ $order->order_code }}</strong>
                                </div>
                                <div class="col-md-3">
                                    {{ $order->user->name }}<br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                </div>
                                <div class="col-md-2">
                                    <span class="badge bg-{{ 
                                        $order->status == 'delivered' ? 'success' : 
                                        ($order->status == 'shipped' ? 'info' : 
                                        ($order->status == 'processing' ? 'primary' :
                                        ($order->status == 'cancelled' ? 'danger' : 'warning'))) 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <strong class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Items:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($order->items as $item)
                                        <li class="mb-1">
                                            <i class="bi bi-capsule text-muted"></i>
                                            {{ $item->medicine->name }} 
                                            <span class="badge bg-secondary">x{{ $item->quantity }}</span>
                                            <span class="text-muted">
                                                @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h6>Shipping Address:</h6>
                                    <p class="text-muted small">{{ $order->shipping_address }}</p>
                                </div>
                                <div class="col-md-2 text-end">
                                    <!-- Status Update Dropdown -->
                                    <div class="btn-group-vertical w-100">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                            Update Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if($order->status === 'pending')
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-gear text-primary"></i> Process
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                            
                                            @if($order->status === 'processing')
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="shipped">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-truck text-info"></i> Ship
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                            
                                            @if($order->status === 'shipped')
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="delivered">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-check-circle text-success"></i> Deliver
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                            
                                            @if($order->status !== 'cancelled' && $order->status !== 'delivered')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('Cancel this order? Stock will be restored.')">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-x-circle"></i> Cancel
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                        </ul>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.orders.destroy', $order) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Delete this order permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100 mt-2">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-bag-x" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3">No orders found</p>
                    </div>
                    @endforelse

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection