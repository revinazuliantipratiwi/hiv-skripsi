<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hiv;
use App\Models\RumahSakit;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class RekapitulasiController extends Controller
{
    public function index(Request $request)
{
    $dataType = $request->input('data_type', 'hiv');
    
    // Ambil daftar tahun unik dari database, urutkan desc (tahun terbaru paling atas)
    $tahunList = Hiv::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
    
    // Ambil tahun dari request, jika kosong gunakan tahun terakhir dari database
    $tahun = $request->input('tahun');
    if (!$tahun && $tahunList->isNotEmpty()) {
        $tahun = $tahunList->first(); // Tahun terakhir yang ada di database
    }

    $dataHiv = $dataRs = null;
    $totalKasus = 0;
    $totalRs = 0;

    if ($dataType === 'hiv') {
        $dataHiv = Hiv::where('tahun', $tahun)->get();
        $totalKasus = $dataHiv->sum('total_kasus'); // Hitung total kasus HIV
    } elseif ($dataType === 'rumahsakit') {
        $dataRs = RumahSakit::all();
        $totalRs = $dataRs->count(); // Hitung total rumah sakit
    }

    return view('admin.rekapitulasi', compact(
        'dataType',
        'tahun',
        'tahunList',
        'dataHiv',
        'totalKasus',
        'dataRs',
        'totalRs'
    ));
}
public function export(Request $request)
{
    $dataType = $request->input('data_type', 'hiv');

    // Ambil daftar tahun unik dari database
    $tahunList = Hiv::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

    // Ambil tahun dari request, jika kosong gunakan tahun terakhir dari database
    $tahun = $request->input('tahun');
    if (!$tahun && $tahunList->isNotEmpty()) {
        $tahun = $tahunList->first(); // Tahun terakhir yang ada di database
    }

    $format = $request->input('format', 'pdf');

    if ($dataType === 'hiv') {
        $data = Hiv::where('tahun', $tahun)->get();
        $totalKasus = $data->sum('total_kasus');

        if ($format === 'pdf') {
            $html = '
                <h3>Data Kasus HIV Tahun ' . $tahun . '</h3>
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kecamatan</th>
                            <th>Total Kasus</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($data as $index => $item) {
                $html .= '
                    <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . $item->kecamatan . '</td>
                        <td>' . $item->total_kasus . '</td>
                        <td>' . $item->tahun . '</td>
                    </tr>';
            }
            $html .= '
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:center;">Total Kasus</th>
                            <th>' . $totalKasus . '</th>
                        </tr>
                    </tfoot>
                </table>';

            $pdf = PDF::loadHTML($html);
            return $pdf->download("data_hiv_{$tahun}.pdf");

        } else {
            // Export ke Excel dengan merge cell dan style
            return Excel::download(new class($data, $totalKasus) implements FromArray, WithHeadings, \Maatwebsite\Excel\Concerns\WithEvents {
                private $data;
                private $totalKasus;

                public function __construct($data, $totalKasus)
                {
                    $this->data = $data;
                    $this->totalKasus = $totalKasus;
                }

                public function array(): array
                {
                    $result = [];
                    foreach ($this->data as $index => $item) {
                        $result[] = [
                            $index + 1,
                            $item->kecamatan,
                            $item->total_kasus,
                            $item->tahun,
                        ];
                    }

                    // Baris total: teks di merge A-C, nilai total di kolom D
                    $result[] = [
                        'Total Kasus', '', '', $this->totalKasus
                    ];
                    return $result;
                }

                public function headings(): array
                {
                    return ['No', 'Kecamatan', 'Total Kasus', 'Tahun'];
                }

                public function registerEvents(): array
                {
                    return [
                        \Maatwebsite\Excel\Events\AfterSheet::class => function(\Maatwebsite\Excel\Events\AfterSheet $event) {
                            $sheet = $event->sheet->getDelegate();
                            $lastRow = count($this->data) + 2; // +1 header +1 total row

                            // Merge kolom A sampai C (1-3)
                            $sheet->mergeCells("A{$lastRow}:C{$lastRow}");

                            // Center text "Total Kasus" (kolom A-C)
                            $sheet->getStyle("A{$lastRow}")
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                            // Bold untuk seluruh baris total
                            $sheet->getStyle("A{$lastRow}:D{$lastRow}")
                                ->getFont()
                                ->setBold(true);

                            // Right align untuk nilai total di kolom D
                            $sheet->getStyle("D{$lastRow}")
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        },
                    ];
                }
            }, "data_hiv_{$tahun}.xlsx");
        }

    } elseif ($dataType === 'rumahsakit') {
        $data = RumahSakit::all();
        $totalRs = $data->count();
    
        if ($format === 'pdf') {
            $html = '
                <h3>Data Rumah Sakit</h3>
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Rumah Sakit</th>
                            <th>Titik Koordinat</th>
                            <th>Link Maps</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($data as $index => $item) {
                $html .= '
                    <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . $item->nama . '</td>
                        <td>' . $item->titik_koordinat . '</td>
                        <td>' . $item->link_maps . '</td>
                    </tr>';
            }
    
            // Footer total rumah sakit
            $html .= '
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:center;">Total Rumah Sakit</th>
                            <th>' . $totalRs . '</th>
                        </tr>
                    </tfoot>
                </table>';
    
            $pdf = PDF::loadHTML($html);
            return $pdf->download("data_rumahsakit.pdf");
    
        } else {
            return Excel::download(new class($data, $totalRs) implements FromArray, WithHeadings, WithEvents {
                private $data;
                private $totalRs;
    
                public function __construct($data, $totalRs)
                {
                    $this->data = $data;
                    $this->totalRs = $totalRs;
                }
    
                public function array(): array
                {
                    $result = [];
                    foreach ($this->data as $index => $item) {
                        $result[] = [
                            $index + 1,
                            $item->nama,
                            $item->titik_koordinat,
                            $item->link_maps,
                        ];
                    }
    
                    // Tambahkan baris total di bawah data
                    $result[] = [
                        '', 'Total Rumah Sakit', '', $this->totalRs
                    ];
    
                    return $result;
                }
    
                public function headings(): array
                {
                    return ['No', 'Nama Rumah Sakit', 'Titik Koordinat', 'Link Maps'];
                }
    
                public function registerEvents(): array
{
    return [
        \Maatwebsite\Excel\Events\AfterSheet::class => function(\Maatwebsite\Excel\Events\AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();
            $lastRow = count($this->data) + 2; // +1 header +1 total row

            // Merge kolom B dan C (kolom 2 dan 3)
            $sheet->mergeCells("B{$lastRow}:C{$lastRow}");

            // Center text "Total Rumah Sakit" pada kolom B-C
            $sheet->getStyle("B{$lastRow}:C{$lastRow}")
                  ->getAlignment()
                  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Bold font untuk seluruh baris total (A-D)
            $sheet->getStyle("A{$lastRow}:D{$lastRow}")
                  ->getFont()
                  ->setBold(true);

            // Right align angka total di kolom D
            $sheet->getStyle("D{$lastRow}")
                  ->getAlignment()
                  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        },
    ];
}

            }, "data_rumahsakit.xlsx");
        }
    }
    
    return redirect()->back()->with('error', 'Tipe data tidak valid.');
}    

}
