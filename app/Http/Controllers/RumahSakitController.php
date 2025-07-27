<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;
use App\Models\Hiv;

class RumahSakitController extends Controller
{
    /**
     * Tampilkan semua data rumah sakit.
     */
    public function index()
    {
        $data = RumahSakit::paginate(10);
        return view('admin.rumahsakit', compact('data'));
    }

    /**
     * Tampilkan form untuk menambahkan data rumah sakit.
     */
    public function create()
    {
        return view('admin.rumahsakitcreate');
    }

    /**
     * Simpan data rumah sakit baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'titik_koordinat' => 'required|string|regex:/^-?\d+\.\d+,\s*-?\d+\.\d+$/',
            'link_maps' => 'required|url',
        ]);

        RumahSakit::create($validated);

        return redirect()->route('admin.rumahsakit')->with('success', 'Data rumah sakit berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit berdasarkan ID rumah sakit.
     */
    public function edit($id)
    {
        $data = RumahSakit::findOrFail($id);
        return view('admin.rumahsakitedit', compact('data'));
    }

    /**
     * Update data rumah sakit berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'titik_koordinat' => 'required|string|regex:/^-?\d+\.\d+,\s*-?\d+\.\d+$/',
            'link_maps' => 'required|url',
        ]);

        $data = RumahSakit::findOrFail($id);
        $data->update($validated);

        return redirect()->route('admin.rumahsakit')->with('success', 'Data rumah sakit berhasil diperbarui.');
    }

    /**
     * Hapus data rumah sakit berdasarkan ID.
     */
    public function destroy($id)
    {
        $data = RumahSakit::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.rumahsakit')->with('success', 'Data rumah sakit berhasil dihapus.');
    }

    public function map(Request $request)
{
    // Ambil list tahun unik dari tabel HIV, urutkan dari terbaru
    $tahunList = Hiv::select('tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    // Ambil tahun dari request, jika tidak ada atau tidak valid, gunakan tahun terakhir dari database
    $tahun = $request->input('tahun');

    // Jika tidak ada input tahun atau input tahun tidak ada di list, fallback ke tahun terbaru
    if (!$tahun || !$tahunList->contains($tahun)) {
        $tahun = $tahunList->first(); // Tahun terbaru dari database
    }

    // Ambil semua data rumah sakit
    $dataRs = RumahSakit::all();

    // Ambil data HIV sesuai tahun
    $dataHiv = Hiv::where('tahun', $tahun)->get();

    // Kirim ke view
    return view('admin.petarumahsakit', compact('dataRs', 'dataHiv', 'tahunList', 'tahun'));
}


}
