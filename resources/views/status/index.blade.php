@extends('layouts.report')

@section('content')
<style>
    /* Paksa bungkus teks dan berikan lebar minimum agar tidak terlalu sempit */
    .text-wrap-col {
        white-space: normal !important;
        min-width: 350px !important;
        vertical-align: top;
    }
    
    /* Styling Header Tabel */
    table.dataTable thead th,
    table.dataTable thead td,
    .dt-scroll-head th {
        text-align: center !important;
        vertical-align: middle !important;
        background-color: navy !important; /* bg-navy */
        color: white !important;
    }
</style>

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Status Kuisioner</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Status Kuesioner</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="mb-0"><b>Tabel Data Kuesioner</b></h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Pengisian:</label>
                                <input type="date" id="filter-tanggal" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Filter Status:</label>
                                <select id="filter-status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Belum Selesai">Belum Selesai</option>
                                </select>
                            </div>
                            <div class="col-12 d-flex align-items-end gap-2">
                                <div class="flex-grow-1">
                                    <label>Filter Responden (NIP / Nama):</label>
                                    <select id="filter-nip" class="form-select select2" multiple="multiple">
                                    </select>
                                </div>
                                <button class="btn btn-outline-danger mb-1" id="btn-reset-filter" title="Reset Filter">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div id="loading-spinner" class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Sedang mengambil rekap data...</p>
                            </div>
                            
                            {{-- DataTables akan otomatis membuat thead berdasarkan res.columns --}}
                            <table id="table-rekap" class="table table-bordered table-striped nowrap d-none" style="width:100%">
                            </table>
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
        // Ambil data dan definisi kolom dari server
        $.ajax({
            url: "{{ route('status.data') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Sembunyikan spinner loading
                $('#loading-spinner').addClass('d-none');
                $('#table-rekap').removeClass('d-none');

                // Fungsi pembantu untuk populate dropdown NIP
                function populateNipFilter(data) {
                    let uniqueUsers = new Set();
                    let filterOptions = ''; // Untuk multi-select tidak perlu option kosong
                    let currentSelected = $('#filter-nip').val(); // Simpan pilihan saat ini jika ada
                    
                    data.forEach(function(row) {
                        let nip = row['NIP']; 
                        let nama = row['Nama'];
                        if (nip && nama) {
                            let textOption = nip + ' - ' + nama;
                            if (!uniqueUsers.has(textOption)) {
                                uniqueUsers.add(textOption);
                                // Simpan nama di atribut data untuk pencarian
                                filterOptions += `<option value="${nip}" data-nama="${nama}">${textOption}</option>`;
                            }
                        }
                    });

                    if ($('#filter-nip').hasClass("select2-hidden-accessible")) {
                        $('#filter-nip').select2('destroy');
                    }
                    
                    $('#filter-nip').html(filterOptions);
                    if (currentSelected) {
                        $('#filter-nip').val(currentSelected);
                    }
                    $('#filter-nip').select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: '-- Semua Data --',
                        allowClear: true,
                        closeOnSelect: false
                    });
                }
                
                // Populate pertama kali
                populateNipFilter(response.data);

                response.columns.forEach(function(col, index) {
                    // Render Nomor Urut
                    if (col.title === 'No') {
                        col.className = 'text-center align-middle';
                        col.render = function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        };
                    }
                    
                    // Beri perataan tengah pada kolom NIP, Role, Status, dan Waktu Pengisian
                    if (col.title === 'NIP' || col.title === 'Role' || col.title === 'Status' || col.title === 'Waktu Pengisian') {
                        col.className = (col.className || '') + ' text-center align-middle';
                    }

                    // Tambahkan badge khusus untuk kolom Status saat ditampilkan di HTML
                    if (col.title === 'Status') {
                        col.render = function(data, type, row) {
                            if (type === 'display') {
                                if (data === 'Selesai') {
                                    return '<span class="badge bg-success">Selesai</span>';
                                } else {
                                    return '<span class="badge bg-danger">Belum Selesai</span>';
                                }
                            }
                            return data; // Kembalikan teks asli untuk Excel dan Sorting
                        };
                    }
                });

                // 3. Inisialisasi DataTables secara dinamis
                let table = $('#table-rekap').DataTable({
                    scrollX: true,         // Aktifkan horizontal scroll
                    scrollY: '65vh',       // Maksimal tinggi tabel 60% dari tinggi layar
                    scrollCollapse: true,  // Tabel menyesuaikan tinggi jika data sedikit
                    data: response.data,   // Data baris dari query SQL
                    columns: response.columns, // Definisi judul dan mapping key dari controller
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    layout: {
                        topStart: {
                            pageLength: {}
                        }
                    },
                    language: {
                        emptyTable: "Belum ada data kuesioner yang tersedia."
                    },
                    // Karena sudah pakai scrollY, fixedHeader (window-level scroll) bisa dimatikan 
                    // agar tidak double sticky header
                    fixedHeader: false
                });

                // Custom filtering NIP / Nama
                $('#filter-nip').on('change', function() {
                    var selectedNames = [];
                    $(this).find(':selected').each(function() {
                        var nama = $(this).data('nama');
                        if (nama) selectedNames.push($.fn.dataTable.util.escapeRegex(nama));
                    });
                    
                    if (selectedNames.length > 0) {
                        table.column('Nama:name').search('^(' + selectedNames.join('|') + ')$', true, false).draw();
                    } else {
                        table.column('Nama:name').search('').draw();
                    }
                });
                
                // Reset Button
                $('#btn-reset-filter').on('click', function() {
                    $('#filter-tanggal').val('');
                    $('#filter-status').val('').trigger('change');
                    $('#filter-nip').val(null).trigger('change');
                    $('#filter-tanggal').trigger('change'); // trigger AJAX reload for date
                });
                
                // Filter Status
                $('#filter-status').on('change', function() {
                    var status = $(this).val();
                    if (status) {
                        table.column('Status:name').search('^' + status + '$', true, false).draw();
                    } else {
                        table.column('Status:name').search('').draw();
                    }
                });

                // Filter Tanggal menggunakan AJAX reload
                $('#filter-tanggal').on('change', function() {
                    var tanggal = $(this).val();

                    // Tampilkan status loading ringan
                    $('#table-rekap').css('opacity', '0.5');

                    $.ajax({
                        url: '{{ route("status.data") }}',
                        method: 'GET',
                        data: {
                            tanggal: tanggal
                        },
                        success: function(res) {
                            // Kosongkan data tabel yang lama dan isi dengan yang baru
                            table.clear().rows.add(res.data).draw();
                            
                            // Perbarui daftar NIP di dropdown sesuai data yang difilter
                            populateNipFilter(res.data);
                            
                            $('#table-rekap').css('opacity', '1');
                            
                            // Re-apply pencarian jika sedang aktif
                            $('#filter-nip').trigger('change');
                            $('#filter-status').trigger('change');
                        },
                        error: function(err) {
                            console.error("Gagal mengambil data tanggal", err);
                            $('#table-rekap').css('opacity', '1');
                        }
                    });
                });
            },
            error: function(xhr) {
                $('#loading-spinner').html('<div class="alert alert-danger">Gagal mengambil data dari server. Silakan muat ulang halaman.</div>');
                console.error(xhr.responseText);
            }
        });
    });
</script>
@endpush