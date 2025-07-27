<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hiv;

class HivController extends Controller
{
    /**
     * Tampilkan semua data HIV dengan filter tahun dan pagination.
     */
    public function index(Request $request)
    {
        // Ambil daftar tahun unik untuk dropdown filter, urut dari terbaru
        $tahunList = Hiv::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        // Ambil tahun dari query string jika ada, jika tidak, pakai tahun terbaru dari database
        $tahun = $request->input('tahun');
        if (!$tahun && $tahunList->isNotEmpty()) {
            $tahun = $tahunList->first();
        }

        // Ambil data berdasarkan tahun (jika ada), paginasi 10 per halaman
        $data = Hiv::when($tahun, fn($q) => $q->where('tahun', $tahun))
            ->orderBy('kecamatan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.hiv', compact('data', 'tahun', 'tahunList'));
    }

    /**
     * Tampilkan form untuk menambahkan data baru.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Simpan data baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kecamatan' => 'required|string|max:255',
            'total_kasus' => 'required|integer|min:0',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        Hiv::create($validated);

        return redirect()->route('admin.hiv')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit berdasarkan ID.
     */
    public function edit($id)
    {
        $data = Hiv::findOrFail($id);
        return view('admin.edit', compact('data'));
    }

    /**
     * Update data yang ada berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kecamatan' => 'required|string|max:255',
            'total_kasus' => 'required|integer|min:0',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $data = Hiv::findOrFail($id);
        $data->update($validated);

        return redirect()->route('admin.hiv')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Hapus data berdasarkan ID.
     */
    public function destroy($id)
    {
        $data = Hiv::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.hiv')->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Tampilkan data HIV dalam tampilan peta berdasarkan tahun.
     */
    public function map(Request $request)
    {
        // Ambil semua tahun yang tersedia di database (urutkan dari terbaru)
        $tahunList = Hiv::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Gunakan tahun dari input jika tersedia, jika tidak, pakai tahun terbaru dari database
        $tahun = $request->input('tahun');
        if (!$tahun && $tahunList->isNotEmpty()) {
            $tahun = $tahunList->first(); // tahun terbaru dari database
        }

        // Ambil data HIV untuk tahun tersebut
        $data = Hiv::where('tahun', $tahun)->get();

        return view('admin.map', compact('data', 'tahun', 'tahunList'));
    }
}
