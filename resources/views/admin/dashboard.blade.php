@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Dashboard Admin</h4>

            {{-- Filter tahun --}}
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach(\App\Models\Hiv::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun') as $th)
                        <option value="{{ $th }}" {{ ($tahun ?? date('Y')) == $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <!-- Total Kasus -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="card-subtitle mb-1">Total Kasus Tahun {{ $tahun ?? date('Y') }}</h6>
                                    <h3 class="card-title fw-bold">{{ $totalKasus ?? 0 }}</h3>
                                </div>
                                <i class="bi bi-graph-up-arrow fs-2"></i>
                            </div>
                            <p class="card-text">Jumlah total kasus yang tercatat.</p>
                        </div>
                    </div>
                </div>

                <!-- Total Kecamatan -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="card-subtitle mb-1">Total Kecamatan Tahun {{ $tahun ?? date('Y') }}</h6>
                                    <h3 class="card-title fw-bold">{{ $totalKecamatan ?? 0 }}</h3>
                                </div>
                                <i class="bi bi-geo-alt-fill fs-2"></i>
                            </div>
                            <p class="card-text">Jumlah kecamatan yang terlibat.</p>
                        </div>
                    </div>
                </div>

                <!-- Total Rumah Sakit -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="card-subtitle mb-1">Puskesmas</h6>
                                    <h3 class="card-title fw-bold">{{ $totalRumahSakit ?? '-' }}</h3>
                                </div>
                                <i class="bi bi-hospital fs-2"></i>
                            </div>
                            <p class="card-text">Jumlah Puskesmas.</p>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>
@endsection
