@extends('layouts.app')

@section('content')
    <div class="app-content px-2 px-md-0 mt-3 mt-md-0">
        <div class="container px-0 px-md-3" style="max-width: 900px;">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3 p-md-5 text-center">
                            <h5 class="mb-4 text-primary border-bottom pb-2 fw-bold text-start">
                                <i class="bi bi-ui-checks me-2"></i> Kuisioner Integritas & Pelayanan
                            </h5>
                            
                            <form id="formKuisioner" action="#" method="POST" class="text-start mt-4">
                                @csrf
                                
                                {{-- Penanda Progress --}}
                                <div class="mb-3 text-end text-muted small fw-bold">
                                    Soal <span id="currentStepIndicator">1</span> dari {{ count($pertanyaans) }}
                                </div>

                                @foreach($pertanyaans as $index => $q)
                                <div class="question-step d-none" id="step-{{ $index + 1 }}" data-qid="{{ $q->id }}" data-type="{{ $q->type }}">
                                    <div class="card shadow-sm border-0 mb-4 bg-light">
                                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                                            <span class="badge bg-secondary mb-2">{{ $q->category }}</span>
                                            <span class="badge bg-info mb-2 ms-1">Type: {{ $q->type }}</span>
                                            <h6 class="fw-bold mb-0">{{ $index + 1 }}. {{ $q->pertanyaan }}</h6>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $opsi = json_decode($q->list_jawaban, true) ?? [];
                                            @endphp
                                            
                                            @if($q->type == 'select-description' && count($opsi) > 0)
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach($opsi as $jawaban)
                                                    <div class="form-check">
                                                        <input class="form-check-input check-input-trigger" type="radio" name="jawaban[{{ $q->id }}]" id="q{{ $q->id }}_ans{{ $loop->index }}" value="{{ $jawaban }}" data-qid="{{ $q->id }}">
                                                        <label class="form-check-label" for="q{{ $q->id }}_ans{{ $loop->index }}">
                                                            {{ $jawaban }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @elseif(in_array($q->type, ['multiselect', 'multiselect-description']) && count($opsi) > 0)
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach($opsi as $jawaban)
                                                    <div class="form-check">
                                                        <input class="form-check-input check-input-trigger" type="checkbox" name="jawaban[{{ $q->id }}][]" id="q{{ $q->id }}_ans{{ $loop->index }}" value="{{ $jawaban }}" data-qid="{{ $q->id }}">
                                                        <label class="form-check-label" for="q{{ $q->id }}_ans{{ $loop->index }}">
                                                            {{ $jawaban }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @elseif($q->type == 'essay')
                                                <textarea class="form-control req-input" name="jawaban[{{ $q->id }}]" rows="3" placeholder="{{ $q->desciption_hint }}"></textarea>
                                            @endif
                                            
                                            {{-- Area deskripsi (default hidden) --}}
                                            @if($q->need_description_on)
                                            <div class="mt-3 description-area d-none" id="desc_area_{{ $q->id }}">
                                                <label class="form-label text-muted small fw-bold"><i class="bi bi-info-circle me-1"></i>Keterangan Tambahan</label>
                                                <textarea class="form-control" name="deskripsi[{{ $q->id }}]" rows="2" placeholder="{{ $q->desciption_hint }}"></textarea>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="d-flex flex-column-reverse flex-md-row justify-content-between gap-3 mt-4">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold w-100 w-md-auto" id="btnPrev">
                                        <i class="bi bi-arrow-left me-2"></i> Sebelumnya
                                    </button>
                                    
                                    <button type="button" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm w-100 w-md-auto" id="btnNext">
                                        Selanjutnya <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm d-none w-100 w-md-auto" id="btnSubmitKuisioner">
                                        <i class="bi bi-send me-2"></i> Submit Kuisioner
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
        const totalSteps = {{ count($pertanyaans) }};
        let currentStep = 1;

        // Hash Navigation Logic
        function renderStep() {
            let hash = window.location.hash;
            if (hash && hash.startsWith('#q')) {
                let step = parseInt(hash.replace('#q', ''));
                if (step >= 1 && step <= totalSteps) {
                    currentStep = step;
                }
            } else {
                currentStep = 1;
                // history.replaceState(null, null, ' ' + window.location.pathname + '#q1');
            }

            // Update UI
            $('#currentStepIndicator').text(currentStep);
            $('.question-step').addClass('d-none');
            $('#step-' + currentStep).removeClass('d-none').hide().fadeIn(300);

            // Button visibility
            if (currentStep === 1) {
                $('#btnPrev').addClass('invisible'); // hide but keep space
            } else {
                $('#btnPrev').removeClass('invisible');
            }

            if (currentStep === totalSteps) {
                $('#btnNext').addClass('d-none');
                $('#btnSubmitKuisioner').removeClass('d-none');
            } else {
                $('#btnNext').removeClass('d-none');
                $('#btnSubmitKuisioner').addClass('d-none');
            }
        }

        // Jalankan saat load & saat hash berubah (tombol Back/Forward browser ditekan)
        window.addEventListener('hashchange', renderStep);
        renderStep(); // Init first load

        // Navigasi Next & Prev
        $('#btnNext').on('click', function() {
            // Validasi di sini sebelum lanjut
            if (validateStep(currentStep)) {
                window.location.hash = 'q' + (currentStep + 1);
            }
        });

        $('#btnPrev').on('click', function() {
            window.location.hash = 'q' + (currentStep - 1);
        });

        // Fungsi Validasi Step saat ini
        function validateStep(step) {
            let stepDiv = $('#step-' + step);
            let qid = stepDiv.data('qid');
            let type = stepDiv.data('type');
            let isValid = true;
            let errMsg = 'Mohon lengkapi jawaban Anda.';

            if (type === 'select-description' || type === 'radio') {
                if ($('input[name="jawaban[' + qid + ']"]:checked').length === 0) {
                    isValid = false;
                }
            } else if (type === 'multiselect' || type === 'multiselect-description') {
                if ($('input[name="jawaban[' + qid + '][]"]:checked').length === 0) {
                    isValid = false;
                }
            } else if (type === 'essay' || type === 'text') {
                if ($.trim($('textarea[name="jawaban[' + qid + ']"]').val()) === '') {
                    isValid = false;
                }
            }

            // Validasi Keterangan Tambahan jika sedang muncul
            let descArea = $('#desc_area_' + qid);
            if (!descArea.hasClass('d-none')) {
                let descInput = descArea.find('textarea');
                if (descInput.attr('required') && $.trim(descInput.val()) === '') {
                    isValid = false;
                    errMsg = 'Mohon isi keterangan tambahan yang diminta.';
                }
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jawaban Belum Lengkap',
                    text: errMsg,
                    confirmButtonColor: '#0d6efd'
                });
            }

            return isValid;
        }

        // Logika untuk Keterangan Tambahan
        $('.check-input-trigger').on('change', function() {
            let pertanyaans = @json($pertanyaans);
            let qid = $(this).data('qid');
            let q = pertanyaans.find(p => p.id == qid);
            
            if (q && q.need_description_on) {
                let descArea = $('#desc_area_' + q.id);
                let descInput = descArea.find('textarea');
                let triggerValues = q.need_description_on.split(',').map(s => s.trim());
                let showDesc = false;

                // Menggunakan selector data-qid agar lebih aman dibanding mencari berdasarkan attribute name yang mengandung kurung siku
                $('.check-input-trigger[data-qid="' + q.id + '"]:checked').each(function() {
                    if (triggerValues.includes($(this).val())) {
                        showDesc = true;
                    }
                });

                if (showDesc) {
                    descArea.removeClass('d-none').hide().fadeIn(300);
                    descInput.attr('required', true);
                } else {
                    descArea.addClass('d-none');
                    descInput.attr('required', false);
                    descInput.val('');
                }
            }
        });

        // Submit Akhir
        $('#btnSubmitKuisioner').on('click', function() {
            if (validateStep(currentStep)) {
                Swal.fire({
                    title: 'Selesai Mengisi?',
                    text: "Pastikan semua jawaban sudah jujur dan benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Submit <i class="bi bi-send ms-1"></i>',
                    cancelButtonText: 'Periksa Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formKuisioner').submit();
                    }
                });
            }
        });
    });
</script>
@endpush
