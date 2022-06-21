<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class DaftarMenuController extends Controller
{
    //
    public function index()
    {
        $data = [
            'menu' => Menu::all(),
        ];

        

        return view('template._sidebar', $data);
    }
}
