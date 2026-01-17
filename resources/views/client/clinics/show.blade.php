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
                <h1 class="h2">{{ $clinic->name }}</h1>
                <a href="{{ route('client.clinics.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="row">
                <!-- Clinic Image & Info -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($clinic->image)
                                <img src="{{ asset('storage/' . $clinic->image) }}" alt="{{ $clinic->name }}" 
                                     class="img-fluid rounded mb-3">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 250px;">
                                    <i class="bi bi-hospital text-white" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Info Card -->
                    <div class="card mt-3">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="bi bi-info-circle"></i> Quick Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $clinic->phone }}</strong>
                            </div>
                            @if($clinic->email)
                            <div class="mb-3">
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $clinic->email }}</strong>
                            </div>
                            @endif
                            <div class="mb-3">
                                <small class="text-muted d-block">Operating Hours</small>
                                <strong class="text-success">
                                    {{ date('H:i', strtotime($clinic->opening_time)) }} - 
                                    {{ date('H:i', strtotime($clinic->closing_time)) }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="col-md-8">
                    <!-- Location -->
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Location</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>City:</strong> {{ $clinic->city }}</p>
                            <p class="mb-0"><strong>Address:</strong> {{ $clinic->address }}</p>
                            
                            @if($clinic->latitude && $clinic->longitude)
                            <div class="mt-3">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $clinic->latitude }},{{ $clinic->longitude }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-map"></i> Open in Google Maps
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Facilities -->
                    @if($clinic->facilities)
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-star"></i> Facilities</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach(explode(',', $clinic->facilities) as $facility)
                                <div class="col-md-6 mb-2">
                                    <i class="bi bi-check-circle text-success"></i> {{ trim($facility) }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Available Doctors -->
                    @if($clinic->doctors->count() > 0)
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-person-badge"></i> Available Doctors</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach($clinic->doctors as $doctor)
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                @if($doctor->photo)
                                                    <img src="{{ asset('storage/' . $doctor->photo) }}" 
                                                         alt="{{ $doctor->name }}" 
                                                         class="rounded-circle me-3" 
                                                         width="50" height="50" 
                                                         style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center me-3" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="bi bi-person text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $doctor->name }}</h6>
                                                    <small class="text-muted">
                                                        @foreach($doctor->specializations as $spec)
                                                            {{ $spec->name }}
                                                        @endforeach
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <p class="small text-muted mb-2">
                                                <i class="bi bi-calendar-week"></i> {{ $doctor->pivot->schedule_days }}<br>
                                                <i class="bi bi-clock"></i> 
                                                {{ date('H:i', strtotime($doctor->pivot->start_time)) }} - 
                                                {{ date('H:i', strtotime($doctor->pivot->end_time)) }}
                                            </p>
                                            
                                            <p class="text-primary fw-bold mb-2">
                                                Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}
                                            </p>
                                            
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('client.doctors.show', $doctor) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    View Profile
                                                </a>
                                                <a href="{{ route('client.consultations.create', ['doctor_id' => $doctor->id, 'clinic_id' => $clinic->id]) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-calendar-plus"></i> Book Here
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No doctors available at this clinic currently.
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection