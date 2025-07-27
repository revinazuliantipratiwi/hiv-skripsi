@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white">
        <h5 class="mb-0">Peta Penyebaran Kasus HIV Tahun {{ $tahun }}</h5>
        <div class="d-flex align-items-center gap-3">
            <form id="filter-tahun" class="d-flex align-items-center gap-2 m-0">
                <label for="tahun" class="form-label mb-0 fw-semibold">Pilih Tahun:</label>
                <select name="tahun" id="tahun" class="form-select form-select-sm" style="width: 120px;">
                    @foreach($tahunList as $th)
                        <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.hiv') }}" class="btn btn-light btn-sm">
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

            <!-- Kolom Kanan: List Kecamatan -->
            <div class="col-md-4">
                <h6 class="fw-semibold mb-3">Daftar Kecamatan & Kasus HIV ({{ $tahun }})</h6>

                <div class="card">
                    <div class="card-body">
                        <p><strong>Total Kecamatan:</strong> <span id="total-kecamatan">-</span></p>
                        <p><strong>Total Kasus:</strong> <span id="total-kasus">-</span></p>
                        <hr>
                        <div id="list-kecamatan" style="min-height: 200px;"></div>

                        <!-- Pagination Controls -->
                        <div id="pagination-controls" class="mt-3 d-flex justify-content-between">
                            <button id="prev-page" class="btn btn-sm btn-secondary">Sebelumnya</button>
                            <button id="next-page" class="btn btn-sm btn-secondary">Berikutnya</button>
                        </div>
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
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const dataKasus = @json($data->mapWithKeys(fn($item) => [strtolower($item->kecamatan) => $item->total_kasus]));
    const dataList = @json($data->values());

    const map = L.map('map').setView([-7.2, 107.9], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let totalKecamatan = 0;
    let totalKasus = 0;

    fetch('/geojson/garut_kecamatan.geojson')
        .then(res => {
            if (!res.ok) throw new Error('File GeoJSON tidak ditemukan!');
            return res.json();
        })
        .then(geojsonData => {
            L.geoJSON(geojsonData, {
                style: feature => {
                    const nama = feature.properties.nama.toLowerCase();
                    const kasus = dataKasus[nama] || 0;
                    return {
                        color: '#333',
                        weight: 1,
                        fillColor: kasus > 20 ? '#d73027' :
                                  kasus > 10 ? '#fc8d59' :
                                  kasus > 0 ? '#fee08b' :
                                  '#d9ef8b',
                        fillOpacity: 0.7
                    };
                },
                onEachFeature: (feature, layer) => {
                    const nama = feature.properties.nama;
                    const kasus = dataKasus[nama.toLowerCase()] || 0;

                    totalKecamatan++;
                    totalKasus += kasus;

                    layer.bindPopup(`<strong>${nama}</strong><br>Kasus: ${kasus}`);
                    layer.on('mouseover', () => layer.openPopup());
                    layer.on('mouseout', () => layer.closePopup());
                }
            }).addTo(map);

            document.getElementById('total-kecamatan').textContent = totalKecamatan;
            document.getElementById('total-kasus').textContent = totalKasus;
        })
        .catch(err => {
            console.error('Gagal memuat GeoJSON:', err);
            alert('Gagal memuat peta. Pastikan file GeoJSON tersedia di folder public/geojson.');
        });

    document.getElementById('tahun').addEventListener('change', function () {
        const tahunTerpilih = this.value;
        window.location.href = `{{ route('admin.map') }}?tahun=${tahunTerpilih}`;
    });

    // Paginasi manual
    const itemsPerPage = 10;
    let currentPage = 1;

    function renderList() {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const currentItems = dataList.slice(start, end);

        const container = document.getElementById('list-kecamatan');
        container.innerHTML = "";

        if (currentItems.length === 0) {
            container.innerHTML = "<p class='text-muted'>Tidak ada data tersedia.</p>";
            return;
        }

        const list = document.createElement('ul');
        list.className = 'list-group list-group-flush';

        currentItems.forEach((item, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `<span>${start + index + 1}. ${item.kecamatan}</span> <span class="badge bg-light text-dark">${item.total_kasus}</span>`;
            list.appendChild(li);
        });

        container.appendChild(list);
    }

    document.getElementById('prev-page').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderList();
        }
    });

    document.getElementById('next-page').addEventListener('click', () => {
        if (currentPage < Math.ceil(dataList.length / itemsPerPage)) {
            currentPage++;
            renderList();
        }
    });

    renderList();
</script>
@endpush
