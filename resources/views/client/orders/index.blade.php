@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar">
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.doctors.index') }}">
                            <i class="bi bi-person-badge"></i> Browse Doctors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.clinics.index') }}">
                            <i class="bi bi-hospital"></i> Find Clinics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.medicines.index') }}">
                            <i class="bi bi-capsule"></i> Buy Medicines
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.consultations.index') }}">
                            <i class="bi bi-calendar-check"></i> My Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('client.orders.index') }}">
                            <i class="bi bi-bag-check"></i> My Orders
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">My Orders</h1>
                <a href="{{ route('client.medicines.index') }}" class="btn btn-success">
                    <i class="bi bi-capsule"></i> Browse Medicines
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    @forelse($orders as $order)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <strong>Order #{{ $order->order_code }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-{{ 
                                        $order->status == 'delivered' ? 'success' : 
                                        ($order->status == 'shipped' ? 'info' : 'warning') 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h6 class="mb-0 text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>Items:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($order->items as $item)
                                        <li class="mb-1">
                                            {{ $item->medicine->name }} x{{ $item->quantity }} 
                                            <span class="text-muted">
                                                @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-4 text-end">
                                    <!-- Cancel Button untuk Pending Orders -->
                                    @if($order->status === 'pending')
                                    <form action="{{ route('client.orders.cancel', $order) }}" 
                                        method="POST" 
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to cancel this order? Stock will be restored.')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i> Cancel Order
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-bag-x" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3">No orders yet</p>
                        <a href="{{ route('client.medicines.index') }}" class="btn btn-success">
                            Start Shopping
                        </a>
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