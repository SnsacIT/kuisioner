<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pertanyaan')->truncate(); // Hapus data lama

        $pertanyaans = [
            [
                'category' => 'melakukan',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode([
                    "Menjual, mengambil, atau menyerahkan Freon",
                    "Menjual, mengambil, atau menyerahkan oli",
                    "Menjual, mengambil, atau menyerahkan material/suku cadang",
                    "Melakukan pekerjaan tanpa WO",
                    "Menerima pembayaran langsung",
                    "Mengumpulkan barang atau hasil dari mekanik lain",
                    "Membantu pihak lain",
                    "Mengajak atau mengarahkan pihak lain",
                    "Mengajari pihak lain",
                ]),
                'need_description_on' => '',
                'desciption_hint' => 'Tindakan lainnya:\\nCeritakan secara singkat tindakan yang Anda lakukan dengan bahasa Anda sendiri.',
                'pertanyaan' => 'Tindakan apa yang pernah Anda lakukan atau bantu lakukan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Input tanggal, bulan dan tahun, atau periode perkiraan',
                'pertanyaan' => 'Kapan pertama kali Anda melakukan tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Input tanggal, bulan dan tahun, atau periode perkiraan',
                'pertanyaan' => 'Kapan terakhir kali Anda melakukannya?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['1 kali', '2-5 kali', '6-10 kali', 'Lebih dari 10 kali', 'Tidak ingat', 'Lainnya']),
                'need_description_on' => 'Lainnya',
                'desciption_hint' => 'Perkiraan lainnya:',
                'pertanyaan' => 'Berapa kali tindakan tersebut dilakukan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Siapa yang pertama kali mengajak?
                    Siapa yang menyuruh atau mengarahkan?
                    Siapa yang mengajari caranya?
                    Siapa yang melakukan bersama?
                    Siapa yang mengumpulkan atau mengambil?
                    Kepada siapa barang dijual atau diserahkan?
                    Siapa yang menerima hasilnya?',
                'pertanyaan' => 'Siapa saja yang terlibat?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Bagaimana barang atau pekerjaan diperoleh?
                    Bagaimana barang dikumpulkan atau dipindahkan?
                    Bagaimana komunikasi dilakukan?
                    Bagaimana penyerahan atau penjualan dilakukan?
                    Bagaimana pembayaran diterima?
                    Apakah ada pihak yang membantu atau memfasilitasi?
                    Apakah tindakan dilakukan di cabang, mess, atau lokasi lain?',
                'pertanyaan' => 'Jelaskan bagaimana tindakan tersebut dilakukan dari awal sampai selesai.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode(['Kebutuhan keuangan',
                    'Utang atau pinjaman daring (Pinjol/Judol)',
                    'Diajak atau diarahkan pihak lain',
                    'Tekanan dari pihak tertentu']),
                'need_description_on' => '',
                'desciption_hint' => 'Alasan lainnya:',
                'pertanyaan' => 'Apa alasan Anda melakukan tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Jawaban singkat',
                'pertanyaan' => 'Apa barang, material, atau pekerjaan yang terkait?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Input jumlah dan satuan',
                'pertanyaan' => 'Berapa jumlahnya?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Input nominal atau estimasi',
                'pertanyaan' => 'Berapa nilai yang diterima untuk setiap transaksi?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Input nominal',
                'pertanyaan' => 'Berapa perkiraan total nilai yang Anda terima?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Ya',
                    'Tidak',
                    'Tidak ingat.']),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Dompet digital apa yang paling sering Anda pakai?',
                'pertanyaan' => 'Apakah hasil tersebut dibagi dengan pihak lain?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Ya',
                    'Tidak',
                    'Tidak dapat memastikan',
                    'Tidak ingat.']),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Jika “Ya”, jelaskan:
                    Apa yang diketahui ATL?
                    Bagaimana Anda mengetahui bahwa ATL mengetahuinya?
                    Apakah ATL memberikan arahan, persetujuan, teguran, atau respons lain?',
                'pertanyaan' => 'Menurut pengetahuan Anda, apakah ATL mengetahui tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Ya',
                    'Tidak',
                    'Tidak dapat memastikan',
                    'Tidak ingat.']),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Jika “Ya”:
                    Nama/Jabatan/Bentuk pengetahuan atau keterlibatan/Dasar Keterangan',
                'pertanyaan' => 'Apakah SA atau pihak dealer lainnya mengetahui atau terlibat?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Ya',
                    'Tidak',
                    'Tidak dapat memastikan',
                    'Tidak ingat.']),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Jika “Ya”:
                    Jenis informasi atau bukti/Siapa yang menguasainya/Lokasi penyimpanan/Keterangan
                    tambahan.',
                'pertanyaan' => 'Apakah masih terdapat informasi atau bukti yang berkaitan dengan tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pertanyaan')->insert($pertanyaans);
    }
}
