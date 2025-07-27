@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center fw-bold mb-5 text-danger">📘 Panduan Penggunaan Website Sebaran HIV Garut</h1>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-semibold text-danger mb-3">1. Akses Halaman Utama</h4>
                    <p>Setelah membuka website, Anda akan diarahkan ke halaman utama yang berisi navigasi menuju peta, informasi HIV/AIDS, rekap data, dan panduan.</p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-semibold text-danger mb-3">2. Melihat Peta Sebaran HIV</h4>
                    <ul>
                        <li>Klik menu <strong>"Peta"</strong> untuk menampilkan sebaran HIV/AIDS di Kabupaten Garut.</li>
                        <li>Anda dapat mengklik setiap lokasi pada peta untuk melihat total kasus kecamatan.</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-semibold text-danger mb-3">3. Informasi Edukasi HIV/AIDS</h4>
                    <ul>
                        <li>Pada menu <strong>"Informasi HIV"</strong>, Anda akan menemukan kumpulan informasi tentang HIV/AIDS, termasuk cara penularan, pencegahan, pengobatan, dan layanan bantuan.</li>
                        <li>Silakan baca setiap untuk memahami lebih dalam dan membagikan kepada orang terdekat.</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-semibold text-danger mb-3">4. Melihat dan Menyaring Data Rekap</h4>
                    <ul>
                        <li>Gunakan filter <strong>tahun</strong> untuk menyesuaikan data yang ingin Anda lihat.</li>
                        <li>Data meliputi jumlah kasus dan kecamatan.</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-semibold text-danger mb-3">5. Kontak Layanan</h4>
                    <ul>
                        <li>Jika Anda membutuhkan informasi tambahan silakan hubungi:</li>
                        <li><strong>Dinas Kesehatan Kabupaten Garut</strong> – pada menu kontak layanan.</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('index') }}" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
