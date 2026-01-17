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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.consultations.index') }}">
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
                <h1 class="h2">{{ __('messages.doctors') }}</h1>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Doctor
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>License</th>
                                    <th>Specializations</th>
                                    <th>Fee</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($doctors as $doctor)
                                <tr>
                                    <td>
                                        @if($doctor->photo)
                                            <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" 
                                                 class="rounded-circle" width="40" height="40">
                                        @else
                                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="bi bi-person text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $doctor->name }}</td>
                                    <td>{{ $doctor->license_number }}</td>
                                    <td>
                                        @foreach($doctor->specializations as $spec)
                                            <span class="badge bg-info">{{ $spec->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $doctor->is_available ? 'success' : 'secondary' }}">
                                            {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No doctors found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $doctors->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection