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

        $user = User::where('nip', $request->input('nip'))->first();

        // $checkCabang = false;

        $checkCabang = DB::table('dealercabang')
            ->where('dealer', $user->dealer)
            ->where('cabang', $user->cabang)
            ->whereIn('area', ['Jawa Barat', 'Jawa Timur'])
            ->first();

        if (!(in_array($request->input('nip'), [
            '2406810823',
            '2405800798',
            '2210470339',
            '2510991176',
            '2411880970',
            '2103240111',
            '2301520411', // Jabodetabek
            '2409860923',
            '2406810828',
            '2208420290',
            '2405790784',
            '2406810827',
            '2408850911',
            '2211500382',
            '2002140055', // Makassar
            '2307650536',
            '0126061407',
            '0126061406',
            '2502911009',
            '2505941068',
            '2508971131',
            '2209470331',
            '0126041370',
            '2404790763',
            '2204370233',
            '2503921043',
            '26011011237',
            '0126031323',
            '2212140387',
            '2312740659',
            '2509981158',
            '2509981164',
            '26011011227',
            '2102220099',
            '2302540427',
            '2308670552',
            '26011011233',
            '2309680568',
            '2502911015',
            '2308670553',
            '2202350206',
            '25111001204',
            '0126061416',
            '2508971140',
            '2209460321',
            '0126071447',
            '0126021266',
            '2403780742',
            '2111290174', // Solo
            '2308210549',
            '2311730623',
            '2410870947',
            '2309700583',
            '0126031309',
            '0126041379',
            '2308670555',
            '2311720617',
            '2309700584',
            '2508971130',
            '0126021299',
            '2410870950',
            '2307630512',
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
            '2307630517',
            '2411880965',
            '2406820844',
            '0126021262'

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
