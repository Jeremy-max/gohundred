<?php

namespace App\Http\Repository;

use App\User;
use App\Campaign;


class AdminUserTable
{
    public function getTableData()
    {
        $array = User::where('id', '>', '1')->get();
        $adminTable = [];
        foreach ($array as $index)
        {
            $campaign_cnt = Campaign::where('user_id',$index->id)->selectRaw('count(id) AS cnt')->first()->cnt;
            if($index->payment_status)
                $payment_status = $index->payment_status;
            else
                $payment_status = null;

            $item = [
                'id' => $index->id,
                'username' => $index->name,
                'email' => $index->email,
                'country' => $index->country,
                'login_fb' => $index->login_via_facebook,
                'login_gg' => $index->login_via_google,
                'payment_status' => $payment_status,
                'number_campaigns' => $campaign_cnt,
                'comment' => $index->comment,
                'date' => $index->created_at,

            ];
            array_push($adminTable, $item);
        }

        return $adminTable;
    }
}
