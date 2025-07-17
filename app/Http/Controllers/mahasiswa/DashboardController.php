<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard menggunakan data statis untuk fokus pada tampilan
        return view('mahasiswa.dashboard.index');
    }
}