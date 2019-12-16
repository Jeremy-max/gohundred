<?php

namespace App\Http\Controllers;
use App\Keyword;
use App\View;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __constructor()
    {
        $this->middleware(function($request, $next) {

            if(session('success_message')){
                Alert::success('Success!', session('success_message'));
            }
            else if(session('error_message')){
                Alert::success('Error!', session('error_message'));
            }

            return $next($request);
        });
    }
}
