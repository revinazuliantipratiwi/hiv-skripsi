@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Card utama -->
    <div class="card shadow-lg border-0">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <!-- Kiri: Teks Selamat Datang -->
                <div class="col-lg-6 mb-4">
                    <h1 class="display-5 fw-bold mb-3 text-danger">Selamat Datang di Aplikasi Sebaran HIV</h1>
                    <p class="lead">
                        Aplikasi ini menyajikan informasi sebaran kasus HIV di Kabupaten Garut secara interaktif dan informatif.
                        Dengan menggunakan peta digital, Anda dapat melihat persebaran kasus HIV di tiap kecamatan serta data statistik pendukung lainnya.
                    </p>
                    <a href="{{ route('peta') }}" class="btn btn-danger mt-3 px-4 py-2">
                        <i class="bi bi-map-fill me-2"></i> Lihat Peta Sebaran
                    </a>
                </div>

                <!-- Kanan: Ilustrasi / Gambar -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('build/assets/images/hiv.png') }}" alt="Ilustrasi Sebaran HIV di Garut"
                         class="img-fluid" style="max-height: 350px;" loading="lazy">
                </div>
                
            </div>
        </div>
    </div>

    <!-- Seksi Informasi Tambahan -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-geo-alt-fill fs-2 text-danger mb-3"></i>
                    <h5 class="card-title fw-semibold">Pemetaan Kasus</h5>
                    <p class="card-text">Lihat distribusi kasus HIV secara geografis di seluruh wilayah Garut.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-bar-chart-line-fill fs-2 text-danger mb-3"></i>
                    <h5 class="card-title fw-semibold">Data Statistik</h5>
                    <p class="card-text">Dapatkan informasi jumlah kasus per kecamatan.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-shield-exclamation fs-2 text-danger mb-3"></i>
                    <h5 class="card-title fw-semibold">Pencegahan</h5>
                    <p class="card-text">Pelajari upaya pencegahan dan cara mendukung ODHA (Orang Dengan HIV/AIDS).</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Tambahkan ikon Bootstrap jika belum -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
