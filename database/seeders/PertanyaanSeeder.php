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
        DB::table('pertanyaan')->truncate(); // Hapus data lama

        $pertanyaans = [
            [
                'category' => 'mengetahui1',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Tahu', 'Tidak Tahu']),
                'need_description_on' => 'Tahu',
                'desciption_hint' => 'Sebutkan dari mana Anda tahu (misal: Brosur, Teman, Sosial Media)',
                'pertanyaan' => 'Apakah Anda tahu tentang Promo Cuci Gratis di cabang ini?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode(['Cuci Kendaraan', 'Isi Nitrogen', 'Layanan Darurat (Storing)', 'Ruang Tunggu VIP']),
                'need_description_on' => 'Layanan Darurat (Storing),Ruang Tunggu VIP',
                'desciption_hint' => 'Jelaskan pengalaman Anda saat menggunakan fasilitas tersebut',
                'pertanyaan' => 'Fasilitas atau layanan tambahan apa saja yang pernah Anda gunakan di cabang ini?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Tuliskan pendapat Anda di sini...',
                'pertanyaan' => 'Bagaimana pemahaman Anda mengenai syarat & ketentuan klaim garansi servis kami?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'multiselect',
                'list_jawaban' => json_encode(['Booking H-1', 'Datang Langsung (Walk-in)', 'Servis Kunjung (Home Service)', 'Titip Kendaraan']),
                'need_description_on' => '',
                'desciption_hint' => '',
                'pertanyaan' => 'Pola kedatangan seperti apa yang paling sering Anda lakukan saat menservis kendaraan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Ya, Paham', 'Kurang Paham', 'Tidak Tahu Sama Sekali']),
                'need_description_on' => 'Kurang Paham,Tidak Tahu Sama Sekali',
                'desciption_hint' => 'Sebutkan bagian mana dari rincian harga yang kurang jelas',
                'pertanyaan' => 'Apakah Anda memahami rincian standar harga jasa servis yang tertera pada nota?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode(['Instagram', 'Facebook', 'Tiktok', 'Brosur Dealer', 'Lainnya']),
                'need_description_on' => 'Lainnya',
                'desciption_hint' => 'Sebutkan sumber informasi lainnya',
                'pertanyaan' => 'Dari mana saja Anda biasanya mendapatkan informasi promo & diskon servis cabang kami?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'essay',
                'list_jawaban' => json_encode([]),
                'need_description_on' => '',
                'desciption_hint' => 'Ceritakan tindakan Anda secara singkat...',
                'pertanyaan' => 'Tindakan apa yang biasa Anda lakukan jika kendaraan tiba-tiba bermasalah saat sedang dalam perjalanan jauh?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui1',
                'type' => 'multiselect',
                'list_jawaban' => json_encode(['Pengecekan Bodi Kendaraan', 'Test Drive Pasca Servis', 'Pemberian Suku Cadang Bekas', 'Konsultasi Kerusakan']),
                'need_description_on' => '',
                'desciption_hint' => '',
                'pertanyaan' => 'Standar Operasional (SOP) apa saja yang Anda rasakan selalu dilakukan oleh mekanik kami?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'mengetahui2',
                'type' => 'select-description',
                'list_jawaban' => json_encode(['Sangat Setuju', 'Setuju', 'Tidak Setuju']),
                'need_description_on' => 'Tidak Setuju',
                'desciption_hint' => 'Tolong beritahu kami alasan Anda tidak setuju',
                'pertanyaan' => 'Apakah Anda setuju jika proses pendaftaran servis diubah sepenuhnya menjadi sistem online (booking via aplikasi tanpa walk-in)?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'melakukan',
                'type' => 'multiselect-description',
                'list_jawaban' => json_encode(['Membayar Tunai (Cash)', 'Transfer Antar Bank', 'Kartu Kredit / Debit', 'Dompet Digital (OVO/Gopay/dll)']),
                'need_description_on' => 'Dompet Digital (OVO/Gopay/dll)',
                'desciption_hint' => 'Dompet digital apa yang paling sering Anda pakai?',
                'pertanyaan' => 'Metode pembayaran apa saja yang pernah Anda gunakan saat menyelesaikan tagihan di kasir cabang ini?',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('pertanyaan')->insert($pertanyaans);
    }
}
