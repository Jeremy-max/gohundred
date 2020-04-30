<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SearchExcelExport;
use App\Exports\AdminExcelExport;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Keyword;
use App\User;
use App\Search;

class ExcelExportController extends Controller
{
    public function export(Request $request)
    {
        $keyword_id = session('keyword_id');
        dd($keyword_id);
      $keyword = Keyword::where('id', $keyword_id)->first()->keyword;
      $excelFileName = 'GoHundred - ' . $keyword . '.xlsx';

      $sheets = Search::select('social_type', 'title', 'date', 'url', 'sentiment')->where('keyword_id', $keyword_id)->get();
      return (new FastExcel($sheets))->download($excelFileName);
    //   return Excel::download(new SearchExcelExport($keyword_id), $excelFileName);
    }

    public function adminExport()
    {
        $user = User::all('name', 'email', 'password', 'country','active', 'login_via_google', 'login_via_facebook','payment_status','comment' ,'created_at');
        return (new FastExcel($user))->download('AdminUserTable of GoHundred.xlsx');
    //   return Excel::download(new AdminExcelExport, 'AdminUserTable of GoHundred.xlsx');
    }
}
