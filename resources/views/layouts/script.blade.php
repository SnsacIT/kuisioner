  {{-- 1. Core Dependencies (jQuery First, then Bootstrap/Popper) --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
  {{-- 2. UI Plugins --}}
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  {{-- 3. DataTables Dependencies (Order Matters: Core -> Libs -> Buttons) --}}
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>

  {{-- DataTables Export Tools (JSZip & PDFMake must be before Buttons HTML5) --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

  {{-- DataTables Buttons --}}
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.colVis.min.js"></script>

  {{-- 4. Inisialisasi Script Global --}}
  <script>
    // --- OverlayScrollbars Init ---
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function () {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });

    // --- Tooltip Init ---
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // --- Select2 Global Init ---
    $(document).ready(function () {
      $('.select2-search').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Ketik untuk mencari...',
      });
    });

    // Function untuk apply warna berdasarkan value
    function applyColorByValue() {
      // Untuk Entitas
      $('#entitas').next('.select2-container').find('.select2-selection__choice').each(function() {
        let text = $(this).find('.select2-selection__choice__display').text().trim();
        
        if (text === 'SNS') {
          $(this).css({
            'background-color': '#0d6efd',
            'border-color': '#0d6efd',
            'color': '#ffffff',
            'font-size': '0.75rem'
          });
        } else if (text === 'ANS') {
          $(this).css({
            'background-color': '#198754',
            'border-color': '#198754',
            'color': '#ffffff',
            'font-size': '0.75rem'
          });
        }
      });

      // Untuk Jenis Kendaraan
      $('#jenis_kendaraan').next('.select2-container').find('.select2-selection__choice').each(function() {
          let text = $(this).find('.select2-selection__choice__display').text().trim();
          
          $(this).css({
            'background-color': '#0d6efd',
            'border-color': '#0d6efd',
            'color': '#ffffff',
            'font-size': '0.75rem'
          });
      });

      // Untuk Area - berbeda warna per area
      $('#area').next('.select2-container').find('.select2-selection__choice').each(function() {
        let text = $(this).find('.select2-selection__choice__display').text().trim();
        let colors = {
          'JABODETABEK': { bg: '#0dcaf0', color: '#000' },
          'JAWABALNUS': { bg: '#20c997', color: '#fff' },
          'IBT': { bg: '#ffc107', color: '#000' },
          'SURYA DENSO MOJOKERTO': { bg: '#fd7e14', color: '#fff' },
          'SURYA DENSO PEKANBARU': { bg: '#d63384', color: '#fff' },
          'KALIMANTAN': { bg: '#6610f2', color: '#fff' },
          'JAWA BARAT': { bg: '#198754', color: '#fff' },
          'SUMATERA': { bg: '#0d6efd', color: '#fff' }
        };
        
        if (colors[text]) {
          $(this).css({
            'background-color': colors[text].bg,
            'border-color': colors[text].bg,
            'color': colors[text].color,
            'font-size': '0.75rem'
          });
        }
      });
    }

    // untuk tipe maintencenance
    $('#tipe_maintenance').next('.select2-container').find('.select2-selection__choice').each(function() {
      let text = $(this).find('.select2-selection__choice__display').text().trim();
      $(this).css({
        'background-color': '#0d6efd',
        'border-color': '#0d6efd',
        'color': '#ffffff',
        'font-size': '0.75rem'
      });
    });

    // Apply saat pertama kali load (untuk preserved values)
    setTimeout(applyColorByValue, 100);

    // Apply setiap kali ada perubahan
    $('.select2-search').on('select2:select select2:unselect', function() {
        setTimeout(applyColorByValue, 50);
    });

    // --- DataTables Global Config ---
    $(document).ready(function () {
      $('#table-1, #table-2').DataTable({
        autoWidth: false,
        layout: {
          topStart: {
            buttons: [{
              extend: 'copy',
              text: '<i class="bi bi-clipboard"></i> Copy',
              className: 'btn btn-secondary btn-sm',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'excel',
              text: '<i class="bi bi-file-earmark-excel"></i> Excel',
              className: 'btn btn-secondary btn-sm'
            },
            {
              extend: 'print',
              text: '<i class="bi bi-printer"></i> Print',
              className: 'btn btn-secondary btn-sm'
            },
            ],
            pageLength: {
              menu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Semua"]
              ]
            }
          },
          topEnd: 'search',
          bottomStart: 'info',
          bottomEnd: 'paging'
        },
        pageLength: -1,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "Semua"]
        ],
        fixedHeader: true,
        scrollX: true,
        scrollY: '500px',
        scrollCollapse: true,
        language: {
          search: "Cari:",
          lengthMenu: "_MENU_",
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
          infoEmpty: "0 data",
          infoFiltered: "(filter dari _MAX_)",
          zeroRecords: "Data tidak ditemukan",
          emptyTable: "Tidak ada data yang tersedia",
          paginate: {
            first: "Awal",
            last: "Akhir",
            next: ">",
            previous: "<"
          }
        }
      });
      
      // Inisialisasi table-3
      var table3 = $('#table-3').DataTable({
        autoWidth: false,
        pageLength: -1,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "Semua"]
        ],
        scrollX: true,
        scrollY: '500px',
        scrollCollapse: true,
        language: {
          search: "Cari:",
          lengthMenu: "_MENU_",
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
          infoEmpty: "0 data",
          infoFiltered: "(filter dari _MAX_)",
          zeroRecords: "Data tidak ditemukan",
          emptyTable: "Tidak ada data yang tersedia",
          paginate: {
            first: "Awal",
            last: "Akhir",
            next: ">",
            previous: "<"
          }
        }
      });

      var table4 = $('#table-4').DataTable({
        autoWidth: false,
        pageLength: -1,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "Semua"]
        ],
        scrollX: true,
        scrollY: '500px',
        scrollCollapse: true,
        language: {
          search: "Cari:",
          lengthMenu: "_MENU_",
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
          infoEmpty: "0 data",
          infoFiltered: "(filter dari _MAX_)",
          zeroRecords: "Data tidak ditemukan",
          emptyTable: "Tidak ada data yang tersedia",
          paginate: {
            first: "Awal",
            last: "Akhir",
            next: ">",
            previous: "<"
          }
        }
      });

      // Recalculate kolom saat modal dibuka
      $('#modalDetailTotalService').on('shown.bs.modal', function () {
        table3.columns.adjust().draw();
      });

      $('#modalDetailTotalAsuransi').on('shown.bs.modal', function () {
        table4.columns.adjust().draw();
      });
    });

    // --- Global Delete Modal Handler ---
    $(document).on('click', '.btn-delete', function () {
      let url = $(this).data('url');
      let title = $(this).data('title') || 'Hapus Data';
      let message = $(this).data('message') || 'Apakah Anda yakin ingin menghapus data ini?';
      let type = $(this).data('type');
      let name = $(this).data('name');

      $('#formHapusGlobal').attr('action', url);
      $('#modalHapusGlobalLabel').html('<i class="bi bi-trash me-2"></i>' + title);
      
      if (type && name !== undefined) {
         // Sanitasi input nama untuk mencegah XSS
         let safeName = $('<div>').text(name).html();
         $('#modalHapusGlobalMessage').html(`Apakah Anda yakin ingin menghapus ${type} <strong>${safeName}</strong>?`);
      } else {
         $('#modalHapusGlobalMessage').text(message);
      }
      
      // Reset form on close just in case
      $('#modalHapusGlobal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
      });
    });
  </script>
