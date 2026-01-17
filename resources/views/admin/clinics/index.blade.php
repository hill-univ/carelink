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
                <h1 class="h2">{{ __('messages.clinics') }}</h1>
                <a href="{{ route('admin.clinics.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Clinic
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Phone</th>
                                    <th>Operating Hours</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clinics as $clinic)
                                <tr>
                                    <td>
                                        @if($clinic->image)
                                            <img src="{{ asset('storage/' . $clinic->image) }}" alt="{{ $clinic->name }}" 
                                                 class="rounded" width="60" height="40" style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 40px;">
                                                <i class="bi bi-hospital text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $clinic->name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($clinic->address, 30) }}</small>
                                    </td>
                                    <td>{{ $clinic->city }}</td>
                                    <td>{{ $clinic->phone }}</td>
                                    <td>
                                        <small>{{ date('H:i', strtotime($clinic->opening_time)) }} - {{ date('H:i', strtotime($clinic->closing_time)) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.clinics.show', $clinic) }}" class="btn btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.clinics.edit', $clinic) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.clinics.destroy', $clinic) }}" method="POST" 
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
                                    <td colspan="6" class="text-center text-muted">No clinics found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $clinics->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection