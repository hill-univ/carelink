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
                <h1 class="h2">Doctor Profile</h1>
                <a href="{{ route('client.doctors.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="row">
                <!-- Doctor Profile -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" 
                                     class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-person text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            <h4>{{ $doctor->name }}</h4>
                            <p class="text-muted mb-1">{{ $doctor->license_number }}</p>
                            
                            <div class="mb-3">
                                @foreach($doctor->specializations as $spec)
                                    <span class="badge bg-info">{{ $spec->name }}</span>
                                @endforeach
                            </div>
                            
                            <h3 class="text-primary mb-3">Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</h3>
                            
                            <div class="d-grid">
                                <a href="{{ route('client.consultations.create', ['doctor_id' => $doctor->id]) }}" 
                                   class="btn btn-primary btn-lg">
                                    <i class="bi bi-calendar-plus"></i> Book Consultation
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="col-md-8">
                    <!-- About -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle"></i> About Doctor</h5>
                        </div>
                        <div class="card-body">
                            @if($doctor->bio)
                                <p>{{ $doctor->bio }}</p>
                            @else
                                <p class="text-muted">No bio available.</p>
                            @endif
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Phone:</strong> {{ $doctor->phone }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Email:</strong> {{ $doctor->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Practice Locations -->
                    @if($doctor->clinics->count() > 0)
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-hospital"></i> Practice Locations</h5>
                        </div>
                        <div class="card-body">
                            @foreach($doctor->clinics as $clinic)
                            <div class="card mb-3 border">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">{{ $clinic->name }}</h6>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-geo-alt"></i> {{ $clinic->address }}, {{ $clinic->city }}
                                            </p>
                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-telephone"></i> {{ $clinic->phone }}
                                            </p>
                                            <p class="text-success small mb-0">
                                                <i class="bi bi-calendar-week"></i> {{ $clinic->pivot->schedule_days }}<br>
                                                <i class="bi bi-clock"></i> 
                                                {{ date('H:i', strtotime($clinic->pivot->start_time)) }} - 
                                                {{ date('H:i', strtotime($clinic->pivot->end_time)) }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="{{ route('client.consultations.create', ['doctor_id' => $doctor->id, 'clinic_id' => $clinic->id]) }}" 
                                               class="btn btn-primary">
                                                <i class="bi bi-calendar-plus"></i> Book Here
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No practice locations available currently.
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection