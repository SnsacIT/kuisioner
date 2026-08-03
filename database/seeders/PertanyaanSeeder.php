<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pertanyaan')->truncate();

        $pertanyaans = [
            // ========== PERTANYAAN UTAMA 1 ==========
            [
                'category' => 'utama1',
                'type' => 'select-info',
                'list_jawaban' => json_encode([
                    'Ya, pernah melakukan atau terlibat',
                    'Tidak pernah melakukan atau terlibat',
                    'Saya membutuhkan penjelasan mengenai tindakan yang dimaksud',
                ]),
                'need_description_on' => 'Saya membutuhkan penjelasan mengenai tindakan yang dimaksud',
                'desciption_hint' => "Tindakan yang dimaksud meliputi:\n• Menjual atau menyerahkan Freon\n• Menjual, mengambil, atau menyerahkan oli\n• Menjual, mengambil, atau menyerahkan material/suku cadang\n• Melakukan pekerjaan tanpa Work Order\n• Melakukan pekerjaan di luar prosedur perusahaan\n• Menerima pembayaran langsung dari pelanggan atau pihak dealer\n• Mengumpulkan barang atau hasil dari mekanik lain\n• Membantu pihak lain melakukan tindakan tersebut\n• Mengajak, mengarahkan, menyuruh, atau mengajari pihak lain\n• Menyembunyikan atau mengubah informasi pekerjaan",
                'pertanyaan' => 'Selama bekerja di cabang ini pada periode tersebut, apakah Anda pernah melakukan, membantu, atau terlibat dalam tindakan yang tidak sesuai dengan prosedur atau peraturan perusahaan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== PERTANYAAN UTAMA 2 ==========
            [
                'category' => 'utama2',
                'type' => 'select',
                'list_jawaban' => json_encode([
                    'Ya, mengetahui atau melihat secara langsung',
                    'Ya, pernah mendengar dari pihak lain',
                    'Tidak mengetahui',
                ]),
                'need_description_on' => '',
                'desciption_hint' => '',
                'pertanyaan' => 'Selama bekerja di cabang ini, apakah Anda pernah mengetahui, melihat, atau menerima informasi mengenai tindakan yang tidak sesuai dengan prosedur atau peraturan perusahaan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ========== BAGIAN D — KRONOLOGI MELAKUKAN ==========
            [
                'category' => 'melakukan',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode([
                    'Menjual, mengambil, atau menyerahkan Freon',
                    'Menjual, mengambil, atau menyerahkan oli',
                    'Menjual, mengambil, atau menyerahkan material/suku cadang',
                    'Melakukan pekerjaan tanpa WO',
                    'Menerima pembayaran langsung',
                    'Mengumpulkan barang atau hasil dari mekanik lain',
                    'Membantu pihak lain',
                    'Mengajak atau mengarahkan pihak lain',
                    'Mengajari pihak lain',
                ]),
                'need_description_on' => '*',
                'desciption_hint' => 'Ceritakan secara singkat tindakan yang Anda lakukan dengan bahasa Anda sendiri (wajib diisi)',
                'pertanyaan' => 'Tindakan apa yang pernah Anda lakukan atau bantu lakukan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode([
                    '1 kali',
                    '2–5 kali',
                    '6–10 kali',
                    'Lebih dari 10 kali',
                    'Tidak ingat',
                ]),
                'need_description_on' => '*',
                'desciption_hint' => 'Kapan pertama kali dan terakhir kali Anda melakukannya? (Sebutkan bulan/tahun atau periode perkiraan)',
                'pertanyaan' => 'Berapa kali tindakan tersebut dilakukan, dan kapan pertama serta terakhir kali Anda melakukannya?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Panduan: Siapa yang pertama kali mengajak? Siapa yang menyuruh/mengarahkan? Siapa yang mengajari caranya? Siapa yang melakukan bersama? Siapa yang mengumpulkan/mengambil? Kepada siapa barang dijual/diserahkan? Siapa yang menerima hasilnya?',
                'pertanyaan' => 'Siapa saja yang terlibat dalam tindakan tersebut dari awal sampai selesai? Jelaskan peran masing-masing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Panduan: Bagaimana barang/pekerjaan diperoleh? Bagaimana dikumpulkan/dipindahkan? Bagaimana komunikasi dilakukan? Bagaimana penyerahan/penjualan dilakukan? Bagaimana pembayaran diterima? Apakah ada pihak yang memfasilitasi? Apakah dilakukan di cabang, mess, atau lokasi lain?',
                'pertanyaan' => 'Jelaskan bagaimana tindakan tersebut dilakukan dari awal sampai selesai.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode([
                    'Kebutuhan keuangan',
                    'Utang atau pinjaman daring (Pinjol/Judol)',
                    'Diajak atau diarahkan pihak lain',
                    'Tekanan dari pihak tertentu',
                ]),
                'need_description_on' => '*',
                'desciption_hint' => 'Jelaskan alasan tersebut dengan bahasa Anda sendiri',
                'pertanyaan' => 'Apa alasan Anda melakukan tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Sebutkan: Apa barang/material/pekerjaan yang terkait? Berapa jumlahnya? Berapa nilai yang diterima per transaksi? Berapa total nilai? Apakah hasil dibagi dengan pihak lain? Jika Ya, sebutkan Nama Penerima / Nominal / Keterangan.',
                'pertanyaan' => 'Berapa jumlah dan nilai (nominal) yang terkait dengan tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode([
                    'Ya',
                    'Tidak',
                    'Tidak dapat memastikan',
                    'Tidak ingat',
                ]),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Jelaskan: Apa yang diketahui ATL? Bagaimana Anda tahu bahwa ATL mengetahuinya? Apakah ATL memberikan arahan, persetujuan, teguran, atau respons lain? Apakah SA atau pihak dealer lainnya mengetahui/terlibat?',
                'pertanyaan' => 'Menurut pengetahuan Anda, apakah ATL (Asisten Teknisi Lapangan) mengetahui tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'select-description',
                'list_jawaban' => json_encode([
                    'Ya',
                    'Tidak',
                    'Tidak mengetahui',
                    'Tidak ingat',
                ]),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Sebutkan: Jenis informasi/bukti, Siapa yang menguasainya, Lokasi penyimpanan, Keterangan tambahan.',
                'pertanyaan' => 'Apakah masih terdapat informasi atau bukti yang berkaitan dengan tindakan tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== KRONOLOGI MENGETAHUI LANGSUNG (mengetahui1) ==========
            [
                'category' => 'mengetahui1',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Jelaskan secara detail tindakan atau kejadian yang Anda lihat/ketahui.',
                'pertanyaan' => 'Apa tindakan atau kejadian yang Anda ketahui?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Panduan: Kapan Anda mulai mengetahuinya, kapan kejadian tersebut berlangsung, di mana kejadian tersebut berlangsung, apakah terjadi satu kali atau berulang?',
                'pertanyaan' => 'Kapan dan di mana kejadian tersebut berlangsung?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Panduan: Sebutkan Nama/Nama Panggilan, Peran yang Diketahui, dan Dasar Pengetahuan Anda.',
                'pertanyaan' => 'Siapa saja yang terlibat dalam kejadian tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Ceritakan alur atau cara tindakan tersebut dilakukan.',
                'pertanyaan' => 'Jelaskan bagaimana tindakan tersebut dilakukan berdasarkan hal yang Anda lihat atau ketahui sendiri.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode([
                    'Melihat secara langsung',
                    'Berada di lokasi kejadian',
                    'Menemukan barang atau bukti',
                    'Diberi tahu oleh pihak yang terlibat',
                    'Cara lainnya'
                ]),
                'need_description_on' => 'Cara lainnya',
                'desciption_hint' => 'Sebutkan dari mana atau bagaimana Anda bisa mengetahuinya',
                'pertanyaan' => 'Bagaimana Anda dapat mengetahui kejadian tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Berapa jumlah barang atau nominal transaksi yang Anda ketahui? Dari mana informasi tersebut diperoleh? (Jika tidak tahu, silakan ketik "Tidak mengetahui").',
                'pertanyaan' => 'Berapa jumlah dan nilai nominal terkait kejadian yang Anda ketahui?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'select-description',
                'list_jawaban' => json_encode([
                    'Ya',
                    'Tidak',
                    'Tidak ingat'
                ]),
                'need_description_on' => 'Ya,Tidak',
                'desciption_hint' => 'Jika Ya: Kepada siapa, kapan, & bagaimana responsnya? Jika Tidak: Apa alasan Anda belum pernah menyampaikannya?',
                'pertanyaan' => 'Apakah Anda pernah menyampaikan informasi kejadian ini kepada pihak lain?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== KRONOLOGI HANYA MENDENGAR (mengetahui2) ==========
            [
                'category' => 'mengetahui2',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Tuliskan informasi apa saja yang Anda dengar.',
                'pertanyaan' => 'Informasi apa yang Anda dengar terkait tindakan yang tidak sesuai prosedur?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Sebutkan dari siapa Anda mendengarnya.',
                'pertanyaan' => 'Dari siapa Anda mendengar informasi tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Sebutkan kapan informasi tersebut disampaikan kepada Anda.',
                'pertanyaan' => 'Kapan informasi tersebut disampaikan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'select-description',
                'list_jawaban' => json_encode([
                    'Ya',
                    'Tidak'
                ]),
                'need_description_on' => 'Ya',
                'desciption_hint' => 'Jelaskan apa yang Anda lihat/verifikasi.',
                'pertanyaan' => 'Apakah Anda pernah melihat atau memverifikasi informasi tersebut sendiri?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Sebutkan pihak lain yang sekiranya dapat mengonfirmasi informasi ini.',
                'pertanyaan' => 'Apakah terdapat pihak lain yang dapat mengonfirmasi kebenaran informasi tersebut?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pertanyaan')->insert($pertanyaans);
    }
}
