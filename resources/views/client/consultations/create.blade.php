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
                <h1 class="h2">Book Consultation</h1>
                <a href="{{ route('client.consultations.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('client.consultations.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="doctor_id" class="form-label">Select Doctor *</label>
                                    <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                            id="doctor_id" name="doctor_id" required>
                                        <option value="">Choose a doctor...</option>
                                        @foreach($doctors as $doc)
                                            <option value="{{ $doc->id }}" 
                                                {{ old('doctor_id', $doctor->id ?? '') == $doc->id ? 'selected' : '' }}
                                                data-fee="{{ $doc->consultation_fee }}">
                                                {{ $doc->name }} - 
                                                @foreach($doc->specializations as $spec)
                                                    {{ $spec->name }}
                                                @endforeach
                                                (Rp {{ number_format($doc->consultation_fee, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="clinic_id" class="form-label">Select Clinic *</label>
                                    <select class="form-select @error('clinic_id') is-invalid @enderror" 
                                            id="clinic_id" name="clinic_id" required>
                                        <option value="">Choose a clinic...</option>
                                        @foreach($clinics as $cli)
                                            <option value="{{ $cli->id }}" 
                                                {{ old('clinic_id', $clinic->id ?? '') == $cli->id ? 'selected' : '' }}>
                                                {{ $cli->name }} - {{ $cli->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('clinic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="consultation_date" class="form-label">Date *</label>
                                        <input type="date" class="form-control @error('consultation_date') is-invalid @enderror" 
                                               id="consultation_date" name="consultation_date" 
                                               value="{{ old('consultation_date') }}" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        @error('consultation_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="consultation_time" class="form-label">Time *</label>
                                        <input type="time" class="form-control @error('consultation_time') is-invalid @enderror" 
                                               id="consultation_time" name="consultation_time" 
                                               value="{{ old('consultation_time') }}" required>
                                        @error('consultation_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="symptoms" class="form-label">Symptoms / Complaints *</label>
                                    <textarea class="form-control @error('symptoms') is-invalid @enderror" 
                                              id="symptoms" name="symptoms" rows="4" required 
                                              placeholder="Please describe your symptoms in detail...">{{ old('symptoms') }}</textarea>
                                    @error('symptoms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> 
                                    Your consultation will be pending until confirmed by the clinic.
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-calendar-check"></i> Book Consultation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    @if($doctor)
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Selected Doctor</h5>
                        </div>
                        <div class="card-body text-center">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" 
                                     class="rounded-circle mb-3" width="100" height="100">
                            @endif
                            <h6>{{ $doctor->name }}</h6>
                            <div class="mb-2">
                                @foreach($doctor->specializations as $spec)
                                    <span class="badge bg-info">{{ $spec->name }}</span>
                                @endforeach
                            </div>
                            <h5 class="text-primary">Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection