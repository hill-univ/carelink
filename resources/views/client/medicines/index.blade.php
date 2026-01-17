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
                <h1 class="h2">Buy Medicines (OTC Only)</h1>
                <a href="{{ route('client.cart.index') }}" class="btn btn-success">
                    <i class="bi bi-cart3"></i> Cart 
                    @if(session('cart'))
                        <span class="badge bg-light text-dark">{{ count(session('cart')) }}</span>
                    @endif
                </a>
            </div>

            <!-- Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('client.medicines.index') }}" class="row g-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search medicines..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Medicines Grid -->
            <div class="row g-4">
                @forelse($medicines as $medicine)
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            @if($medicine->image)
                                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" 
                                     class="img-fluid rounded mb-3" style="height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 150px;">
                                    <i class="bi bi-capsule text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            <h6 class="card-title">{{ $medicine->name }}</h6>
                            <p class="text-muted small mb-1">{{ $medicine->manufacturer }}</p>
                            <span class="badge bg-secondary mb-2">{{ $medicine->category }}</span>
                            
                            <h5 class="text-primary mb-2">Rp {{ number_format($medicine->price, 0, ',', '.') }}</h5>
                            
                            <p class="small mb-2">
                                <span class="badge bg-{{ $medicine->stock > 10 ? 'success' : 'warning' }}">
                                    Stock: {{ $medicine->stock }}
                                </span>
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-grid gap-2">
                                <a href="{{ route('client.medicines.show', $medicine) }}" class="btn btn-sm btn-outline-primary">
                                    Details
                                </a>
                                <form action="{{ route('client.cart.add', $medicine) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100" 
                                            {{ $medicine->stock < 1 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No medicines found. Try adjusting your search criteria.
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $medicines->links() }}
            </div>
        </main>
    </div>
</div>
@endsection