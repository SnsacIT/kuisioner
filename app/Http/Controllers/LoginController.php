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
            ->whereIn('area', ['Jawa Barat','Jawa Timur'])
            ->first();

        if (!(in_array($request->input('nip'), [
            '2501900992',
            '1910130044',
            '2002140052',
            '2404790765',
            '2408850910',
            '2007150056',
            '2510991175',
            '2105260127',
            '2405800810',
            '2305580464',
            '2501901007',
            '2308670554',
            '2404790767',
            '2111300168',
            // '0126041365',
            // '2401760693',
            // '2408850912',
            // '2310710594',
            // '26011011232',
            // '2407830869',
            // '2408850911',
            '12345678903',
            '2309680570',
            '2202350215',
            // '2401280699',
            '2405800801',
            '0321090006',
            '0323050015',
            '2209450316',
            '2112300164',
            '4122100002',
            '1708000001',
            '2212510398',
            '2409860932',
            '2402770720',
            '0126061408',
            // '2205390254',
            // '2504931056',
            // '0126031310',
            // '2307630518',
            // '2209470329',
            // '2002140051',
            // '1712050011',
            // '2103230103',
            // '2309680569',
            // '2411880964',
            // '2503921039',
            // '2406820843',
            // '2412390986',
            // '2111300167',
            // '2207110286',
            // '2506951091',
            // '2211500378',
            // '25111001203',
            // '0126031324',
            // '2102210098',
            // '2204370238',
            // '0126061398',
            // '2002140054',
            // '2306610502',
            // '0126031326',
            // '1708010003',
            // '2206400275',
            // '2007150058',
            // '2405800809',
            // '2405320785',
            // '2203360230',
            // '2401760689',
            // '2501900998',
            // '2105260125',
            // '2007150056',
            // '1910130047',
            // '2009170067',
            // '1710030008',
            // '1810090025',
            // '1910130045',
            // '1710030007',
            // '2209460319',
            // '2401750674',
            '24100300001', // BackofficeDummy
            '24100300002', // BackofficeDummy02
            '24100300003', // BackofficeDummy03
            '24100300004', // BackofficeDummy04
            '2401760691',
            '2307650534',
            '2109280137', //Wahyu SOH
            '2402770728', //Agus Kuncoro

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
