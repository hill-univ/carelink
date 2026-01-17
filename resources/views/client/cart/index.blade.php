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
                <h1 class="h2">Shopping Cart</h1>
                <a href="{{ route('client.medicines.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
            </div>

            @if(empty($cart))
                <div class="alert alert-info text-center">
                    <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                    <p class="mt-3">Your cart is empty</p>
                    <a href="{{ route('client.medicines.index') }}" class="btn btn-primary">Browse Medicines</a>
                </div>
            @else
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                @foreach($cart as $id => $item)
                                <div class="row mb-3 pb-3 border-bottom align-items-center">
                                    <div class="col-md-2">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" 
                                                 class="img-fluid rounded" alt="{{ $item['name'] }}">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                 style="height: 80px;">
                                                <i class="bi bi-capsule text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h6>{{ $item['name'] }}</h6>
                                        <p class="text-muted small mb-0">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <form action="{{ route('client.cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                                   min="1" max="{{ $item['stock'] }}" class="form-control form-control-sm" 
                                                   style="width: 70px;" onchange="this.form.submit()">
                                            <small class="text-muted ms-2">Max: {{ $item['stock'] }}</small>
                                        </form>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="col-md-1">
                                        <form action="{{ route('client.cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach

                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('client.cart.clear') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i> Clear Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                    <span>Shipping:</span>
                                    <strong>FREE</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Total:</h5>
                                    <h5 class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                                </div>
                                <div class="d-grid">
                                    <a href="{{ route('client.orders.create') }}" class="btn btn-success btn-lg">
                                        <i class="bi bi-check-circle"></i> Proceed to Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection