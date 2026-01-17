@extends('layouts.app')

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{{ __('messages.welcome') }}</h1>
                <p class="lead mb-4">
                    Platform konsultasi kesehatan terpadu. Temukan dokter, klinik, dan obat yang Anda butuhkan dengan mudah.
                </p>
                <div class="d-flex gap-2">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-person-plus"></i> {{ __('Get Started') }}
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('Login') }}
                        </a>
                    @else
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-hospital" style="font-size: 15rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="bi bi-person-badge text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Konsultasi Dokter</h5>
                    <p class="card-text text-muted">
                        Booking konsultasi dengan dokter spesialis pilihan Anda
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="bi bi-hospital text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Cari Klinik</h5>
                    <p class="card-text text-muted">
                        Temukan klinik dan rumah sakit terdekat di area Anda
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="bi bi-capsule text-danger" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Beli Obat</h5>
                    <p class="card-text text-muted">
                        Pesan obat over-the-counter dengan mudah dan aman
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection