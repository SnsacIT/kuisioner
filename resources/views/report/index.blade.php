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
                    <h3 class="mb-0">Report - Rekap Kuesioner</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Rekap Kuesioner
                        </li>
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
                                <label>Tanggal Mulai Pengisian:</label>
                                <input type="date" id="filter-start-date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Selesai Pengisian:</label>
                                <input type="date" id="filter-end-date" class="form-control">
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
            url: "{{ route('report.data') }}",
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
                        let nip = row['NIP Pengisi']; 
                        let nama = row['Nama Pengisi'];
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

                // Terapkan class text-wrap ke kolom pertanyaan (index >= 12) agar bisa word wrap
                response.columns.forEach(function(col, index) {
                    // Kolom Waktu Mulai & Selesai ada di index terakhir, kita biarkan nowrap
                    if (index >= 12 && !col.title.toLowerCase().includes('waktu')) {
                        col.className = 'text-wrap-col';
                    }
                    // Beri perataan tengah khusus pada kolom NIP Pengisi (indeks 2) untuk di Report
                    if (col.title === 'NIP Pengisi') {
                        col.className = (col.className || '') + ' text-center';
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
                            pageLength: {},
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    text: '<i class="bi bi-file-earmark-excel"></i> Export Excel',
                                    className: 'btn btn-success mb-2',
                                    filename: 'Data Rekap Kuisioner', // Menentukan nama file saat diunduh
                                    title: '', // Menghilangkan baris 1 (judul di dalam Excel)
                                    autoFilter: true, // Menambahkan auto filter (seperti Ctrl+T)
                                    exportOptions: {
                                        modifier: {
                                            search: 'none' // Abaikan semua filter saat export
                                        }
                                    },
                                    customize: function(xlsx) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                        var styles = xlsx.xl['styles.xml'];
                                        
                                        // 1. Buat warna background kustom (Hijau Tua dan Hijau Muda)
                                        var fillGreen = '<fill><patternFill patternType="solid"><fgColor rgb="FF4F81BD" /><bgColor indexed="64" /></patternFill></fill>';
                                        var fillLightGreen = '<fill><patternFill patternType="solid"><fgColor rgb="FFE2EFDA" /><bgColor indexed="64" /></patternFill></fill>';
                                        $(styles).find('fills').append('<fill><patternFill patternType="solid"><fgColor rgb="FF70AD47" /><bgColor indexed="64" /></patternFill></fill>');
                                        $(styles).find('fills').append('<fill><patternFill patternType="solid"><fgColor rgb="FFE2EFDA" /><bgColor indexed="64" /></patternFill></fill>');
                                        
                                        var fillsCount = parseInt($(styles).find('fills').attr('count'));
                                        var fillGreenIdx = fillsCount;
                                        var fillLightGreenIdx = fillsCount + 1;
                                        $(styles).find('fills').attr('count', fillsCount + 2);
                                        
                                        // 2. Buat warna font kustom (Putih Tebal untuk Header)
                                        $(styles).find('fonts').append('<font><b/><color rgb="FFFFFFFF"/></font>');
                                        var fontsCount = parseInt($(styles).find('fonts').attr('count'));
                                        var fontWhiteBoldIdx = fontsCount;
                                        $(styles).find('fonts').attr('count', fontsCount + 1);
                                        
                                        // 3. Alignment kustom (Wrap & Center)
                                        var alignWrap = '<alignment wrapText="1" vertical="top" horizontal="left"/>';
                                        var alignCenter = '<alignment vertical="center" horizontal="center"/>';
                                        
                                        // 4. Gabungkan menjadi Style (cellXfs)
                                        var xfHeader = '<xf numFmtId="0" fontId="'+fontWhiteBoldIdx+'" fillId="'+fillGreenIdx+'" borderId="1" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center" horizontal="center" wrapText="1"/></xf>';
                                        var xfLightWrap = '<xf numFmtId="0" fontId="0" fillId="'+fillLightGreenIdx+'" borderId="1" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">'+alignWrap+'</xf>';
                                        var xfLightCenter = '<xf numFmtId="0" fontId="0" fillId="'+fillLightGreenIdx+'" borderId="1" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">'+alignCenter+'</xf>';
                                        var xfWhiteWrap = '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">'+alignWrap+'</xf>';
                                        var xfWhiteCenter = '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">'+alignCenter+'</xf>';
                                        
                                        $(styles).find('cellXfs').append(xfHeader).append(xfLightWrap).append(xfLightCenter).append(xfWhiteWrap).append(xfWhiteCenter);
                                        var xfCount = parseInt($(styles).find('cellXfs').attr('count'));
                                        var headerStyleIdx = xfCount;
                                        var lightWrapStyleIdx = xfCount + 1;
                                        var lightCenterStyleIdx = xfCount + 2;
                                        var whiteWrapStyleIdx = xfCount + 3;
                                        var whiteCenterStyleIdx = xfCount + 4;
                                        $(styles).find('cellXfs').attr('count', xfCount + 5);
                                        
                                        // 4. Terapkan Style ke Sheet dengan algoritma matriks
                                        var totalCols = response.columns.length;
                                        
                                        // Helper: Angka ke Huruf Kolom Excel (0->A, 25->Z, 26->AA)
                                        var getExcelCol = function(n) {
                                            var ordA = 'A'.charCodeAt(0);
                                            var ordZ = 'Z'.charCodeAt(0);
                                            var len = ordZ - ordA + 1;
                                            var s = "";
                                            while(n >= 0) {
                                                s = String.fromCharCode(n % len + ordA) + s;
                                                n = Math.floor(n / len) - 1;
                                            }
                                            return s;
                                        };

                                        // Iterasi semua baris di XML
                                        $('row', sheet).each(function(rowIndex) {
                                            var rowNode = $(this);
                                            var rowNum = rowNode.attr('r'); // Ambil nomor baris asli Excel
                                            
                                            // Tentukan basis style untuk baris ini
                                            var isLightRow = (rowIndex % 2 === 1);
                                            
                                            var previousCell = null;
                                            var xmlDoc = sheet.ownerDocument || sheet; // Pastikan kita mendapat Document object
                                            
                                            for (var i = 0; i < totalCols; i++) {
                                                // Kolom NIP ada di indeks 2
                                                var isCenterCol = (i === 2); 
                                                
                                                var styleIdx;
                                                if (rowIndex === 0) {
                                                    styleIdx = headerStyleIdx;
                                                } else {
                                                    if (isLightRow) {
                                                        styleIdx = isCenterCol ? lightCenterStyleIdx : lightWrapStyleIdx;
                                                    } else {
                                                        styleIdx = isCenterCol ? whiteCenterStyleIdx : whiteWrapStyleIdx;
                                                    }
                                                }
                                                var cellRef = getExcelCol(i) + rowNum;
                                                var cell = rowNode.children('c[r="' + cellRef + '"]');
                                                
                                                if (cell.length === 0) {
                                                    // Injeksi sel `<c>` baru jika DataTables mengabaikannya karena kosong
                                                    var newCell = xmlDoc.createElement('c');
                                                    newCell.setAttribute('r', cellRef);
                                                    newCell.setAttribute('s', styleIdx);
                                                    
                                                    if (previousCell) {
                                                        $(previousCell).after(newCell);
                                                    } else {
                                                        rowNode.prepend(newCell);
                                                    }
                                                    previousCell = newCell;
                                                } else {
                                                    cell.attr('s', styleIdx);
                                                    previousCell = cell[0];
                                                }
                                            }
                                        });
                                    }
                                }
                            ]
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
                        // Cari kombinasi match menggunakan regex: ^(Nama1|Nama2)$
                        table.column('Nama Pengisi:name').search('^(' + selectedNames.join('|') + ')$', true, false).draw();
                    } else {
                        // Reset filter
                        table.column('Nama Pengisi:name').search('').draw();
                    }
                });

                // Reset Button
                $('#btn-reset-filter').on('click', function() {
                    $('#filter-start-date').val('');
                    $('#filter-end-date').val('');
                    $('#filter-nip').val(null).trigger('change');
                    $('#filter-start-date').trigger('change');
                });

                // Filter Tanggal (Start & End) menggunakan AJAX reload
                $('#filter-start-date, #filter-end-date').on('change', function() {
                    var startDate = $('#filter-start-date').val();
                    var endDate = $('#filter-end-date').val();

                    // Tampilkan status loading ringan
                    $('#table-rekap').css('opacity', '0.5');

                    $.ajax({
                        url: '{{ route("report.data") }}',
                        method: 'GET',
                        data: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        success: function(res) {
                            // Kosongkan data tabel yang lama dan isi dengan yang baru
                            table.clear().rows.add(res.data).draw();
                            
                            // Perbarui daftar NIP di dropdown sesuai data yang difilter
                            populateNipFilter(res.data);
                            
                            $('#table-rekap').css('opacity', '1');
                            
                            // Re-apply pencarian NIP jika sedang aktif
                            $('#filter-nip').trigger('change');
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