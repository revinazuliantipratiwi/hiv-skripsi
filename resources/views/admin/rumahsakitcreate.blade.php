@extends('layouts.admin')

@section('title', 'Tambah Data Puskesmas')

@section('content')
<div class="card">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Tambah Data Puskesmas</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.rumahsakitstore') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Puskesmas</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="titik_koordinat" class="form-label">Titik Koordinat (Latitude,Longitude)</label>
                <input type="text" name="titik_koordinat" id="titik_koordinat" class="form-control" placeholder="-7.3797,107.7611" required>
            </div>

            <div class="mb-3">
                <label for="link_maps" class="form-label">Link Google Maps</label>
                <input type="url" name="link_maps" id="link_maps" class="form-control" placeholder="https://maps.google.com/?q=-7.3797,107.7611" required>
            </div>

            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('admin.rumahsakit') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
