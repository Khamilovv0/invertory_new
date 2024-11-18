<?php

namespace App\Exports;

use App\Models\in_product_lists;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return in_product_lists::all();
    }
}
