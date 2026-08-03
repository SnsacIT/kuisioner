@extends('layouts.app')

@section('content')
    <div class="app-content px-2 px-md-0 mt-3 mt-md-0">
        <div class="container px-0 px-md-3" style="max-width: 900px;">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3 p-md-5">
                            <h5 class="mb-4 text-primary border-bottom pb-2 fw-bold"><i class="bi bi-building me-2"></i> Data Cabang & Mekanik</h5>
                            
                            <!-- Sementara form action kosong (#) karena baru FE nya saja -->
                            <form action="{{ route('kuisioner.storeCabang') }}" method="POST" id="cabangForm">
                                @csrf
                                
                                <div id="cabang-container">
                                    <!-- Blok Cabang Pertama -->
                                    <div class="cabang-block mb-3 p-3 p-md-4 border rounded position-relative text-start bg-white shadow-sm">
                                        <button type="button" class="btn btn-outline-danger btn-sm position-absolute top-0 end-0 m-2 m-md-3 btn-hapus-cabang" style="display: none;">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                        <h6 class="text-secondary mb-3 pb-2 border-bottom fw-bold">Cabang #<span class="cabang-number">1</span></h6>
                                        
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label text-secondary fw-semibold">Nama / ID Cabang</label>
                                                <!-- Single Select -->
                                                <select class="form-select select2-dynamic" name="cabang[0][dealercabang_id]" data-placeholder="Ketik untuk mencari cabang..." required>
                                                    <option value=""></option>
                                                    @foreach($cabangs as $cabang)
                                                        <option value="{{ $cabang->id }}">{{ $cabang->dealer }} - {{ $cabang->cabang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary fw-semibold">Tanggal Mulai</label>
                                                <input type="date" class="form-control" name="cabang[0][start_date]" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary fw-semibold">Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="cabang[0][end_date]" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label text-secondary fw-semibold">Mess / Tempat Tinggal</label>
                                                <input type="text" class="form-control" name="cabang[0][mess]" placeholder="Contoh: Mess Cabang / Kost / Pulang Pergi" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-secondary fw-semibold">Nama Mekanik</label>
                                                <!-- Multi Select -->
                                                <select class="form-select select2-dynamic" name="cabang[0][mekanik][]" multiple="multiple" data-placeholder="Ketik untuk mencari mekanik..." required>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->nip }}">{{ $user->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-text">Bisa memilih lebih dari 1 mekanik.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-secondary fw-semibold">Nama ATL</label>
                                                <!-- Single Select -->
                                                <select class="form-select select2-dynamic" name="cabang[0][atl]" data-placeholder="Ketik untuk mencari ATL..." required>
                                                    <option value=""></option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->nip }}">{{ $user->nip }} - {{ $user->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center mt-4 border-top pt-4">
                                    <button type="button" id="btnTambahCabang" class="btn btn-outline-primary rounded-pill px-4 w-100 w-md-auto">
                                        <i class="bi bi-plus-lg me-2"></i> Tambah Cabang Lainnya
                                    </button>
                                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm w-100 w-md-auto">
                                        Lanjut ke Pertanyaan <i class="bi bi-arrow-right ms-2"></i>
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

@push('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi awal untuk elemen select2-dynamic
    function initSelect2() {
        $('.select2-dynamic').each(function() {
            if (!$(this).hasClass("select2-hidden-accessible")) {
                $(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%'
                });
            }
        });
    }

    initSelect2();

    let indexCount = 0;

    // Fungsi Tambah Cabang
    $('#btnTambahCabang').on('click', function() {
        indexCount++;
        
        // Ambil template blok pertama
        let $firstBlock = $('.cabang-block').first();
        
        // Hancurkan (destroy) select2 sementara sebelum di-clone
        $firstBlock.find('.select2-dynamic').select2('destroy');
        
        // Clone blok HTML
        let $newBlock = $firstBlock.clone();
        
        // Bersihkan value inputan di blok baru
        $newBlock.find('input').val('');
        $newBlock.find('select').val('');
        
        // Ubah index pada atribut name="..." agar terkirim sebagai array yang berbeda
        $newBlock.find('select, input').each(function() {
            let oldName = $(this).attr('name');
            if (oldName) {
                // contoh: cabang[0][start_date] -> cabang[1][start_date]
                let newName = oldName.replace(/\[\d+\]/, '[' + indexCount + ']');
                $(this).attr('name', newName);
            }
        });

        // Update nomor cabang (Cabang #2, dll)
        $newBlock.find('.cabang-number').text($('.cabang-block').length + 1);
        
        // Tampilkan tombol Hapus di blok baru
        $newBlock.find('.btn-hapus-cabang').show();

        // Append ke container
        $('#cabang-container').append($newBlock);
        
        // Inisialisasi ulang Select2 pada semua blok (yang lama & yang baru)
        initSelect2();
    });

        $(document).on('click', '.btn-hapus-cabang', function() {
        $(this).closest('.cabang-block').fadeOut(300, function() {
            $(this).remove();
            
            // Re-order nomor cabang agar urut kembali
            $('.cabang-block').each(function(i) {
                $(this).find('.cabang-number').text(i + 1);
            });
        });
    });

    // Validasi & Konfirmasi Submit dengan SweetAlert
    $('#cabangForm').on('submit', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Sudah yakin dengan data ini?',
            text: "Pastikan seluruh data cabang, tanggal, dan mekanik telah diisi dengan benar sebelum melanjutkan ke tahap pengisian kuisioner.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Lanjut ke Pertanyaan <i class="bi bi-arrow-right ms-1"></i>',
            cancelButtonText: 'Periksa Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading saat proses submit
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                form.submit();
            }
        });
    });
});
</script>
<!-- Tambahkan script SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
