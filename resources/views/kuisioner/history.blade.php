@extends('layouts.app')

@section('content')
    <div class="app-content px-2 px-md-0 mt-3 mt-md-0">
        <div class="container px-0 px-md-3" style="max-width: 900px;">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3 p-md-5">
                            <h5 class="mb-4 text-primary border-bottom pb-2 fw-bold"><i class="bi bi-clock-history me-2"></i> History Cabang Penempatan (Opsional)</h5>
                            
                            @if(isset($currentCabang) && $currentCabang->dealerCabang)
                            <div class="alert alert-success border-0 shadow-sm mb-4">
                                <h6 class="fw-bold text-success mb-2"><i class="bi bi-check-circle-fill me-2"></i>Penempatan Saat Ini Tersimpan</h6>
                                <div class="d-flex flex-column flex-md-row gap-2 gap-md-4 small">
                                    <div><strong>Cabang:</strong> {{ $currentCabang->dealerCabang->dealer }} - {{ $currentCabang->dealerCabang->cabang }}</div>
                                    <div><strong>Mulai:</strong> {{ \Carbon\Carbon::parse($currentCabang->start_date)->format('d M Y') }}</div>
                                    <div><strong>Mess:</strong> {{ $currentCabang->mess }}</div>
                                </div>
                            </div>
                            @endif

                            <div class="alert alert-info border-0 shadow-sm small mb-4">
                                <i class="bi bi-info-circle-fill me-2"></i> 
                                Jika Anda memiliki riwayat penempatan di cabang lain pada periode kuesioner ini, silakan tambahkan di sini. Jika <strong>tidak ada</strong>, Anda dapat langsung menghapusnya atau mengeklik tombol <strong>Lewati</strong>.
                            </div>
                            
                            <form action="{{ route('kuisioner.storeHistoryCabang') }}" method="POST" id="historyForm">
                                @csrf
                                
                                <div id="cabang-container">
                                    <!-- Blok Cabang History Pertama (Bisa dihapus) -->
                                    <div class="cabang-block mb-3 p-3 p-md-4 border rounded position-relative text-start bg-white shadow-sm">
                                        <button type="button" class="btn btn-outline-danger btn-sm position-absolute top-0 end-0 m-2 m-md-3 btn-hapus-cabang">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                        <h6 class="text-secondary mb-3 pb-2 border-bottom fw-bold">History Cabang #<span class="cabang-number">1</span></h6>
                                        
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
                                                <label class="form-label text-secondary fw-semibold">Nama mekanik lain yang bekerja di dealer cabang ini bersama Anda</label>
                                                <input type="text" class="form-control" name="cabang[0][mekanik]" placeholder="Masukkan nama mekanik..." required>
                                                <div class="form-text">Bisa diisi lebih dari 1 mekanik, pisahkan dengan koma.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-secondary fw-semibold">Nama ATL<br><br></label>
                                                <input type="text" class="form-control" name="cabang[0][atl]" placeholder="Masukkan nama ATL..." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="button" id="btnTambahCabang" class="btn btn-outline-primary rounded-pill px-4 btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah History Cabang Lainnya
                                    </button>
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center mt-4 border-top pt-4">
                                    <a href="{{ route('kuisioner.pertanyaan') }}" class="btn btn-outline-secondary rounded-pill px-4 w-100 w-md-auto">
                                        Lewati (Tidak ada history) <i class="bi bi-chevron-double-right ms-1"></i>
                                    </a>
                                    
                                    <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm w-100 w-md-auto" id="btnSubmitHistory">
                                        Simpan History & Mulai Kuesioner <i class="bi bi-play-circle ms-2"></i>
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
    // Template kosong untuk ditambahkan
    const emptyTemplate = `
        <div class="cabang-block mb-3 p-3 p-md-4 border rounded position-relative text-start bg-white shadow-sm">
            <button type="button" class="btn btn-outline-danger btn-sm position-absolute top-0 end-0 m-2 m-md-3 btn-hapus-cabang">
                <i class="bi bi-trash"></i> Hapus
            </button>
            <h6 class="text-secondary mb-3 pb-2 border-bottom fw-bold">History Cabang #<span class="cabang-number">X</span></h6>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label text-secondary fw-semibold">Nama / ID Cabang</label>
                    <select class="form-select select2-template" name="cabang[X][dealercabang_id]" data-placeholder="Ketik untuk mencari cabang..." required>
                        <option value=""></option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->dealer }} - {{ $cabang->cabang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary fw-semibold">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="cabang[X][start_date]" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary fw-semibold">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="cabang[X][end_date]" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label text-secondary fw-semibold">Mess / Tempat Tinggal</label>
                    <input type="text" class="form-control" name="cabang[X][mess]" placeholder="Contoh: Mess Cabang / Kost / Pulang Pergi" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary fw-semibold">Nama mekanik lain yang bekerja di dealer cabang ini bersama Anda</label>
                    <input type="text" class="form-control" name="cabang[X][mekanik]" placeholder="Masukkan nama mekanik..." required>
                    <div class="form-text">Bisa diisi lebih dari 1 mekanik, pisahkan dengan koma.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary fw-semibold">Nama ATL<br><br></label>
                    <input type="text" class="form-control" name="cabang[X][atl]" placeholder="Masukkan nama ATL..." required>
                </div>
            </div>
        </div>
    `;

    function initSelect2() {
        $('.select2-dynamic, .select2-template').each(function() {
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

    function checkSubmitButton() {
        if ($('.cabang-block').length === 0) {
            $('#btnSubmitHistory').addClass('d-none');
        } else {
            $('#btnSubmitHistory').removeClass('d-none');
        }
    }

    // Fungsi Tambah Cabang
    $('#btnTambahCabang').on('click', function() {
        indexCount++;
        let newBlockHtml = emptyTemplate.replace(/\[X\]/g, '[' + indexCount + ']');
        let $newBlock = $(newBlockHtml);
        
        $newBlock.find('.cabang-number').text($('.cabang-block').length + 1);
        $('#cabang-container').append($newBlock);
        
        initSelect2();
        checkSubmitButton();
    });

    $(document).on('click', '.btn-hapus-cabang', function() {
        $(this).closest('.cabang-block').fadeOut(300, function() {
            $(this).remove();
            
            // Re-order nomor cabang agar urut kembali
            $('.cabang-block').each(function(i) {
                $(this).find('.cabang-number').text(i + 1);
            });
            checkSubmitButton();
        });
    });

    // Validasi & Konfirmasi Submit
    $('#historyForm').on('submit', function(e) {
        e.preventDefault();
        let form = this;

        // Jika tidak ada form yang tersisa, arahkan ke lewati
        if ($('.cabang-block').length === 0) {
            window.location.href = "{{ route('kuisioner.pertanyaan') }}";
            return;
        }

        Swal.fire({
            title: 'Simpan History Cabang?',
            text: "Data history akan disimpan sebelum Anda masuk ke pengisian kuesioner.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan & Mulai <i class="bi bi-play-circle ms-1"></i>',
            cancelButtonText: 'Periksa Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
