<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [
    		'title' => 'Absensi',
            'aktif' => 1
    	];

        return view('menu.menu', $data);
    }

    public function tambahMenu(Request $request)
    {
        $data = [
            'nama_menu' => $request->nama_menu
        ];
        Menu::create($data);
        return redirect(route('menu'))->with('sukses', 'Berhasil Tambah Menu');
    }

}
