@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Card Kontak -->
    <div class="card shadow-lg border-0">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <!-- Kiri: Informasi Kontak -->
                <div class="col-lg-6 mb-4">
                    <h1 class="display-5 fw-bold mb-3 text-danger">Hubungi Kami</h1>
                    <p class="lead">
                        Jika Anda membutuhkan informasi lebih lanjut mengenai layanan HIV di Kabupaten Garut, silakan hubungi kami melalui informasi berikut:
                    </p>

                    <ul class="list-unstyled fs-5">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                            <strong>Alamat:</strong> Jl. Proklamasi No.7, Jayaraga, Tarogong Kidul, Garut, Jawa Barat 44151
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill text-danger me-2"></i>
                            <strong>Telepon:</strong> (0262) 242373
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill text-danger me-2"></i>
                            <strong>Email:</strong> dinkesgarut1@gmail.com
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-globe text-danger me-2"></i>
                            <strong>Website:</strong> <a href="https://dinkes.garutkab.go.id" target="_blank">dinkes.garutkab.go.id</a>
                        </li>
                    </ul>

                    <hr class="my-4">

                    <h5 class="fw-semibold text-danger">Jam Pelayanan</h5>
                    <p class="mb-0">
                        Senin - Jumat: 07.30 - 15.30 WIB<br>
                        Sabtu - Minggu: Tutup
                    </p>
                </div>

                <!-- Kanan: Ilustrasi Kontak -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('build/assets/images/kontak.png') }}" alt="Ilustrasi Kontak HIV"
                         class="img-fluid" style="max-height: 350px;" loading="lazy">
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
