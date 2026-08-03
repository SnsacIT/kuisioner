<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{
    public function index()
    {
        if (session()->has('current_kuisioner_id')) {
            return redirect()->route('kuisioner.index')->with('info', 'Anda memiliki sesi pengisian kuisioner yang belum selesai. Anda diarahkan ke halaman terakhir Anda.');
        }
        
        return view('rules.index');
    }
}
