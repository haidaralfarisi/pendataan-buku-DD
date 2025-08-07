<?php

namespace App\Http\Controllers\ortu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    public function index()
    {
        return view('ortu.beranda');
    }
}
