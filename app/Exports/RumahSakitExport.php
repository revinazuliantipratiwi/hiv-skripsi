<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RumahSakitExport implements FromArray, WithHeadings, WithEvents
{
    private $data;
    private $total;

    public function __construct($data)
    {
        $this->data = $data;
        $this->total = $data->count();
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
            'Total Rumah Sakit', // Ini akan ada di kolom 1, tapi nanti akan merge kol 1-3 jadi terlihat di tengah
            '',            // kolom 2
            '',            // kolom 3
            $this->totalKasus, // kolom 4 - total kasus
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
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = count($this->data) + 2; // 1 header + data rows + total row

                // Merge kolom A sampai C pada baris total
                $sheet->mergeCells("A{$lastRow}:C{$lastRow}");

                // Center align text pada sel yang di merge (A sampai C)
                $sheet->getStyle("A{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Bold font untuk baris total
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")
                    ->getFont()
                    ->setBold(true);

                // Right align angka total kasus di kolom D
                $sheet->getStyle("D{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
