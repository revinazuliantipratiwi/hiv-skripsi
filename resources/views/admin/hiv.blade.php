@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white">
        <h5 class="mb-0">Data Kasus HIV</h5>
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.hiv') }}" method="GET" class="d-flex align-items-center gap-2 m-0">
                <label for="tahun" class="form-label mb-0 fw-semibold">Tahun:</label>
                <select name="tahun" id="tahun" class="form-select form-select-sm" style="width: 120px;" onchange="this.form.submit()">
                    
                    @foreach($tahunList as $th)
                        <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('admin.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Data
            </a>
            <a href="{{ route('admin.map', ['tahun' => request('tahun')]) }}" class="btn btn-outline-light btn-sm">
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

        {{-- Tabel Data Kasus --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Total Kasus</th>
                        <th>Tahun</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->kecamatan }}</td>
                            <td>{{ $item->total_kasus }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data kasus yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
