<?php

namespace App\Exports;

use App\Search;
use Maatwebsite\Excel\Concerns\FromCollection;

class SearchExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Search::all();
    }
}
