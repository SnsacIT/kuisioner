<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function index()
    {
        return view('status.index');
    }

    public function getData(Request $request)
    {
        $tanggal = $request->query('tanggal');
        
        $where = "WHERE 1=1";
        $bindings = [];
        
        if (!empty($tanggal)) {
            $where .= " AND DATE(kuisioner.created_at) = ?";
            $bindings[] = $tanggal;
        }

        $data = DB::select("SELECT 
                users.nip AS `NIP`, 
                users.nama AS `Nama`,
                CASE
                    WHEN users.role = 0 THEN 'Mekanik'
                    WHEN users.role = 1 THEN 'ATL'
                    WHEN users.role = 2 THEN 'SOH'
                    WHEN users.role = 3 THEN 'Back Office'
                    ELSE ''
                END AS `Role`, 
                MAX(kuisioner.created_at) AS `Waktu Pengisian`,
                CASE WHEN MAX(kuisioner.saran_perbaikan) IS NOT NULL THEN 'Selesai' ELSE 'Belum Selesai' END as `Status` 
            FROM kuisioner 
            JOIN users ON users.nip COLLATE utf8mb4_unicode_ci = kuisioner.nip COLLATE utf8mb4_unicode_ci 
            $where
            GROUP BY users.nip, users.nama, users.role
            ORDER BY users.nama ASC
        ", $bindings);

        $columns = [];
        if (!empty($data)) {
            // Kolom penomoran (Loop iteration)
            $columns[] = [
                'data' => null,
                'name' => 'No',
                'title' => 'No',
                'orderable' => false,
                'searchable' => false,
            ];
            
            foreach (array_keys((array)$data[0]) as $key) {
                $columns[] = [
                    'data' => $key,
                    'name' => $key,
                    'title' => $key,
                ];
            }
        }

        return response()->json([
            'data' => $data,
            'columns' => $columns
        ]);
    }
}
