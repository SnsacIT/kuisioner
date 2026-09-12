<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.guest');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|numeric',
            'password' => 'required|string',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->has('remember');

        // $user = User::where('nip', $request->input('nip'))->first();

        $checkCabang = false;

        // $checkCabang = DB::table('dealercabang')
        //     ->where('dealer', $user->dealer)
        //     ->where('cabang', $user->cabang)
        //     ->whereIn('area', ['Jawa Barat', 'Jawa Timur'])
        //     ->first();

        if (!(in_array($request->input('nip'), [
            '2402770712', // Palu
            '2305570447',
            '0126041368',
            '2208430304',
            '2502911010',
            '2302540424',
            '2311720613',
            '1912140048',
            '2408840888',
            '2509981163',
            '12345678903', //Tester & Watcher
            '2309680570',
            '2202350215',
            '0321090006',
            '0323050015',
            '2209450316',
            '2112300164',
            '4122100002',
            '1708000001',
            '2212510398',
            '2407830880',
            '24100300001', // BackofficeDummy
            '24100300002', // BackofficeDummy02
            '24100300003', // BackofficeDummy03
            '24100300004', // BackofficeDummy04
            '2109280137', //Wahyu SOH
            '2402770728', //Agus Kuncoro,
            '1708010004', // Reta SOH
            '2505941076', // mba amdjoti
            '2408850916', // mas rio
        ]) || $checkCabang)) {
            return back()->withErrors([
                'nip' => 'Anda tidak memiliki akses.',
            ]);
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('rules.index'));
        }

        return back()->withErrors([
            'nip' => 'NIP atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
