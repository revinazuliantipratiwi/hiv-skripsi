@extends('layouts.admin')

@section('title', 'Tambah Data Kasus HIV')

@section('content')
<div class="card">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Tambah Data Kasus HIV</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <select name="kecamatan" id="kecamatan" class="form-select" required>
                    <option value="" disabled selected>Pilih Kecamatan</option>
                    {{-- Opsi akan diisi lewat JS --}}
                </select>
            </div>

            <div class="mb-3">
                <label for="total_kasus" class="form-label">Total Kasus</label>
                <input type="number" name="total_kasus" id="total_kasus" class="form-control" required min="0">
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="form-control" required min="1900" max="{{ date('Y') }}">
            </div>

            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('admin.hiv') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/geojson/garut_kecamatan.geojson')
            .then(response => response.json())
            .then(data => {
                const kecamatanSelect = document.getElementById('kecamatan');
                const kecamatanSet = new Set();

                data.features.forEach(feature => {
                    if (feature.properties && feature.properties.nama) {
                        const namaKecamatan = feature.properties.nama.trim();
                        if (!kecamatanSet.has(namaKecamatan)) {
                            kecamatanSet.add(namaKecamatan);
                            const option = document.createElement('option');
                            option.value = namaKecamatan;
                            option.textContent = namaKecamatan;
                            kecamatanSelect.appendChild(option);
                        }
                    }
                });
            })
            .catch(err => {
                console.error('Gagal memuat data kecamatan:', err);
            });
    });
</script>
@endpush
