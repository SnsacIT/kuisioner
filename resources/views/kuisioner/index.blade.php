@extends('layouts.app')

@section('content')
    <div class="app-content px-2 px-md-0 mt-3 mt-md-0">
        <div class="container px-0 px-md-3" style="max-width: 900px;">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3 p-md-5">
                            <h5 class="mb-4 text-primary border-bottom pb-2 fw-bold"><i class="bi bi-building me-2"></i> Data Cabang Penempatan Saat Ini</h5>
                            <p class="text-muted small mb-4">Silakan masukkan data cabang tempat Anda bekerja <strong>saat ini</strong>. Tanggal selesai tidak perlu diisi.</p>
                            
                            <form action="{{ route('kuisioner.storeCabang') }}" method="POST" id="cabangForm">
                                @csrf
                                
                                <div class="cabang-block mb-3 p-3 p-md-4 border rounded bg-white shadow-sm">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary fw-semibold">Nama / ID Cabang</label>
                                            <select class="form-select select2-dynamic" name="dealercabang_id" data-placeholder="Ketik untuk mencari cabang..." required>
                                                <option value=""></option>
                                                @foreach($cabangs as $cabang)
                                                    <option value="{{ $cabang->id }}">{{ $cabang->dealer }} - {{ $cabang->cabang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary fw-semibold">Tanggal Mulai Penempatan</label>
                                            <input type="date" class="form-control" name="start_date" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label text-secondary fw-semibold">Mess / Tempat Tinggal</label>
                                            <input type="text" class="form-control" name="mess" placeholder="Contoh: Mess Cabang / Kost / Pulang Pergi" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary fw-semibold">Nama mekanik lain yang bekerja di dealer cabang ini bersama Anda</label>
                                            <input type="text" class="form-control" name="mekanik" placeholder="Masukkan nama mekanik..." required>
                                            <div class="form-text">Bisa diisi lebih dari 1 mekanik, pisahkan dengan koma.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary fw-semibold">Nama ATL<br><br></label>
                                            <input type="text" class="form-control" name="atl" placeholder="Masukkan nama ATL..." required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4 border-top pt-4">
                                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm w-100 w-md-auto">
                                        Simpan Penempatan & Lanjut <i class="bi bi-arrow-right ms-2"></i>
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
    $('.select2-dynamic').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    $('#cabangForm').on('submit', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Sudah yakin dengan data ini?',
            text: "Pastikan data cabang penempatan saat ini telah diisi dengan benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Lanjut <i class="bi bi-arrow-right ms-1"></i>',
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
