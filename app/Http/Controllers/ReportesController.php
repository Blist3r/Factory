<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function ventas() {
        return view('reportes.ventas');
    }
}
