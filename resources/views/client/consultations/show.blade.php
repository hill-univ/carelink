@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Back button --}}
    <a href="{{ route('client.consultations.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Consultations
    </a>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Consultation Details</h4>

            {{-- Status badge --}}
            <span class="badge fs-6 bg-{{ 
                $consultation->status === 'completed' ? 'success' :
                ($consultation->status === 'confirmed' ? 'info' :
                ($consultation->status === 'cancelled' ? 'danger' : 'warning'))
            }}">
                {{ ucfirst($consultation->status) }}
            </span>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Booking Code</strong>
                    <p class="mb-0">{{ $consultation->booking_code }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Consultation Fee</strong>
                    <p class="mb-0">Rp {{ number_format($consultation->fee, 0, ',', '.') }}</p>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Date</strong>
                    <p class="mb-0">
                        {{ $consultation->consultation_date->format('d M Y') }}
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Time</strong>
                    <p class="mb-0">
                        {{ date('H:i', strtotime($consultation->consultation_time)) }}
                    </p>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Doctor</strong>
                    <p class="mb-0">{{ $consultation->doctor->name }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Clinic</strong>
                    <p class="mb-0">{{ $consultation->clinic->name }}</p>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <strong>Symptoms</strong>
                <p class="mb-0">{{ $consultation->symptoms }}</p>
            </div>

            <hr>

            <div class="mb-3">
                <strong>Payment Status</strong>
                <p class="mb-0">
                    <span class="badge bg-{{ $consultation->payment_status === 'paid' ? 'success' : 'secondary' }}">
                        {{ ucfirst($consultation->payment_status) }}
                    </span>
                </p>
            </div>

            {{-- Cancel button --}}
            @if($consultation->status === 'pending')
                <form action="{{ route('client.consultations.cancel', $consultation) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to cancel this consultation?')">
                    @csrf
                    <button class="btn btn-danger mt-3">
                        Cancel Consultation
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>
@endsection
