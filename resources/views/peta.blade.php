@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <div class="row mb-3">
                <form id="filterForm" method="GET" action="{{ route('peta') }}">
                    <div class="col-lg-12 d-flex gap-3 align-items-end">
                        <!-- Dropdown Tahun -->
                        <div style="width: 250px;">
                            <label for="tahun" class="form-label">Filter Tahun</label>
                            <select name="tahun" id="tahun" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                @foreach($tahunList as $y)
                                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <!-- Dropdown Data -->
                        <div style="width: 250px;">
                            <label for="data_type" class="form-label">Pilih Data</label>
                            <select name="data_type" id="data_type" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="hiv" {{ $dataType === 'hiv' ? 'selected' : '' }}>HIV</option>
                                <option value="rumahsakit" {{ $dataType === 'rumahsakit' ? 'selected' : '' }}>Puskesmas</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            
            <div class="row">
                <!-- Peta -->
                <div class="col-lg-9 mb-4">
                    <h2 class="mb-3">
                        @if($dataType === 'hiv')
                            Peta Sebaran HIV di Kabupaten Garut Tahun {{ $tahun }}
                        @else
                            Peta Lokasi Puskesmas di Kabupaten Garut
                        @endif
                    </h2>
                    <div id="map" style="height: 500px; border: 1px solid #ccc; border-radius: 8px;"></div>
                </div>

                <!-- Sidebar Info -->
                <div class="col-lg-3">
                    <h4 class="mb-3">Informasi Sebaran</h4>
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Total Kecamatan:</strong> <span id="total-kecamatan">{{ $totalKecamatan ?? '-' }}</span></p>
                            <p><strong>Total Kasus:</strong> <span id="total-kasus">{{ $totalKasus ?? '-' }}</span></p>
                            @if($dataType === 'rumahsakit')
                                <p><strong>Total Puskesmas:</strong> <span id="total-rs">{{ $totalRs }}</span></p>
                            @endif
                            <hr>
                            <div id="list-kecamatan" style="min-height: 200px; overflow-y:auto; max-height: 400px;"></div>

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
</div>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const dataType = "{{ $dataType }}";
    const dataSebaran = @json($dataSebaran);
    const kecamatanList = @json($kecamatanList);
    const totalRs = {{ $totalRs ?? 0 }};
    const dataRs = @json($dataRs);
    const dataHiv = @json($dataHiv);

    const map = L.map('map').setView([-7.3797, 107.7611], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Pagination setup
    const itemsPerPage = 5;
    let currentPage = 1;

    function renderPagination() {
        const listContainer = document.getElementById('list-kecamatan');
        listContainer.innerHTML = '';

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const currentItems = kecamatanList.slice(start, end);

        currentItems.forEach(item => {
            const p = document.createElement('p');
            p.textContent = `${item.nama}: ${item.kasus} kasus`;
            listContainer.appendChild(p);
        });

        document.getElementById('prev-page').disabled = currentPage === 1;
        document.getElementById('next-page').disabled = end >= kecamatanList.length;
    }

    document.getElementById('prev-page').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderPagination();
        }
    });

    document.getElementById('next-page').addEventListener('click', () => {
        if ((currentPage * itemsPerPage) < kecamatanList.length) {
            currentPage++;
            renderPagination();
        }
    });

    renderPagination();

    if (dataType === 'hiv') {
        // Load GeoJSON untuk peta HIV
        fetch('/geojson/garut_kecamatan.geojson')
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    style: feature => {
                        const nama = feature.properties.nama.toLowerCase();
                        const kasus = dataSebaran[nama] || 0;
                        return {
                            color: "#333",
                            weight: 1,
                            fillColor: kasus > 20 ? "#d73027" :
                                      kasus > 10 ? "#fc8d59" :
                                      kasus > 0  ? "#fee08b" : "#d9ef8b",
                            fillOpacity: 0.7
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        const nama = feature.properties.nama;
                        const normalized = nama.toLowerCase();
                        const kasus = dataSebaran[normalized] || 0;

                        layer.on('mouseover', function (e) {
                            const popupContent = `<strong>${nama}</strong><br>Kasus: ${kasus}`;
                            const popup = L.popup({ closeButton: false, offset: L.point(0, -10) })
                                .setLatLng(e.latlng)
                                .setContent(popupContent)
                                .openOn(map);
                        });

                        layer.on('mouseout', function () {
                            map.closePopup();
                        });
                    }
                }).addTo(map);
            })
            .catch(error => {
                console.error("Gagal memuat GeoJSON:", error);
                alert("Gagal memuat peta. Pastikan file GeoJSON tersedia.");
            });

    } else if (dataType === 'rumahsakit') {
        // Marker Rumah Sakit
        dataRs.forEach(rs => {
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

        // Layer GeoJSON overlay HIV kasus di peta rumah sakit
        const dataKasus = dataHiv.reduce((obj, item) => {
            obj[item.kecamatan.toLowerCase()] = item.total_kasus;
            return obj;
        }, {});

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
                                      kasus > 0  ? '#fee08b' : '#d9ef8b',
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
                alert('Gagal memuat peta rumah sakit.');
            });
    }

</script>
@endpush
