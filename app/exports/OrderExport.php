<?php

namespace App\Exports;

use App\Models\Letter;
use App\Models\Letter_type;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // func collection : proses pengambilan data yang akan ditampilkan di excel
    public function query()
    {
        return Letter_type::query();
    }


    public function map($letter_type):array
    {
        return[
            $letter_type->letter_code,
            $letter_type->name_type,
            $letter_type->letterType->count()
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Surat',
            'Klasifikasi Surat',
            'Surat Tertaut'
        ];
    }
}
