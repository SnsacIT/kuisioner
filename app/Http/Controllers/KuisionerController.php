<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuisioner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KuisionerController extends Controller
{
    /**
     * Memulai kuisioner baru dari halaman aturan
     */
    public function start(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'checkJujur' => 'accepted',
        ], [
            'checkJujur.accepted' => 'Anda harus menyetujui aturan dan berjanji untuk mengisi dengan jujur.',
        ]);

        $nip = Auth::user()->nip;
        
        // Mengambil format tanggal dari input periode
        $periodeDate = $request->periode;

        // Simpan data awal kuisioner
        $kuisioner = Kuisioner::create([
            'nip' => $nip,
            'date' => $periodeDate,
            'confirm_statement' => true, // Karena checkbox dicentang sebelum submit
            'is_bersalah' => null, // Belum diisi
            'signature' => null, // Belum diisi
        ]);

        // Simpan ID kuisioner di session agar halaman selanjutnya tahu mana yang sedang diisi
        session(['current_kuisioner_id' => $kuisioner->id]);

        return redirect()->route('kuisioner.index');
    }

    /**
     * Menampilkan form halaman pertama pengisian kuisioner
     */
    public function index()
    {
        // Pastikan ada session kuisioner yang aktif, jika tidak, tendang balik ke halaman aturan
        if (!session()->has('current_kuisioner_id')) {
            return redirect()->route('rules.index')->with('error', 'Silakan mulai kuisioner dari awal.');
        }

        // Cek apakah sudah mengisi cabang
        $hasCabang = \App\Models\KuisionerCabang::where('kuisioner_id', session('current_kuisioner_id'))->exists();
        if ($hasCabang) {
            return redirect()->route('kuisioner.pertanyaan')->with('info', 'Anda sudah mengisi data cabang. Silakan lanjutkan mengisi pertanyaan.');
        }

        // Mengambil daftar cabang dari database
        $cabangs = \App\Models\DealerCabang::select('id', 'dealer', 'cabang')->orderBy('dealer')->get();
        
        // Mengambil daftar user (untuk mekanik & atl)
        $users = \App\Models\User::select('id', 'nip', 'nama')->whereNotNull('nip')->whereNull('deleted_at')->whereNotNull('nama')->orderBy('nama')->get();

        return view('kuisioner.index', compact('cabangs', 'users'));
    }

    /**
     * Menyimpan data cabang & mekanik ke tabel kuisioner_cabang
     */
    public function storeCabang(Request $request)
    {
        // Pastikan session kuisioner aktif
        if (!session()->has('current_kuisioner_id')) {
            return redirect()->route('rules.index')->with('error', 'Silakan mulai kuisioner dari awal.');
        }

        // Validasi input
        $request->validate([
            'cabang' => 'required|array|min:1',
            'cabang.*.dealercabang_id' => 'required|integer',
            'cabang.*.start_date' => 'required|date',
            'cabang.*.end_date' => 'required|date|after_or_equal:cabang.*.start_date',
            'cabang.*.mess' => 'required|string',
            'cabang.*.mekanik' => 'required|array|min:1',
            'cabang.*.atl' => 'required',
        ], [
            'cabang.required' => 'Minimal harus ada 1 data cabang.',
            'cabang.*.dealercabang_id.required' => 'Cabang harus dipilih.',
            'cabang.*.start_date.required' => 'Tanggal mulai harus diisi.',
            'cabang.*.end_date.required' => 'Tanggal selesai harus diisi.',
            'cabang.*.end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'cabang.*.mess.required' => 'Informasi mess harus diisi.',
            'cabang.*.mekanik.required' => 'Mekanik harus dipilih minimal 1.',
            'cabang.*.atl.required' => 'ATL harus dipilih.',
        ]);

        $kuisionerId = session('current_kuisioner_id');

        // Loop setiap blok cabang dan simpan ke database
        foreach ($request->cabang as $cabangData) {
            \App\Models\KuisionerCabang::create([
                'kuisioner_id' => $kuisionerId,
                'dealercabang_id' => $cabangData['dealercabang_id'],
                'start_date' => $cabangData['start_date'],
                'end_date' => $cabangData['end_date'],
                'mess' => $cabangData['mess'],
                'mekanik' => $cabangData['mekanik'], // Otomatis jadi JSON karena cast di model
                'atl' => $cabangData['atl'],
            ]);
        }

        // Redirect ke halaman pengisian pertanyaan
        return redirect()->route('kuisioner.pertanyaan')->with('success', 'Data cabang berhasil disimpan, silakan lanjut mengisi pertanyaan!');
    }

    /**
     * Menampilkan halaman pengisian pertanyaan
     */
    public function pertanyaan()
    {
        if (!session()->has('current_kuisioner_id')) {
            return redirect()->route('rules.index')->with('error', 'Silakan mulai kuisioner dari awal.');
        }

        $hasCabang = \App\Models\KuisionerCabang::where('kuisioner_id', session('current_kuisioner_id'))->exists();
        if (!$hasCabang) {
            return redirect()->route('kuisioner.index')->with('error', 'Silakan isi data cabang terlebih dahulu.');
        }

        return view('kuisioner.pertanyaan');
    }
}
