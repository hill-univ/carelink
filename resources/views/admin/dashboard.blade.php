@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar">
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
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
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-bag-check"></i> Medicine Orders
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ __('messages.dashboard') }} - Admin</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">{{ __('messages.doctors') }}</h6>
                                    <h2 class="mb-0">{{ $doctors }}</h2>
                                </div>
                                <i class="bi bi-person-badge" style="font-size: 2.5rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">{{ __('messages.clinics') }}</h6>
                                    <h2 class="mb-0">{{ $clinics }}</h2>
                                </div>
                                <i class="bi bi-hospital" style="font-size: 2.5rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">{{ __('messages.medicines') }}</h6>
                                    <h2 class="mb-0">{{ $medicines }}</h2>
                                </div>
                                <i class="bi bi-capsule" style="font-size: 2.5rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">{{ __('messages.consultations') }}</h6>
                                    <h2 class="mb-0">{{ $consultations }}</h2>
                                </div>
                                <i class="bi bi-calendar-check" style="font-size: 2.5rem; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Recent Data -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Recent Consultations</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentConsultations as $consultation)
                                        <tr>
                                            <td><small>{{ $consultation->booking_code }}</small></td>
                                            <td>{{ $consultation->user->name }}</td>
                                            <td>{{ $consultation->doctor->name }}</td>
                                            <td>
                                                <!-- <span class="badge bg-{{ $consultation->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ $consultation->status }}
                                                </span> -->
                                                <span class="badge bg-{{ 
                                                    $consultation->status == 'completed' ? 'success' : 
                                                    ($consultation->status == 'confirmed' ? 'info' : 
                                                    ($consultation->status == 'cancelled' ? 'danger' : 'warning'))}}">
                                                    {{ ucfirst($consultation->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No consultations yet</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Recent Orders</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                        <tr>
                                            <td><small>{{ $order->order_code }}</small></td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $order->status == 'delivered' ? 'success' : 
                                                    ($order->status == 'shipped' ? 'info' : 
                                                    ($order->status == 'cancelled' ? 'danger' : 'warning'))}}"
                                                >
                                                {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No orders yet</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection