<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hiv;
use App\Models\RumahSakit;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        // Ambil list tahun HIV dari database (urutkan descending)
        $tahunList = Hiv::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Cek input dari user, jika tidak ada, pakai tahun terbaru dari database
        $tahun = $request->input('tahun');
        if (!$tahun) {
            $tahun = $tahunList->first(); // Gunakan tahun terakhir yang tersedia
        }

        // Total kasus HIV di tahun tersebut
        $totalKasus = Hiv::where('tahun', $tahun)->sum('total_kasus');

        // Total kecamatan dengan data kasus HIV
        $totalKecamatan = Hiv::where('tahun', $tahun)->distinct('kecamatan')->count('kecamatan');

        // Total rumah sakit rujukan (seluruh data)
        $totalRumahSakit = RumahSakit::count();

        return view('admin.dashboard', compact('totalKasus', 'totalKecamatan', 'totalRumahSakit', 'tahun', 'tahunList'));
    }
}
