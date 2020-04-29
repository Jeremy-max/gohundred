<?php

namespace App\Exports;

use App\Search;
use App\Keyword;

class SearchExcelExport
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
