<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {

        $data = [
            'id_departemen' => $request->id_departemen
        ];
        return view('dashboard.dashboard',$data);
    }
}
