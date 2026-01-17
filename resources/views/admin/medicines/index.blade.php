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
                        <a class="nav-link active" href="{{ route('admin.medicines.index') }}">
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
                <h1 class="h2">{{ __('messages.medicines') }}</h1>
                <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Medicine
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
                                    <th>Category</th>
                                    <th>Manufacturer</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($medicines as $medicine)
                                <tr>
                                    <td>
                                        @if($medicine->image)
                                            <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" 
                                                 class="rounded" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-capsule text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $medicine->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $medicine->category }}</span></td>
                                    <td>{{ $medicine->manufacturer }}</td>
                                    <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $medicine->stock > 10 ? 'success' : ($medicine->stock > 0 ? 'warning' : 'danger') }}">
                                            {{ $medicine->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($medicine->requires_prescription)
                                            <span class="badge bg-danger">Prescription Required</span>
                                        @else
                                            <span class="badge bg-success">OTC</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.medicines.show', $medicine) }}" class="btn btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" 
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
                                    <td colspan="8" class="text-center text-muted">No medicines found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $medicines->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection