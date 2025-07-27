@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Rekapitulasi Data</h5>
        <form method="GET" action="{{ route('admin.rekapitulasi') }}" class="d-flex align-items-center gap-3">
            {{-- Pilih tipe data --}}
            <select name="data_type" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="hiv" {{ request('data_type') == 'hiv' ? 'selected' : '' }}>Data HIV</option>
                <option value="rumahsakit" {{ request('data_type') == 'rumahsakit' ? 'selected' : '' }}>Data Puskesmas</option>
            </select>

            {{-- Pilih tahun jika HIV --}}
            @if(request('data_type', 'hiv') == 'hiv')
                <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach($tahunList as $th)
                        <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>
                            {{ $th }}
                        </option>
                    @endforeach
                </select>
            @endif
        </form>
    </div>

    <div class="card-body">
        {{-- Tombol Export --}}
        <div class="mb-3">
            @php
                $dataType = request('data_type', 'hiv');
                $exportParams = ['data_type' => $dataType];
                if ($dataType === 'hiv') $exportParams['tahun'] = $tahun;
            @endphp

            <a href="{{ route('admin.rekap.export', $exportParams + ['format' => 'pdf']) }}" class="btn btn-danger btn-sm me-2">
                <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
            </a>
            <a href="{{ route('admin.rekap.export', $exportParams + ['format' => 'excel']) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
            </a>
        </div>

        {{-- Tabel Data --}}
        @if($dataType == 'hiv')
            <h6>Data Kasus HIV Tahun {{ $tahun }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kecamatan</th>
                            <th>Total Kasus</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataHiv as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kecamatan }}</td>
                                <td>{{ $item->total_kasus }}</td>
                                <td>{{ $item->tahun }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data HIV pada tahun ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">Total Kasus</th>
                            <th>{{ $totalKasus }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <h6>Data Puskesmas</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Puskesmas</th>
                            <th>Titik Koordinat</th>
                            <th>Link Maps</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataRs as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->titik_koordinat }}</td>
                                <td>{{ $item->link_maps }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data Puskesmas tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">Total Puskesmas</th>
                            <th>{{ $totalRs }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
