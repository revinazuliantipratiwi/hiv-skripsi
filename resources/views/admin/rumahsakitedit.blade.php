@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Edit Data Puskesmas</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.rumahsakitupdate', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Puskesmas</label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $data->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="titik_koordinat" class="form-label">Titik Koordinat (Latitude,Longitude)</label>
                <input type="text" name="titik_koordinat" id="titik_koordinat" class="form-control @error('titik_koordinat') is-invalid @enderror"
                    value="{{ old('titik_koordinat', $data->titik_koordinat) }}" placeholder="-7.3797,107.7611" required>
                @error('titik_koordinat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="link_maps" class="form-label">Link Google Maps</label>
                <input type="url" name="link_maps" id="link_maps" class="form-control @error('link_maps') is-invalid @enderror"
                    value="{{ old('link_maps', $data->link_maps) }}" required>
                @error('link_maps')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
            <a href="{{ route('admin.rumahsakit') }}" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection
