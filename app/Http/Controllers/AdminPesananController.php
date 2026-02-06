<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function manajemenpesanan(){
        return view('ManajemenPesanan');
    }
}
