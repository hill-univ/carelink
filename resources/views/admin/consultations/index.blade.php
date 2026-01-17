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
                        <a class="nav-link" href="{{ route('admin.clinics.index') }}">
                            <i class="bi bi-hospital"></i> {{ __('messages.clinics') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.medicines.index') }}">
                            <i class="bi bi-capsule"></i> {{ __('messages.medicines') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.consultations.index') }}">
                            <i class="bi bi-calendar-check"></i> Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-bag-check"></i> Medicine Orders
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Consultations</h1>
            </div>

            <!-- Filter Tabs -->
            <!-- <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.consultations.index') }}">
                        All ({{ $consultations->total() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.consultations.index', ['status' => 'pending']) }}">
                        Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'confirmed' ? 'active' : '' }}" href="{{ route('admin.consultations.index', ['status' => 'confirmed']) }}">
                        Confirmed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('admin.consultations.index', ['status' => 'completed']) }}">
                        Completed
                    </a>
                </li>
            </ul> -->

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Clinic</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultations as $consultation)
                                <tr>
                                    <td><strong>{{ $consultation->booking_code }}</strong></td>
                                    <td>
                                        {{ $consultation->user->name }}<br>
                                        <small class="text-muted">{{ $consultation->user->email }}</small>
                                    </td>
                                    <td>{{ $consultation->doctor->name }}</td>
                                    <td>{{ $consultation->clinic->name }}</td>
                                    <td>
                                        {{ $consultation->consultation_date->format('d M Y') }}<br>
                                        <small>{{ date('H:i', strtotime($consultation->consultation_time)) }}</small>
                                    </td>
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
                                        <!-- Status Update Dropdown -->
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                Update Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($consultation->status === 'pending')
                                                <li>
                                                    <form action="{{ route('admin.consultations.updateStatus', $consultation) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-check-circle text-info"></i> Confirm
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                                
                                                @if($consultation->status === 'confirmed')
                                                <li>
                                                    <form action="{{ route('admin.consultations.updateStatus', $consultation) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-check-circle-fill text-success"></i> Complete
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                                
                                                @if($consultation->status !== 'cancelled' && $consultation->status !== 'completed')
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.consultations.updateStatus', $consultation) }}" 
                                                          method="POST"
                                                          onsubmit="return confirm('Cancel this consultation?')">
                                                        @csrf
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-x-circle"></i> Cancel
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.consultations.destroy', $consultation) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this consultation permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No consultations found</td>
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