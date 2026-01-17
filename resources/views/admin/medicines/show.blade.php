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
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Medicine Details</h1>
                <div>
                    <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($medicine->image)
                                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" 
                                     class="img-fluid rounded mb-3">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 200px;">
                                    <i class="bi bi-capsule text-white" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <h4>{{ $medicine->name }}</h4>
                            <p class="text-muted">{{ $medicine->manufacturer }}</p>
                            <h3 class="text-primary">Rp {{ number_format($medicine->price, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Medicine Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Category:</th>
                                    <td><span class="badge bg-secondary">{{ $medicine->category }}</span></td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $medicine->description }}</td>
                                </tr>
                                <tr>
                                    <th>Manufacturer:</th>
                                    <td>{{ $medicine->manufacturer }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Stock:</th>
                                    <td>
                                        <span class="badge bg-{{ $medicine->stock > 10 ? 'success' : ($medicine->stock > 0 ? 'warning' : 'danger') }}">
                                            {{ $medicine->stock }} units
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Type:</th>
                                    <td>
                                        @if($medicine->requires_prescription)
                                            <span class="badge bg-danger">Prescription Required</span>
                                        @else
                                            <span class="badge bg-success">Over-the-Counter (OTC)</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection