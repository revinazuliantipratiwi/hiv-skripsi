@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Edit Data Kasus HIV</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" 
                    value="{{ old('kecamatan', $data->kecamatan) }}" required>
                @error('kecamatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="total_kasus" class="form-label">Total Kasus</label>
                <input type="number" name="total_kasus" id="total_kasus" class="form-control @error('total_kasus') is-invalid @enderror" 
                    value="{{ old('total_kasus', $data->total_kasus) }}" min="0" required>
                @error('total_kasus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" 
                    value="{{ old('tahun', $data->tahun) }}" min="2000" max="{{ date('Y') }}" required>
                @error('tahun')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
            <a href="{{ route('admin.hiv') }}" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection
