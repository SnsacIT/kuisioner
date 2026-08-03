<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{
    public function index()
    {
        $kuisionerId = session('current_kuisioner_id');
        
        if ($kuisionerId) {
            $isValid = \App\Models\Kuisioner::find($kuisionerId);
            if ($isValid) {
                return redirect()->route('kuisioner.index')->with('info', 'Anda memiliki sesi pengisian kuisioner yang belum selesai. Anda diarahkan ke halaman terakhir Anda.');
            } else {
                // Sesi hantu (ada di memori tapi tidak di DB), hapus
                session()->forget('current_kuisioner_id');
            }
        }
        
        return view('rules.index');
    }
}
