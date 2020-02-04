<?php

namespace App\Exports;

use App\Search;
use App\Keyword;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SearchExcelExport implements FromCollection ,WithHeadings
{
    protected $keyword_id;

    public function __construct($keyword_id)
    {
       $this->keyword_id = $keyword_id;
    }

    public function headings(): array
    {
        return [
            'Social type', 'Title', 'Date', 'URL'
        ];
    }

    public function collection()
    {

        return Search::select('social_type', 'title', 'date', 'url')
        ->where('keyword_id', $this->keyword_id)
        ->get();
    }
}
