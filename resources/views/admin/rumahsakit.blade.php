@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white">
        <h5 class="mb-0">Data Puskesmas</h5>
        <div>
            <a href="{{ route('admin.rumahsakitcreate') }}" class="btn btn-light btn-sm me-2">
                <i class="bi bi-plus-lg me-1"></i> Tambah Puskesmas
            </a>
            <a href="{{ route('admin.rumahsakit.map', ['tahun' => request()->get('tahun', date('Y'))]) }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-map me-1"></i> Lihat Peta
            </a>
        </div>
    </div>

    <div class="card-body">
        {{-- Tampilkan pesan sukses jika ada --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Data Rumah Sakit --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Puskesmas</th>
                        <th>Titik Koordinat</th>
                        <th class="text-center">Link Lokasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->titik_koordinat }}</td>
                            <td>{{ $item->link_maps }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.rumahsakitedit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.rumahsakitdestroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data Puskesmas ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data Puskesmas yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
