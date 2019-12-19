<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Repository\AdminUserTable;

class AdminExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::all();

        // $table = new AdminUserTable;
        return User::all('name', 'email', 'password', 'country','active', 'login_via_google', 'login_via_facebook','payment_status','comment' ,'created_at');
    }
}
