@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar">
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('client.dashboard') }}">
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
                        <a class="nav-link" href="{{ route('client.orders.index') }}">
                            <i class="bi bi-bag-check"></i> My Orders
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <!-- Success Message dengan style lebih menarik -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Success!</strong>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome, {{ Auth::user()->name }}!</h1>
            </div>
            <!-- Quick Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Consultations</h6>
                                    <h2 class="mb-0">{{ $consultations }}</h2>
                                </div>
                                <i class="bi bi-calendar-check text-primary" style="font-size: 2.5rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Medicine Orders</h6>
                                    <h2 class="mb-0">{{ $orders }}</h2>
                                </div>
                                <i class="bi bi-bag-check text-success" style="font-size: 2.5rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Consultations</h5>
                            <a href="{{ route('client.consultations.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            @forelse($recentConsultations as $consultation)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $consultation->doctor->name }}</h6>
                                    <p class="text-muted mb-1 small">
                                        <i class="bi bi-hospital"></i> {{ $consultation->clinic->name }}
                                    </p>
                                    <p class="text-muted mb-0 small">
                                        <i class="bi bi-calendar"></i> {{ $consultation->consultation_date->format('d M Y') }}
                                    </p>
                                </div>
                                <span class="badge bg-{{ 
                                    $consultation->status == 'completed' ? 'success' : 
                                    ($consultation->status == 'confirmed' ? 'info' : 
                                    ($consultation->status == 'cancelled' ? 'danger' : 'warning'))}}">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-center text-muted">No consultations yet</p>
                            <a href="{{ route('client.doctors.index') }}" class="btn btn-primary w-100">Book a Consultation</a>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Orders</h5>
                            <a href="{{ route('client.orders.index') }}" class="btn btn-sm btn-outline-success">View All</a>
                        </div>
                        <div class="card-body">
                            @forelse($recentOrders as $order)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">Order #{{ $order->order_code }}</h6>
                                    <p class="text-muted mb-1 small">
                                        {{ $order->items->count() }} item(s)
                                    </p>
                                    <p class="text-primary mb-0 fw-bold">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="badge bg-{{ 
                                    $order->status == 'delivered' ? 'success' : 
                                    ($order->status == 'shipped' ? 'info' : 
                                    ($order->status == 'cancelled' ? 'danger' : 'warning'))}}"
                                >
                                {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-center text-muted">No orders yet</p>
                            <a href="{{ route('client.medicines.index') }}" class="btn btn-success w-100">Browse Medicines</a>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
          
        </main>
    </div>
</div>
@endsection