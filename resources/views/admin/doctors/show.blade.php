@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar">
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.doctors.index') }}">
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
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Doctor Details</h1>
                <div>
                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
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
                            <span class="badge bg-{{ $doctor->is_available ? 'success' : 'secondary' }} mb-3">
                                {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                            <h5 class="text-primary">Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</h5>
                            <small class="text-muted">Consultation Fee</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Doctor Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Specializations:</th>
                                    <td>
                                        @foreach($doctor->specializations as $spec)
                                            <span class="badge bg-info">{{ $spec->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $doctor->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $doctor->email }}</td>
                                </tr>
                                @if($doctor->bio)
                                <tr>
                                    <th>Bio:</th>
                                    <td>{{ $doctor->bio }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($doctor->clinics->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Practice Locations</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Clinic</th>
                                            <th>Schedule Days</th>
                                            <th>Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doctor->clinics as $clinic)
                                        <tr>
                                            <td>
                                                <strong>{{ $clinic->name }}</strong><br>
                                                <small class="text-muted">{{ $clinic->city }}</small>
                                            </td>
                                            <td>{{ $clinic->pivot->schedule_days }}</td>
                                            <td>
                                                {{ date('H:i', strtotime($clinic->pivot->start_time)) }} - 
                                                {{ date('H:i', strtotime($clinic->pivot->end_time)) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection