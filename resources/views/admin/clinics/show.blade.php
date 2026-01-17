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
                        <a class="nav-link" href="{{ route('admin.doctors.index') }}">
                            <i class="bi bi-person-badge"></i> {{ __('messages.doctors') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.clinics.index') }}">
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
                <h1 class="h2">Clinic Details</h1>
                <div>
                    <a href="{{ route('admin.clinics.edit', $clinic) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.clinics.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($clinic->image)
                                <img src="{{ asset('storage/' . $clinic->image) }}" alt="{{ $clinic->name }}" 
                                     class="img-fluid rounded mb-3">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 200px;">
                                    <i class="bi bi-hospital text-white" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <h4>{{ $clinic->name }}</h4>
                            <p class="text-muted">{{ $clinic->city }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Clinic Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Address:</th>
                                    <td>{{ $clinic->address }}</td>
                                </tr>
                                <tr>
                                    <th>City:</th>
                                    <td>{{ $clinic->city }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $clinic->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $clinic->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Operating Hours:</th>
                                    <td>{{ date('H:i', strtotime($clinic->opening_time)) }} - {{ date('H:i', strtotime($clinic->closing_time)) }}</td>
                                </tr>
                                @if($clinic->latitude && $clinic->longitude)
                                <tr>
                                    <th>Coordinates:</th>
                                    <td>{{ $clinic->latitude }}, {{ $clinic->longitude }}</td>
                                </tr>
                                @endif
                                @if($clinic->facilities)
                                <tr>
                                    <th>Facilities:</th>
                                    <td>{{ $clinic->facilities }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($clinic->doctors->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Available Doctors</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th>Specialization</th>
                                            <th>Schedule</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clinic->doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->name }}</td>
                                            <td>
                                                @foreach($doctor->specializations as $spec)
                                                    <span class="badge bg-info">{{ $spec->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <small>{{ $doctor->pivot->schedule_days }}</small><br>
                                                <small>{{ date('H:i', strtotime($doctor->pivot->start_time)) }} - {{ date('H:i', strtotime($doctor->pivot->end_time)) }}</small>
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