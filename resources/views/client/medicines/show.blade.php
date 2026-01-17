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
                        <a class="nav-link active" href="{{ route('client.medicines.index') }}">
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Medicine Details</h1>
                <a href="{{ route('client.medicines.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="row">
                <!-- Product Image -->
                <div class="col-md-5 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($medicine->image)
                                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" 
                                     class="img-fluid rounded mb-3" style="max-height: 400px;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 400px;">
                                    <i class="bi bi-capsule text-white" style="font-size: 6rem;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">{{ $medicine->category }}</span>
                            <h2 class="mb-3">{{ $medicine->name }}</h2>
                            
                            <h3 class="text-primary mb-4">Rp {{ number_format($medicine->price, 0, ',', '.') }}</h3>
                            
                            <div class="mb-4">
                                <h6>Description:</h6>
                                <p>{{ $medicine->description }}</p>
                            </div>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Manufacturer:</th>
                                    <td>{{ $medicine->manufacturer }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $medicine->category }}</td>
                                </tr>
                                <tr>
                                    <th>Stock Availability:</th>
                                    <td>
                                        <span class="badge bg-{{ $medicine->stock > 10 ? 'success' : ($medicine->stock > 0 ? 'warning' : 'danger') }}">
                                            {{ $medicine->stock }} units available
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            @if($medicine->stock > 0)
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> This medicine is available for purchase
                            </div>

                            <form action="{{ route('client.cart.add', $medicine) }}" method="POST">
                                @csrf
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                    <a href="{{ route('client.cart.index') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-cart3"></i> View Cart
                                    </a>
                                </div>
                            </form>
                            @else
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle"></i> This medicine is currently out of stock
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection