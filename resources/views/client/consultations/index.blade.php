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
                        <a class="nav-link active" href="{{ route('client.consultations.index') }}">
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
                <h1 class="h2">My Consultations</h1>
                <a href="{{ route('client.consultations.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Book New Consultation
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Doctor</th>
                                    <th>Clinic</th>
                                    <th>Date & Time</th>
                                    <th>Fee</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultations as $consultation)
                                <tr>
                                    <td><strong>{{ $consultation->booking_code }}</strong></td>
                                    <td>{{ $consultation->doctor->name }}</td>
                                    <td>{{ $consultation->clinic->name }}</td>
                                    <td>
                                        {{ $consultation->consultation_date->format('d M Y') }}<br>
                                        <small class="text-muted">{{ date('H:i', strtotime($consultation->consultation_time)) }}</small>
                                    </td>
                                    <td>Rp {{ number_format($consultation->fee, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $consultation->status == 'completed' ? 'success' : 
                                            ($consultation->status == 'confirmed' ? 'info' : 
                                            ($consultation->status == 'cancelled' ? 'danger' : 'warning')) 
                                        }}">
                                            {{ ucfirst($consultation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- <a href="{{ route('client.consultations.show', $consultation) }}" 
                                               class="btn btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a> -->
                                            @if($consultation->status == 'pending')
                                            <form action="{{ route('client.consultations.cancel', $consultation) }}" 
                                                  method="POST" onsubmit="return confirm('Cancel this consultation?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <p class="text-muted mt-3">No consultations yet</p>
                                        <a href="{{ route('client.consultations.create') }}" class="btn btn-primary">
                                            Book Your First Consultation
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $consultations->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection