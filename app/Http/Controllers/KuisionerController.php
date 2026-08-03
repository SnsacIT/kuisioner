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
        // Pastikan ada session kuisioner yang aktif dan valid di DB
        $kuisionerId = session('current_kuisioner_id');
        if (!$kuisionerId || !\App\Models\Kuisioner::find($kuisionerId)) {
            session()->forget('current_kuisioner_id');
            return redirect()->route('rules.index')->with('error', 'Sesi Anda telah kedaluwarsa atau tidak valid. Silakan mulai ulang.');
        }

        // Cek apakah sudah mengisi cabang pertama (penempatan saat ini)
        $hasCabang = \App\Models\KuisionerCabang::where('kuisioner_id', session('current_kuisioner_id'))->exists();
        if ($hasCabang) {
            return redirect()->route('kuisioner.historyCabang')->with('info', 'Anda sudah mengisi data cabang penempatan saat ini. Silakan tambahkan history cabang jika ada.');
        }

        // Mengambil daftar cabang dari database
        $cabangs = \App\Models\DealerCabang::select('id', 'dealer', 'cabang','nama_dealer')->whereNull('kode_kas')->orderBy('dealer')->get();
        
        // Mengambil daftar user (untuk mekanik & atl)
        $users = \App\Models\User::select('id', 'nip', 'nama')->whereNotNull('nip')->whereNull('delete_at')->whereNotNull('nama')->orderBy('nama')->get();

        return view('kuisioner.index', compact('cabangs', 'users'));
    }

    /**
     * Menyimpan data cabang & mekanik ke tabel kuisioner_cabang
     */
    public function storeCabang(Request $request)
    {
        // Pastikan session kuisioner aktif dan valid di DB
        $kuisionerId = session('current_kuisioner_id');
        if (!$kuisionerId || !\App\Models\Kuisioner::find($kuisionerId)) {
            session()->forget('current_kuisioner_id');
            return redirect()->route('rules.index')->with('error', 'Sesi Anda telah kedaluwarsa atau tidak valid. Silakan mulai ulang.');
        }

        // Validasi input cabang tunggal
        $request->validate([
            'dealercabang_id' => 'required|integer',
            'start_date' => 'required|date',
            'mess' => 'required|string',
            'mekanik' => 'required|string',
            'atl' => 'required|string',
        ], [
            'dealercabang_id.required' => 'Cabang harus dipilih.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'mess.required' => 'Informasi mess harus diisi.',
            'mekanik.required' => 'Mekanik harus diisi.',
            'atl.required' => 'ATL harus diisi.',
        ]);

        $kuisionerId = session('current_kuisioner_id');

        \App\Models\KuisionerCabang::create([
            'kuisioner_id' => $kuisionerId,
            'dealercabang_id' => $request->dealercabang_id,
            'start_date' => $request->start_date,
            'end_date' => null, // Penanda cabang saat ini
            'mess' => $request->mess,
            'mekanik' => $request->mekanik,
            'atl' => $request->atl,
        ]);

        return redirect()->route('kuisioner.historyCabang')->with('success', 'Data cabang penempatan saat ini berhasil disimpan.');
    }

    /**
     * Menampilkan form halaman history cabang
     */
    public function historyCabang()
    {
        $kuisionerId = session('current_kuisioner_id');
        if (!$kuisionerId || !\App\Models\Kuisioner::find($kuisionerId)) {
            session()->forget('current_kuisioner_id');
            return redirect()->route('rules.index')->with('error', 'Sesi Anda telah kedaluwarsa atau tidak valid. Silakan mulai ulang.');
        }

        $cabangs = \App\Models\DealerCabang::select('id', 'dealer', 'cabang','nama_dealer')->whereNull('kode_kas')->orderBy('dealer')->get();
        $users = \App\Models\User::select('id', 'nip', 'nama')->whereNotNull('nip')->whereNull('delete_at')->whereNotNull('nama')->orderBy('nama')->get();
        
        $currentCabang = \App\Models\KuisionerCabang::with('dealerCabang')
                            ->where('kuisioner_id', $kuisionerId)
                            ->whereNull('end_date')
                            ->first();

        return view('kuisioner.history', compact('cabangs', 'users', 'currentCabang'));
    }

    /**
     * Menyimpan history cabang
     */
    public function storeHistoryCabang(Request $request)
    {
        $kuisionerId = session('current_kuisioner_id');
        if (!$kuisionerId || !\App\Models\Kuisioner::find($kuisionerId)) {
            session()->forget('current_kuisioner_id');
            return redirect()->route('rules.index')->with('error', 'Sesi Anda telah kedaluwarsa atau tidak valid. Silakan mulai ulang.');
        }

        // Simpan jika pengguna mengirim array cabang (tidak menekan tombol Lewati)
        if ($request->has('cabang') && is_array($request->cabang) && count($request->cabang) > 0) {
            // Kita bisa membersihkan array kosong (jika ada form tersisa yang kosong)
            $cabangs = array_filter($request->cabang, function($c) {
                return !empty($c['dealercabang_id']);
            });

            if (count($cabangs) > 0) {
                $request->validate([
                    'cabang.*.dealercabang_id' => 'required|integer',
                    'cabang.*.start_date' => 'required|date',
                    'cabang.*.end_date' => 'required|date|after_or_equal:cabang.*.start_date',
                    'cabang.*.mess' => 'required|string',
                    'cabang.*.mekanik' => 'required|string',
                    'cabang.*.atl' => 'required|string',
                ]);

                foreach ($cabangs as $cabangData) {
                    \App\Models\KuisionerCabang::create([
                        'kuisioner_id' => $kuisionerId,
                        'dealercabang_id' => $cabangData['dealercabang_id'],
                        'start_date' => $cabangData['start_date'],
                        'end_date' => $cabangData['end_date'],
                        'mess' => $cabangData['mess'],
                        'mekanik' => $cabangData['mekanik'],
                        'atl' => $cabangData['atl'],
                    ]);
                }
            }
        }

        return redirect()->route('kuisioner.pertanyaan')->with('success', 'Pengisian profil cabang selesai, silakan mulai kuesioner!');
    }

    /**
     * Menampilkan halaman pengisian pertanyaan
     */
    public function pertanyaan()
    {
        // Pastikan session kuisioner aktif dan valid di DB
        $kuisionerId = session('current_kuisioner_id');
        if (!$kuisionerId || !\App\Models\Kuisioner::find($kuisionerId)) {
            session()->forget('current_kuisioner_id');
            return redirect()->route('rules.index')->with('error', 'Sesi Anda telah kedaluwarsa atau tidak valid. Silakan mulai ulang.');
        }

        $kuisionerCabangs = \App\Models\KuisionerCabang::with(['dealerCabang', 'jawaban'])->where('kuisioner_id', session('current_kuisioner_id'))->get();
        if ($kuisionerCabangs->isEmpty()) {
            return redirect()->route('kuisioner.index')->with('error', 'Silakan isi data cabang terlebih dahulu sebelum melanjutkan ke pertanyaan.');
        }

        // Ambil semua pertanyaan dari database
        $pertanyaans = \App\Models\Pertanyaan::all();

        return view('kuisioner.pertanyaan', compact('pertanyaans', 'kuisionerCabangs'));
    }

    public function storeCabangJawaban(Request $request)
    {
        $kuisionerId = session('current_kuisioner_id');
        if (!$kuisionerId) {
            return response()->json(['success' => false, 'message' => 'Sesi kedaluwarsa.'], 403);
        }

        $cid = $request->cid;
        $cabang = \App\Models\KuisionerCabang::where('id', $cid)->where('kuisioner_id', $kuisionerId)->first();
        if (!$cabang) {
            return response()->json(['success' => false, 'message' => 'Cabang tidak valid.'], 404);
        }

        // Simpan KuisionerJawaban
        $jawabanParent = \App\Models\KuisionerJawaban::updateOrCreate(
            ['kuisioner_cabang_id' => $cid],
            [
                'is_melakukan' => $request->is_melakukan === '1' ? true : false,
                'is_mengetahui' => $request->is_mengetahui === '1' ? true : ($request->is_mengetahui === '0' ? false : null),
                'is_mengetahui2' => $request->is_mengetahui2 === '1' ? true : ($request->is_mengetahui2 === '0' ? false : null),
            ]
        );

        // Hapus item lama jika update
        \App\Models\KuisionerJawabanItem::where('jawaban_id', $jawabanParent->id)->delete();

        if ($request->has('jawaban') && is_array($request->jawaban)) {
            foreach ($request->jawaban as $qId => $ans) {
                $ansVal = is_array($ans) ? json_encode($ans) : $ans;
                $descVal = $request->deskripsi[$qId] ?? null;

                \App\Models\KuisionerJawabanItem::create([
                    'jawaban_id' => $jawabanParent->id,
                    'pertanyaan_id' => $qId,
                    'jawaban' => $ansVal,
                    'description' => $descVal,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function submitAll(Request $request)
    {
        $kuisionerId = session('current_kuisioner_id');
        if ($kuisionerId) {
            $kuisioner = \App\Models\Kuisioner::find($kuisionerId);
            if ($kuisioner) {
                $kuisioner->update([
                    'saran_perbaikan' => $request->saran_perbaikan,
                ]);
            }
            // Tandai selesai, misal hapus session
            session()->forget('current_kuisioner_id');
        }

        return redirect()->route('rules.index')->with('success', 'Terima kasih. Seluruh informasi dan pernyataan Anda telah tersimpan. Informasi tersebut akan dijaga kerahasiaannya dan digunakan untuk proses verifikasi, pemeriksaan, serta perbaikan internal sesuai ketentuan yang berlaku.');
    }
}
