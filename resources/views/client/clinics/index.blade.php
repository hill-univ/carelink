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
                        <a class="nav-link active" href="{{ route('client.clinics.index') }}">
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
                <h1 class="h2">Find Clinics</h1>
            </div>

            <!-- Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('client.clinics.index') }}" class="row g-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search by clinic name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" name="city">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
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

            <!-- Clinics Grid -->
            <div class="row g-4">
                @forelse($clinics as $clinic)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @if($clinic->image)
                                    <img src="{{ asset('storage/' . $clinic->image) }}" alt="{{ $clinic->name }}" 
                                         class="img-fluid rounded-start h-100" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-start h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hospital text-white" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $clinic->name }}</h5>
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-geo-alt"></i> {{ $clinic->city }}
                                    </p>
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-map"></i> {{ Str::limit($clinic->address, 60) }}
                                    </p>
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-telephone"></i> {{ $clinic->phone }}
                                    </p>
                                    <p class="text-success small mb-3">
                                        <i class="bi bi-clock"></i> 
                                        {{ date('H:i', strtotime($clinic->opening_time)) }} - 
                                        {{ date('H:i', strtotime($clinic->closing_time)) }}
                                    </p>
                                    
                                    @if($clinic->facilities)
                                    <div class="mb-3">
                                        @foreach(explode(',', $clinic->facilities) as $facility)
                                            <span class="badge bg-light text-dark border">{{ trim($facility) }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-white border-0 pt-0">
                                    <div class="d-grid">
                                        <a href="{{ route('client.clinics.show', $clinic) }}" class="btn btn-primary">
                                            <i class="bi bi-info-circle"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No clinics found. Try adjusting your search criteria.
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $clinics->links() }}
            </div>
        </main>
    </div>
</div>
@endsection