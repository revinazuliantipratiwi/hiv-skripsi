@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center fw-bold mb-5 text-danger">❓ Pertanyaan Umum (FAQ) tentang HIV & Website Ini</h1>

    <div class="accordion accordion-flush" id="faqAccordion">
        <!-- 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq1">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                    Apa itu HIV dan apa bedanya dengan AIDS?
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    HIV (Human Immunodeficiency Virus) adalah virus yang menyerang sistem kekebalan tubuh. Jika tidak diobati, HIV dapat berkembang menjadi AIDS (Acquired Immunodeficiency Syndrome), tahap akhir infeksi HIV.
                </div>
            </div>
        </div>

        <!-- 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                    Apakah HIV bisa disembuhkan?
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Saat ini belum ada obat untuk menyembuhkan HIV, tetapi pengobatan ARV (Antiretroviral) dapat menekan virus hingga tidak terdeteksi dan mencegah berkembang menjadi AIDS.
                </div>
            </div>
        </div>

        <!-- 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                    Bagaimana cara HIV menular?
                </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    HIV menular melalui hubungan seksual tanpa pengaman, berbagi jarum suntik, transfusi darah yang tidak aman, dan dari ibu ke anak saat kehamilan, persalinan, atau menyusui.
                </div>
            </div>
        </div>

        <!-- 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                    Apakah HIV bisa menular melalui pelukan atau makan bersama?
                </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Tidak. HIV tidak menular melalui pelukan, bersalaman, cium pipi, berbagi makanan atau toilet. Virus hanya menular melalui cairan tubuh tertentu.
                </div>
            </div>
        </div>

        <!-- 5 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq5">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                    Di mana saya bisa tes HIV?
                </button>
            </h2>
            <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Tes HIV dapat dilakukan di puskesmas.
                </div>
            </div>
        </div>

        <!-- 6 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq6">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                    Bagaimana cara menggunakan website ini?
                </button>
            </h2>
            <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Website ini memiliki peta sebaran layanan HIV di Garut, informasi tentang HIV, fitur rekap data, serta panduan.
                </div>
            </div>
        </div>

        <!-- 7 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                    Bagaimana saya bisa membantu mengurangi stigma terhadap ODHA?
                </button>
            </h2>
            <div id="collapse" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Dukung ODHA dengan empati, bukan diskriminasi. Hindari penyebaran mitos, ajak masyarakat untuk peduli, dan dorong mereka untuk rutin melakukan tes dan pengobatan.
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-5">
        <a href="{{ route('index') }}" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
