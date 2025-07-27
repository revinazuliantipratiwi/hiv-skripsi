@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white">
        <h5 class="mb-0">Peta Lokasi Puskesmas & Kasus HIV</h5>
        <div class="d-flex align-items-center gap-3">
            <form id="filter-tahun" class="d-flex align-items-center gap-2 m-0">
                <label for="tahun" class="form-label mb-0 fw-semibold">Pilih Tahun:</label>
                <select name="tahun" id="tahun" class="form-select form-select-sm" style="width: 120px;">
                    @foreach($tahunList as $th)
                        <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.rumahsakit') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali 
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri: Peta -->
            <div class="col-md-8 mb-3 mb-md-0">
                <div id="map" style="height: 600px;"></div>
            </div>

            <!-- Kolom Kanan: Statistik -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Statistik Tahun {{ $tahun }}</h6>
                        <p><strong>Total Puskesmas:</strong> <span>{{ count($dataRs) }}</span></p>
                        <p><strong>Total Kasus HIV:</strong> <span>{{ $dataHiv->sum('total_kasus') }}</span></p>
                        <hr>
                        <p class="text-muted mb-0">Pilih tahun di atas untuk melihat penyebaran kasus HIV.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-popup-content-wrapper {
        font-size: 0.9rem;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const rumahSakitList = @json($dataRs);
    const dataKasus = @json($dataHiv->mapWithKeys(fn($item) => [strtolower($item->kecamatan) => $item->total_kasus]));

    const map = L.map('map').setView([-7.2, 107.9], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Titik Rumah Sakit
    rumahSakitList.forEach(rs => {
        if (!rs.titik_koordinat) return;

        const [lat, lng] = rs.titik_koordinat.split(',').map(coord => parseFloat(coord.trim()));

        if (!isNaN(lat) && !isNaN(lng)) {
            L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`
                    <strong>${rs.nama}</strong><br>
                    <a href="${rs.link_maps}" target="_blank">Lihat di Google Maps</a>
                `);
        }
    });

    // Layer GeoJSON Kasus HIV
    fetch('/geojson/garut_kecamatan.geojson')
        .then(res => {
            if (!res.ok) throw new Error('GeoJSON tidak ditemukan');
            return res.json();
        })
        .then(geojsonData => {
            L.geoJSON(geojsonData, {
                style: feature => {
                    const nama = feature.properties.nama.toLowerCase();
                    const kasus = dataKasus[nama] || 0;
                    return {
                        color: '#444',
                        weight: 1,
                        fillColor: kasus > 20 ? '#d73027' :
                                  kasus > 10 ? '#fc8d59' :
                                  kasus > 0  ? '#fee08b' :
                                               '#d9ef8b',
                        fillOpacity: 0.6
                    };
                },
                onEachFeature: (feature, layer) => {
                    const nama = feature.properties.nama;
                    const kasus = dataKasus[nama.toLowerCase()] || 0;
                    layer.bindPopup(`<strong>${nama}</strong><br>Kasus HIV: ${kasus}`);
                }
            }).addTo(map);
        })
        .catch(err => {
            console.error('Gagal memuat GeoJSON:', err);
            alert('Gagal memuat peta. Pastikan file GeoJSON tersedia di public/geojson/');
        });

    // Dropdown Tahun
    document.getElementById('tahun').addEventListener('change', function () {
        const tahunTerpilih = this.value;
        window.location.href = `{{ route('admin.rumahsakit.map') }}?tahun=${tahunTerpilih}`;
    });
</script>
@endpush
