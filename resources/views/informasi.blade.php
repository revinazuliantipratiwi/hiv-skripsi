@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center fw-bold mb-5 text-danger">💉 Informasi Lengkap Tentang HIV/AIDS</h1>

    <div class="row g-4">
        <x-hiv-card icon="bi-virus" title="Apa Itu HIV?" color="bg-light">
            HIV (Human Immunodeficiency Virus) adalah virus yang menyerang sistem kekebalan tubuh, khususnya sel CD4. Tanpa pengobatan, HIV akan berkembang menjadi AIDS (Acquired Immunodeficiency Syndrome), kondisi di mana tubuh sangat rentan terhadap infeksi dan penyakit.
        </x-hiv-card>

        <x-hiv-card icon="bi-bar-chart-line" title="Tahapan Infeksi HIV" color="bg-light">
            <ul>
                <li><strong>1. Akut:</strong> Demam, kelelahan, ruam.</li>
                <li><strong>2. Laten:</strong> Tidak ada gejala, tapi virus berkembang.</li>
                <li><strong>3. AIDS:</strong> Imun lemah, mudah sakit parah.</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-shuffle" title="Cara Penularan" color="bg-light">
            <ul>
                <li>Hubungan seksual tanpa pengaman.</li>
                <li>Berbagi jarum suntik.</li>
                <li>Ibu ke anak saat kehamilan/persalinan/ASI.</li>
                <li>Transfusi darah tidak tersaring (jarang).</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-shield-check" title="Pencegahan Efektif" color="bg-light">
            <ul>
                <li>Gunakan kondom dengan benar.</li>
                <li>Tidak berbagi jarum/alat tajam.</li>
                <li>Tes HIV rutin jika berisiko tinggi.</li>
                <li><strong>PrEP:</strong> Obat sebelum terpapar.</li>
                <li><strong>PEP:</strong> Obat sesudah terpapar (maks. 72 jam).</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-thermometer-high" title="Gejala Umum HIV" color="bg-light">
            <ul>
                <li>Demam berkepanjangan.</li>
                <li>Penurunan berat badan drastis.</li>
                <li>Diare kronis, kelelahan ekstrim.</li>
                <li>Sariawan, pembengkakan kelenjar.</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-capsule-pill" title="Pengobatan HIV (ARV)" color="bg-light">
            Pengobatan HIV disebut <strong>Antiretroviral (ARV)</strong>. ARV menekan virus sehingga tidak merusak kekebalan tubuh. Prinsip <strong>U=U</strong> (<em>Undetectable = Untransmittable</em>) berarti jika HIV tidak terdeteksi, maka tidak bisa menular ke orang lain.
        </x-hiv-card>

        <x-hiv-card icon="bi-people-fill" title="ODHA & Stigma Sosial" color="bg-light">
            ODHA (Orang Dengan HIV/AIDS) bisa hidup sehat dan panjang umur jika rutin minum ARV. Stigma & diskriminasi membuat ODHA enggan berobat. Dukung dengan empati, bukan penilaian.
        </x-hiv-card>

        <x-hiv-card icon="bi-clipboard2-check" title="Tes HIV & Konseling" color="bg-light">
            Tes HIV bisa dilakukan di puskesmas, rumah sakit, dan layanan <strong>VCT</strong>. Bersifat <strong>rahasia, sukarela, dan gratis</strong>. Semakin dini diketahui, semakin besar peluang hidup sehat.
        </x-hiv-card>

        <x-hiv-card icon="bi-exclamation-circle" title="Fakta vs Mitos HIV" color="bg-light">
            <ul>
                <li>❌ Tidak menular lewat pelukan, cium pipi, atau berbagi makanan.</li>
                <li>✅ HIV hanya menular melalui cairan tubuh tertentu.</li>
                <li>❌ HIV ≠ kutukan. ✅ HIV = penyakit medis.</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-info-circle" title="Layanan & Bantuan" color="bg-light">
            <ul>
                <li>Dinas Kesehatan Kabupaten Garut</li>
                <li>Puskesmas & RS rujukan HIV/AIDS</li>
                <li>Layanan Hotline Kemenkes RI</li>
                <li>Organisasi seperti PKBI, Spiritia, dll.</li>
            </ul>
        </x-hiv-card>

        {{-- Tambahan Baru --}}

        <x-hiv-card icon="bi-clock-history" title="Window Period & Deteksi HIV Awal" color="bg-light">
            <ul>
                <li><strong>Window Period:</strong> Masa setelah seseorang terinfeksi HIV tapi belum terdeteksi oleh tes.</li>
                <li>Biasanya berlangsung 2–12 minggu tergantung jenis tes.</li>
                <li>Selama periode ini, seseorang bisa menularkan HIV meski hasil tes negatif.</li>
                <li>Disarankan untuk tes ulang jika berisiko dan hasil awal negatif.</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-baby" title="Pencegahan Penularan Ibu ke Anak" color="bg-light">
            <ul>
                <li>Ibu hamil yang terinfeksi HIV bisa menularkan ke bayi saat hamil, melahirkan, atau menyusui.</li>
                <li>Dengan terapi ARV saat kehamilan, risiko penularan bisa ditekan di bawah 1%.</li>
                <li>Pemeriksaan HIV penting dilakukan pada ibu hamil sebagai bagian dari antenatal care.</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-bar-chart" title="Statistik HIV di Indonesia" color="bg-light">
            <ul>
                <li>Menurut data Kemenkes, sekitar 500.000 orang hidup dengan HIV di Indonesia (2024).</li>
                <li>Kelompok usia 25–49 tahun paling terdampak.</li>
                <li>Masih banyak yang belum terdiagnosis karena kurangnya tes dan stigma.</li>
            </ul>
        </x-hiv-card>

        <x-hiv-card icon="bi-heart-pulse" title="Dukungan Psikososial bagi ODHA" color="bg-light">
            <ul>
                <li>ODHA butuh dukungan emosional dari keluarga dan komunitas.</li>
                <li>Konseling rutin penting untuk menjaga kesehatan mental.</li>
                <li>Ada komunitas dan layanan dukungan seperti peer support dan hotline.</li>
            </ul>
        </x-hiv-card>

    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-5">
        <a href="{{ route('peta') }}" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Peta
        </a>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
