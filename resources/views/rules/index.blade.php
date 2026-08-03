@extends('layouts.app')

@section('content')
    <div class="app-content px-2 px-md-0 mt-3 mt-md-0">
        <div class="container px-0 px-md-3" style="max-width: 900px;">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3 p-md-5">
                            <form action="{{ route('kuisioner.start') }}" method="POST">
                                @csrf

                                <h6 class="mb-3 text-primary border-bottom pb-2 text-start fw-bold">Data Informasi</h6>
                                <div class="row g-3 mb-4 text-start">
                                    <div class="col-12">
                                        <label class="form-label text-secondary fw-semibold" style="font-size: 0.85rem;">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-sm bg-light" value="{{ Auth::user()->nama ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-secondary fw-semibold" style="font-size: 0.85rem;">NIP</label>
                                        <input type="text" class="form-control form-control-sm bg-light" name="nip" value="{{ Auth::user()->nip ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-secondary fw-semibold" style="font-size: 0.85rem;">Tanggal (Periode)</label>
                                        <input type="date" class="form-control form-control-sm bg-light" name="periode" value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>

                                <h6 class="mb-3 text-center text-primary fw-bold"><i class="bi bi-info-circle me-1"></i> Pernyataan Integritas</h6>

                                <div class="mb-4 text-secondary" style="font-size: 0.85rem; text-align: justify;">
                                    <p class="mb-2 fw-semibold">Sebelum melanjutkan pengisian formulir ini, mohon membaca pernyataan berikut dengan saksama. Saya menyatakan bahwa:</p>
                                    <ol class="list-group list-group-numbered list-group-flush">
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya telah memperoleh penjelasan yang cukup mengenai tujuan pengisian formulir ini dan memahami informasi yang diminta.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya bersedia memberikan keterangan secara sukarela, dalam kondisi sadar, dan tanpa tekanan, ancaman, intimidasi, arahan jawaban, maupun paksaan dari pihak mana pun.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Seluruh informasi yang saya berikan dalam formulir ini adalah benar, lengkap, akurat, dan sesuai dengan fakta serta pengetahuan yang saya miliki.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya tidak dengan sengaja menyembunyikan, mengubah, mengurangi, menambahkan, atau memberikan informasi yang tidak sesuai dengan keadaan sebenarnya.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Jika terdapat informasi yang tidak saya ketahui secara pasti atau tidak saya ingat secara lengkap, saya akan menyatakannya secara terbuka dan tidak membuat perkiraan seolah-olah sebagai fakta.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya bersedia memberikan klarifikasi atau keterangan tambahan apabila diperlukan untuk memverifikasi informasi yang saya sampaikan.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya memahami dan menyetujui bahwa informasi, data, serta dokumen yang saya berikan dapat digunakan oleh perusahaan untuk:
                                            <ol type="a" class="mt-1 mb-0 ps-3">
                                                <li>Verifikasi dan pemeriksaan internal</li>
                                                <li>Proses investigasi lebih lanjut</li>
                                                <li>Evaluasi kepatuhan terhadap peraturan perusahaan</li>
                                            </ol>
                                        </li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Pengambilan tindakan sesuai kebijakan perusahaan, perjanjian kerja, peraturan ketenagakerjaan, dan ketentuan hukum yang berlaku.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya memahami bahwa informasi yang saya sampaikan dapat dibandingkan dengan data, dokumen, bukti, atau keterangan lain yang diperoleh perusahaan secara sah.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya memahami bahwa apabila kemudian ditemukan adanya keterangan yang dengan sengaja tidak benar, tidak lengkap, atau menyesatkan, perusahaan dapat melakukan klarifikasi dan menindaklanjutinya sesuai prosedur serta ketentuan yang berlaku.</li>
                                        <li class="list-group-item bg-transparent border-0 py-1 px-1">Saya memahami bahwa persetujuan ini tidak mengurangi hak saya untuk memberikan penjelasan, koreksi, atau klarifikasi atas informasi yang saya sampaikan selama proses pemeriksaan.</li>
                                    </ol>
                                </div>

                                <div class="d-flex justify-content-center mb-4 mt-2">
                                    <div class="form-check text-start w-100">
                                        <input class="form-check-input" type="checkbox" id="checkJujur" name="checkJujur" required
                                            onchange="document.getElementById('btnMulai').disabled = !this.checked; document.getElementById('btnMulai').classList.toggle('opacity-50', !this.checked)">
                                        <label class="form-check-label text-secondary fw-semibold" for="checkJujur"
                                            style="cursor: pointer; font-size: 0.85rem;">
                                            Saya telah membaca dan memahami seluruh pernyataan di atas. Saya menyatakan setuju dan bersedia melanjutkan pengisian formulir.
                                        </label>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" id="btnMulai"
                                        class="btn btn-primary px-4 py-2 rounded-pill shadow-sm opacity-50 w-100 w-md-auto" style="font-size: 0.9rem;" disabled>
                                        Saya Mengerti, Mulai Kuisioner
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection