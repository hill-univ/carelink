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
                        <a class="nav-link active" href="{{ route('client.doctors.index') }}">
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
                <h1 class="h2">Browse Doctors</h1>
            </div>

            <!-- Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('client.doctors.index') }}" class="row g-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search by doctor name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" name="specialization">
                                <option value="">All Specializations</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec->id }}" {{ request('specialization') == $spec->id ? 'selected' : '' }}>
                                        {{ $spec->name }}
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

            <!-- Doctors Grid -->
            <div class="row g-4">
                @forelse($doctors as $doctor)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" 
                                     class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 100px; height: 100px;">
                                    <i class="bi bi-person text-white" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            
                            <div class="mb-2">
                                @foreach($doctor->specializations as $spec)
                                    <span class="badge bg-info">{{ $spec->name }}</span>
                                @endforeach
                            </div>
                            
                            <p class="text-primary fw-bold mb-3">
                                Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}
                            </p>
                            
                            @if($doctor->bio)
                                <p class="text-muted small">{{ Str::limit($doctor->bio, 100) }}</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-grid gap-2">
                                <a href="{{ route('client.doctors.show', $doctor) }}" class="btn btn-outline-primary">
                                    View Profile
                                </a>
                                <a href="{{ route('client.consultations.create', ['doctor_id' => $doctor->id]) }}" 
                                   class="btn btn-primary">
                                    <i class="bi bi-calendar-plus"></i> Book Consultation
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No doctors found. Try adjusting your search criteria.
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $doctors->links() }}
            </div>
        </main>
    </div>
</div>
@endsection