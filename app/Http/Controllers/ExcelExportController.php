<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchExcelExport;
use App\Exports\AdminExcelExport;
use App\Keyword;

class ExcelExportController extends Controller
{
    public function export(Request $request)
    {

      $keyword_id = session('keyword_id');
      if($keyword_id == null)
      {
          $keyword_id = $request->get('keyword_id');
      }
      $keyword = Keyword::where('id', $keyword_id)->first()->keyword;
      $excelFileName = 'GoHundred - ' . $keyword . '.xlsx';

      return Excel::download(new SearchExcelExport, $excelFileName);
    }

    public function adminExport()
    {
      return Excel::download(new AdminExcelExport, 'AdminUserTable of GoHundred.xlsx');
    }
}
