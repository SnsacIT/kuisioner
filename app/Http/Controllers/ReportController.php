<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function getData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $where = "WHERE 1=1";
        $bindings = [];
        
        if (!empty($startDate)) {
            $where .= " AND DATE(kc.created_at) >= ?";
            $bindings[] = $startDate;
        }
        
        if (!empty($endDate)) {
            $where .= " AND DATE(kc.created_at) <= ?";
            $bindings[] = $endDate;
        }

        $data = DB::select("SELECT
                kc.id,
                kc.kuisioner_id,
                k.nip as `NIP Pengisi`,
                u.nama as `Nama Pengisi`,
                CASE
                    WHEN u.role = 0 THEN 'Mekanik'
                    WHEN u.role = 1 THEN 'ATL'
                    WHEN u.role = 2 THEN 'SOH'
                    WHEN u.role = 3 THEN 'Back Office'
                    ELSE ''
                END AS role,
                dc.dealer,
                dc.cabang,
                dc.nama_dealer,
                COALESCE(kc.start_date,'') as `Mulai Waktu Penempatan`,
                COALESCE(kc.end_date,'') as `Selesai Waktu Penempatan`,
                kc.mess,
                kc.atl as `ATL`,
                COALESCE(MAX(CASE WHEN p.id = 1 THEN kji.jawaban END),'') AS `Tindakan apa yang pernah Anda lakukan atau bantu lakukan?`,
                COALESCE(MAX(CASE WHEN p.id = 1 THEN kji.description END),'') AS `Tindakan apa yang pernah Anda lakukan atau bantu lakukan? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 2 THEN kji.jawaban END),'') AS `Kapan pertama kali Anda melakukan tindakan tersebut?`,
                COALESCE(MAX(CASE WHEN p.id = 2 THEN kji.description END),'') AS `Kapan pertama kali Anda melakukan tindakan tersebut? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 3 THEN kji.jawaban END),'') AS `Kapan terakhir kali Anda melakukannya?`,
                COALESCE(MAX(CASE WHEN p.id = 3 THEN kji.description END),'') AS `Kapan terakhir kali Anda melakukannya? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 4 THEN kji.jawaban END),'') AS `Berapa kali tindakan tersebut dilakukan?`,
                COALESCE(MAX(CASE WHEN p.id = 4 THEN kji.description END),'') AS `Berapa kali tindakan tersebut dilakukan? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 5 THEN kji.jawaban END),'') AS `Siapa saja yang terlibat?`,
                COALESCE(MAX(CASE WHEN p.id = 5 THEN kji.description END),'') AS `Siapa saja yang terlibat? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 6 THEN kji.jawaban END),'') AS `Jelaskan bagaimana tindakan tersebut dilakukan dari awal sampai selesai.`,
                COALESCE(MAX(CASE WHEN p.id = 6 THEN kji.description END),'') AS `Jelaskan bagaimana tindakan tersebut dilakukan dari awal sampai selesai. (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 7 THEN kji.jawaban END),'') AS `Apa alasan Anda melakukan tindakan tersebut?`,
                COALESCE(MAX(CASE WHEN p.id = 7 THEN kji.description END),'') AS `Apa alasan Anda melakukan tindakan tersebut? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 8 THEN kji.jawaban END),'') AS `Apa barang, material, atau pekerjaan yang terkait?`,
                COALESCE(MAX(CASE WHEN p.id = 8 THEN kji.description END),'') AS `Apa barang, material, atau pekerjaan yang terkait? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 9 THEN kji.jawaban END),'') AS `Berapa jumlahnya?`,
                COALESCE(MAX(CASE WHEN p.id = 9 THEN kji.description END),'') AS `Berapa jumlahnya? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 10 THEN kji.jawaban END),'') AS `Berapa nilai yang diterima untuk setiap transaksi?`,
                COALESCE(MAX(CASE WHEN p.id = 10 THEN kji.description END),'') AS `Berapa nilai yang diterima untuk setiap transaksi? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 11 THEN kji.jawaban END),'') AS `Berapa perkiraan total nilai yang Anda terima?`,
                COALESCE(MAX(CASE WHEN p.id = 11 THEN kji.description END),'') AS `Berapa perkiraan total nilai yang Anda terima? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 12 THEN kji.jawaban END),'') AS `Apakah hasil tersebut dibagi dengan pihak lain?`,
                COALESCE(MAX(CASE WHEN p.id = 12 THEN kji.description END),'') AS `Apakah hasil tersebut dibagi dengan pihak lain? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 13 THEN kji.jawaban END),'') AS `Menurut pengetahuan Anda, apakah ATL mengetahui tindakan tersebut?`,
                COALESCE(MAX(CASE WHEN p.id = 13 THEN kji.description END),'') AS `Menurut pengetahuan Anda, apakah ATL mengetahui tindakan tersebut? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 14 THEN kji.jawaban END),'') AS `Apakah SA atau pihak dealer lainnya mengetahui atau terlibat?`,
                COALESCE(MAX(CASE WHEN p.id = 14 THEN kji.description END),'') AS `Apakah SA atau pihak dealer lainnya mengetahui atau terlibat? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 15 THEN kji.jawaban END),'') AS `Apakah masih terdapat informasi atau bukti yang berkaitan dengan tindakan tersebut?`,
                COALESCE(MAX(CASE WHEN p.id = 15 THEN kji.description END),'') AS `Apakah masih terdapat informasi atau bukti yang berkaitan dengan tindakan tersebut? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 16 THEN kji.jawaban END),'') AS `Apa tindakan atau kejadian yang Anda ketahui?`,
                COALESCE(MAX(CASE WHEN p.id = 16 THEN kji.description END),'') AS `Apa tindakan atau kejadian yang Anda ketahui? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 17 THEN kji.jawaban END),'') AS `Kapan dan di mana kejadian tersebut terjadi?`,
                COALESCE(MAX(CASE WHEN p.id = 17 THEN kji.description END),'') AS `Kapan dan di mana kejadian tersebut terjadi? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 18 THEN kji.jawaban END),'') AS `Siapa saja yang terlibat?`,
                COALESCE(MAX(CASE WHEN p.id = 18 THEN kji.description END),'') AS `Siapa saja yang terlibat? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 19 THEN kji.jawaban END),'') AS `Bagaimana kejadiannya?`,
                COALESCE(MAX(CASE WHEN p.id = 19 THEN kji.description END),'') AS `Bagaimana kejadiannya? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 20 THEN kji.jawaban END),'') AS `Bagaimana Anda dapat mengetahui kejadian tersebut?`,
                COALESCE(MAX(CASE WHEN p.id = 20 THEN kji.description END),'') AS `Bagaimana Anda dapat mengetahui kejadian tersebut? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 21 THEN kji.jawaban END),'') AS `Berapa jumlah dan nilai yang Anda ketahui?`,
                COALESCE(MAX(CASE WHEN p.id = 21 THEN kji.description END),'') AS `Berapa jumlah dan nilai yang Anda ketahui? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 22 THEN kji.jawaban END),'') AS `Apakah Anda pernah menyampaikan informasi tersebut kepada pihak lain?`,
                COALESCE(MAX(CASE WHEN p.id = 22 THEN kji.description END),'') AS `Apakah Anda pernah menyampaikan informasi tersebut kepada pihak lain? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 23 THEN kji.jawaban END),'') AS `Informasi apa yang Anda dengar?`,
                COALESCE(MAX(CASE WHEN p.id = 23 THEN kji.description END),'') AS `Informasi apa yang Anda dengar? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 24 THEN kji.jawaban END),'') AS `Dari siapa Anda mendengarnya?`,
                COALESCE(MAX(CASE WHEN p.id = 24 THEN kji.description END),'') AS `Dari siapa Anda mendengarnya? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 25 THEN kji.jawaban END),'') AS `Kapan informasi disampaikan?`,
                COALESCE(MAX(CASE WHEN p.id = 25 THEN kji.description END),'') AS `Kapan informasi disampaikan? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 26 THEN kji.jawaban END),'') AS `Apakah Anda pernah melihat atau memverifikasi sendiri?`,
                COALESCE(MAX(CASE WHEN p.id = 26 THEN kji.description END),'') AS `Apakah Anda pernah melihat atau memverifikasi sendiri? (desc)`,
                COALESCE(MAX(CASE WHEN p.id = 27 THEN kji.jawaban END),'') AS `Apakah terdapat pihak lain yang dapat mengonfirmasi?`,
                COALESCE(MAX(CASE WHEN p.id = 27 THEN kji.description END),'') AS `Apakah terdapat pihak lain yang dapat mengonfirmasi? (desc)`,
                COALESCE(k.saran_perbaikan, '') as saran_perbaikan,
                MAX(kc.created_at) as waktu_mulai,
                MAX(kc.updated_at) as waktu_selesai
            FROM kuisioner_cabang AS kc
            JOIN kuisioner AS k ON k.id = kc.kuisioner_id
            /* Memaksa collation agar sama untuk menghindari Error 1267 Illegal mix of collations saat membandingkan tipe teks (NIP) */
            JOIN users AS u ON u.nip COLLATE utf8mb4_unicode_ci = k.nip COLLATE utf8mb4_unicode_ci
            JOIN dealercabang AS dc ON dc.id = kc.dealercabang_id
            LEFT JOIN kuisioner_jawaban AS kj ON kj.kuisioner_cabang_id = kc.id
            LEFT JOIN kuisioner_jawaban_item AS kji ON kji.jawaban_id = kj.id
            LEFT JOIN pertanyaan AS p ON p.id = kji.pertanyaan_id
            $where
            GROUP BY
                kc.id,
                kc.kuisioner_id,
                k.nip,
                u.nama,
                u.role,
                dc.nama_dealer,
                dc.dealer,
                dc.cabang,
                kc.start_date,
                kc.end_date,
                kc.mess,
                kc.atl,
                k.saran_perbaikan,
                kc.dealercabang_id
        ", $bindings);

        $columns = [];
        if (!empty($data)) {
            // Sanitize keys to remove periods (which DataTables interprets as nested objects)
            $safeData = [];
            foreach ($data as $row) {
                $safeRow = [];
                foreach ((array)$row as $key => $val) {
                    $safeKey = str_replace(['.', '[', ']'], '', $key);
                    $safeRow[$safeKey] = $val;
                }
                $safeData[] = $safeRow;
            }
            $data = $safeData;

            foreach (array_keys($data[0]) as $key) {
                $columns[] = [
                    'data' => $key,
                    'name' => $key,
                    'title' => ucwords(str_replace('_', ' ', $key)),
                ];
            }
        }

        return response()->json([
            'data' => $data,
            'columns' => $columns
        ]);
    }

}
