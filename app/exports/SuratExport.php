<?php

namespace App\Exports;

use App\Models\Letter;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratExport implements FromCollection, WithHeadings, WithMapping,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Letter::with('Letter')->get();

    }

    public function headings(): array
    {
        return [
            "Nomor Surat", "Perihal", "Tanggal Keluar", "Penerima Surat", "Notulis"
        ];
    }

    public function map($item): array
    {
        setlocale(LC_ALL, 'IND');

        $tanggal = Carbon::parse($item->Letter->created_at)->formatLocalized('%d %B %Y');
        $dataresult = [];
        foreach ($item['recipients'] as $a) {
            $data = $a['name'];
            array_push($dataresult, $data);
        }

        $penerimaSurat = implode(', ', $dataresult);

        return [
            $item->Letter->letter_code,
            $item->Letter->name_type,
            $tanggal,
            $penerimaSurat,
            $item->user->name,
        ];
    }


}
