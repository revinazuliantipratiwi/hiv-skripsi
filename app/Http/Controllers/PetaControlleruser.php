<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hiv;
use App\Models\RumahSakit;

class PetaControlleruser extends Controller
{
    public function index(Request $request)
{
    $dataType = $request->input('data_type', 'hiv');

    // Ambil list tahun untuk dropdown (urut terbaru duluan)
    $tahunList = Hiv::select('tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    // Ambil tahun dari request, jika tidak ada pakai tahun terakhir di database
    $tahun = $request->input('tahun');
    if (!$tahun) {
        $tahun = $tahunList->first(); // Default ke tahun terbaru dari database
    }

    $dataSebaran = [];
    $dataRs = collect();
    $totalRs = 0;
    $dataHiv = collect();
    $totalKecamatan = 0;
    $totalKasus = 0;
    $kecamatanList = [];

    if ($dataType === 'hiv') {
        $dataKasus = Hiv::select('kecamatan')
            ->selectRaw('SUM(total_kasus) as total_kasus')
            ->where('tahun', $tahun)
            ->groupBy('kecamatan')
            ->get();

        foreach ($dataKasus as $item) {
            $namaKec = strtolower($item->kecamatan);
            $jumlahKasus = (int) $item->total_kasus;

            $dataSebaran[$namaKec] = $jumlahKasus;
            $totalKecamatan++;
            $totalKasus += $jumlahKasus;

            $kecamatanList[] = [
                'nama' => $item->kecamatan,
                'kasus' => $jumlahKasus,
            ];
        }
    } elseif ($dataType === 'rumahsakit') {
        $dataRs = RumahSakit::select('nama', 'titik_koordinat', 'link_maps')->get();
        $totalRs = $dataRs->count();

        // Ambil data HIV untuk overlay peta rumah sakit (pakai tahun yang sama)
        $dataHiv = Hiv::select('kecamatan', 'total_kasus')
            ->where('tahun', $tahun)
            ->get();

        foreach ($dataHiv as $item) {
            $namaKec = strtolower($item->kecamatan);
            $jumlahKasus = (int) $item->total_kasus;

            $dataSebaran[$namaKec] = $jumlahKasus;
            $totalKecamatan++;
            $totalKasus += $jumlahKasus;

            $kecamatanList[] = [
                'nama' => $item->kecamatan,
                'kasus' => $jumlahKasus,
            ];
        }
    }

    return view('peta', compact(
        'dataType',
        'tahun',
        'tahunList',
        'dataSebaran',
        'dataRs',
        'totalRs',
        'dataHiv',
        'totalKecamatan',
        'totalKasus',
        'kecamatanList'
    ));
}

}
