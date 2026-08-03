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
                                <div class="mb-3 d-flex justify-content-between align-items-center text-muted small fw-bold" id="progressIndicatorBox">
                                    <span id="currentCabangIndicator" class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"></span>
                                    <span>Tahap <span id="currentStepIndicator">1</span> dari <span id="totalStepIndicator">-</span></span>
                                </div>

                                @foreach($kuisionerCabangs as $cabang)
                                
                                {{-- HIDDEN INPUTS UNTUK FLAG BRANCHING PER CABANG --}}
                                <input type="hidden" name="is_melakukan[{{ $cabang->id }}]" id="is_melakukan_{{ $cabang->id }}" value="">
                                <input type="hidden" name="is_mengetahui[{{ $cabang->id }}]" id="is_mengetahui_{{ $cabang->id }}" value="">
                                <input type="hidden" name="is_mengetahui2[{{ $cabang->id }}]" id="is_mengetahui2_{{ $cabang->id }}" value="">

                                {{-- STEP: UTAMA 1 --}}
                                <div class="question-step d-none" id="step_cabang_{{ $cabang->id }}_utama1" data-cid="{{ $cabang->id }}" data-type="utama1">
                                    <div class="card shadow-sm border-0 mb-4 bg-light">
                                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                                            <span class="badge bg-primary mb-2">Pertanyaan Utama</span>
                                            <span class="badge bg-outline-secondary text-secondary mb-2 ms-1 border">Cabang: {{ $cabang->dealerCabang->cabang }}</span>
                                            <h6 class="fw-bold mb-0">1. Selama bekerja di cabang ini pada periode tersebut, apakah Anda pernah melakukan, membantu, atau terlibat dalam tindakan yang tidak sesuai dengan prosedur atau peraturan perusahaan?</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input trigger-utama1" type="radio" name="utama1[{{ $cabang->id }}]" id="c{{ $cabang->id }}_u1_ans1" value="Ya" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label" for="c{{ $cabang->id }}_u1_ans1">Ya, pernah melakukan atau terlibat</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input trigger-utama1" type="radio" name="utama1[{{ $cabang->id }}]" id="c{{ $cabang->id }}_u1_ans2" value="Tidak" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label" for="c{{ $cabang->id }}_u1_ans2">Tidak pernah melakukan atau terlibat</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input trigger-utama1" type="radio" name="utama1[{{ $cabang->id }}]" id="c{{ $cabang->id }}_u1_ans3" value="Info" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label" for="c{{ $cabang->id }}_u1_ans3">Saya membutuhkan penjelasan mengenai tindakan yang dimaksud</label>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 description-area d-none" id="desc_area_cabang_{{ $cabang->id }}_utama1">
                                                <div class="alert alert-info small mb-0 border-0 shadow-sm">
                                                    <strong><i class="bi bi-info-circle me-1"></i> Penjelasan Tindakan:</strong><br>
                                                    <div class="mt-1 text-dark" style="white-space: pre-wrap;">Tindakan yang dimaksud meliputi:
• Menjual atau menyerahkan Freon
• Menjual, mengambil, atau menyerahkan oli
• Menjual, mengambil, atau menyerahkan material/suku cadang
• Melakukan pekerjaan tanpa Work Order
• Melakukan pekerjaan di luar prosedur perusahaan
• Menerima pembayaran langsung dari pelanggan atau pihak dealer
• Mengumpulkan barang atau hasil dari mekanik lain
• Membantu pihak lain melakukan tindakan tersebut
• Mengajak, mengarahkan, menyuruh, atau mengajari pihak lain
• Menyembunyikan atau mengubah informasi pekerjaan</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- STEP: UTAMA 2 --}}
                                <div class="question-step d-none" id="step_cabang_{{ $cabang->id }}_utama2" data-cid="{{ $cabang->id }}" data-type="utama2">
                                    <div class="card shadow-sm border-0 mb-4 bg-light">
                                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                                            <span class="badge bg-primary mb-2">Pertanyaan Utama Lanjutan</span>
                                            <span class="badge bg-outline-secondary text-secondary mb-2 ms-1 border">Cabang: {{ $cabang->dealerCabang->cabang }}</span>
                                            <h6 class="fw-bold mb-0">2. Selama bekerja di cabang ini, apakah Anda pernah mengetahui, melihat, atau menerima informasi mengenai tindakan yang tidak sesuai dengan prosedur atau peraturan perusahaan?</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input trigger-utama2" type="radio" name="utama2[{{ $cabang->id }}]" id="c{{ $cabang->id }}_u2_ans1" value="Langsung" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label" for="c{{ $cabang->id }}_u2_ans1">Ya, mengetahui atau melihat secara langsung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input trigger-utama2" type="radio" name="utama2[{{ $cabang->id }}]" id="c{{ $cabang->id }}_u2_ans2" value="Mendengar" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label" for="c{{ $cabang->id }}_u2_ans2">Ya, pernah mendengar dari pihak lain</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input trigger-utama2" type="radio" name="utama2[{{ $cabang->id }}]" id="c{{ $cabang->id }}_u2_ans3" value="Tidak" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label" for="c{{ $cabang->id }}_u2_ans3">Tidak mengetahui</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- STEPS: DYNAMIC KRONOLOGI PER CABANG --}}
                                @foreach($pertanyaans as $index => $q)
                                @if(in_array($q->category, ['utama1', 'utama2'])) @continue @endif
                                <div class="question-step d-none" id="step_cabang_{{ $cabang->id }}_dyn_{{ $q->id }}" data-cid="{{ $cabang->id }}" data-qid="{{ $q->id }}" data-type="{{ $q->type }}">
                                    <div class="card shadow-sm border-0 mb-4 bg-light">
                                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                                            <span class="badge bg-secondary mb-2">
                                                @if($q->category == 'melakukan') Kronologi (Bagian D)
                                                @elseif($q->category == 'mengetahui1') Kronologi Mengetahui Langsung (Bagian E1)
                                                @elseif($q->category == 'mengetahui2') Kronologi Mendengar (Bagian E2)
                                                @endif
                                            </span>
                                            <span class="badge bg-outline-secondary text-secondary mb-2 ms-1 border">Cabang: {{ $cabang->dealerCabang->cabang }}</span>
                                            <h6 class="fw-bold mb-0">
                                                Pertanyaan Kronologi: {{ $q->pertanyaan }}
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $opsi = json_decode($q->list_jawaban, true) ?? [];
                                            @endphp
                                            
                                            @if(in_array($q->type, ['select', 'select-description', 'select-info']) && count($opsi) > 0)
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach($opsi as $jawaban)
                                                    <div class="form-check">
                                                        <input class="form-check-input check-input-trigger" type="radio" name="jawaban[{{ $cabang->id }}][{{ $q->id }}]" id="c{{ $cabang->id }}_q{{ $q->id }}_ans{{ $loop->index }}" value="{{ $jawaban }}" data-cid="{{ $cabang->id }}" data-qid="{{ $q->id }}">
                                                        <label class="form-check-label" for="c{{ $cabang->id }}_q{{ $q->id }}_ans{{ $loop->index }}">
                                                            {{ $jawaban }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @elseif(in_array($q->type, ['multiselect', 'multiselect-description']) && count($opsi) > 0)
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach($opsi as $jawaban)
                                                    <div class="form-check">
                                                        <input class="form-check-input check-input-trigger" type="checkbox" name="jawaban[{{ $cabang->id }}][{{ $q->id }}][]" id="c{{ $cabang->id }}_q{{ $q->id }}_ans{{ $loop->index }}" value="{{ $jawaban }}" data-cid="{{ $cabang->id }}" data-qid="{{ $q->id }}">
                                                        <label class="form-check-label" for="c{{ $cabang->id }}_q{{ $q->id }}_ans{{ $loop->index }}">
                                                            {{ $jawaban }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @elseif($q->type == 'essay')
                                                <textarea class="form-control req-input" name="jawaban[{{ $cabang->id }}][{{ $q->id }}]" rows="3" placeholder="{{ $q->desciption_hint }}"></textarea>
                                            @endif
                                            
                                            {{-- Area deskripsi (default hidden unless *) --}}
                                            @php 
                                                $isAlwaysShow = false;
                                                if ($q->need_description_on === '*') {
                                                    $isAlwaysShow = true;
                                                } else if (empty($q->need_description_on) && in_array($q->type, ['select-description', 'multiselect-description'])) {
                                                    $isAlwaysShow = true;
                                                }
                                            @endphp

                                            @if($q->need_description_on || $isAlwaysShow)
                                            <div class="mt-3 description-area {{ $isAlwaysShow ? '' : 'd-none' }}" id="desc_area_cabang_{{ $cabang->id }}_{{ $q->id }}">
                                                @if($q->type == 'select-info')
                                                    <div class="alert alert-info small mb-0 border-0 shadow-sm">
                                                        <strong><i class="bi bi-info-circle me-1"></i> Penjelasan Tambahan:</strong><br>
                                                        <div class="mt-1 text-dark" style="white-space: pre-wrap;">{{ $q->desciption_hint }}</div>
                                                    </div>
                                                @else
                                                    <label class="form-label text-muted small fw-bold"><i class="bi bi-info-circle me-1"></i>Keterangan Tambahan</label>
                                                    <textarea class="form-control" name="deskripsi[{{ $cabang->id }}][{{ $q->id }}]" rows="2" placeholder="{{ $q->desciption_hint }}"></textarea>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                {{-- STEP: KONFIRMASI CABANG --}}
                                <div class="question-step d-none" id="step_cabang_{{ $cabang->id }}_konfirmasi" data-cid="{{ $cabang->id }}" data-type="konfirmasi">
                                    <div class="card shadow-sm border-0 mb-4 bg-light">
                                        <div class="card-body text-center py-5">
                                            <i class="bi bi-check2-circle text-primary" style="font-size: 3rem;"></i>
                                            <h5 class="fw-bold mt-3">Konfirmasi Jawaban Cabang</h5>
                                            <p class="text-muted">Anda telah menyelesaikan pertanyaan untuk cabang <strong>{{ $cabang->dealerCabang->cabang }}</strong>.</p>
                                            <div class="mt-4 p-3 bg-white border rounded shadow-sm d-inline-block text-start">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="c{{ $cabang->id }}_konfirmasi_check" data-cid="{{ $cabang->id }}">
                                                    <label class="form-check-label text-dark fw-semibold" for="c{{ $cabang->id }}_konfirmasi_check">
                                                        Saya menyatakan bahwa jawaban untuk cabang ini sudah benar.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="button" class="btn btn-success btn-lg px-4 rounded-pill shadow-sm" id="btnSaveCabang_{{ $cabang->id }}" onclick="saveCabang({{ $cabang->id }})">
                                                    <i class="bi bi-save me-2"></i> Simpan & Kunci Jawaban Cabang Ini
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @endforeach

                                {{-- STEP: SUBMIT SCREEN --}}
                                <div class="question-step d-none" id="step_submit" data-type="submit">
                                    <div class="card shadow-sm border-0 mb-4 bg-light">
                                        <div class="card-header bg-white border-bottom-0 pt-4 pb-2 text-start">
                                            <span class="badge bg-success mb-2"><i class="bi bi-stars"></i> Penyelesaian Formulir</span>
                                            <h6 class="fw-bold mb-0 lh-base">Berdasarkan pengalaman dan pengetahuan Anda, apa yang perlu diperbaiki oleh Perusahaan agar pelanggaran serupa tidak terjadi kembali, dan apakah masih ada informasi penting yang belum Anda sampaikan?</h6>
                                        </div>
                                        <div class="card-body">
                                            <textarea class="form-control" name="saran_perbaikan" id="saran_perbaikan" rows="4" placeholder="Tuliskan saran dan perbaikan di sini..."></textarea>
                                            
                                            <div class="text-center py-4 border-top mt-4">
                                                <i class="bi bi-check-circle-fill text-success" style="font-size: 3.5rem;"></i>
                                                <h4 class="fw-bold mt-3">Formulir Selesai</h4>
                                                <p class="text-muted">Anda telah menjawab seluruh pertanyaan untuk semua cabang. Pastikan saran Anda telah terisi, lalu klik tombol di bawah untuk mengirimkan kuesioner.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column-reverse flex-md-row justify-content-between gap-3 mt-4">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold w-100 w-md-auto" id="btnPrev">
                                        <i class="bi bi-arrow-left me-2"></i> Sebelumnya
                                    </button>
                                    
                                    <button type="button" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm w-100 w-md-auto" id="btnNext">
                                        Selanjutnya <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                    
                                    <!-- Aksi form final sekarang mengarah ke submitAll, bukan hanya aksi # -->
                                    <button type="button" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm d-none w-100 w-md-auto" id="btnSubmitKuisioner">
                                        <i class="bi bi-send me-2"></i> Selesaikan Kuesioner
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
        // ID Lists from Backend
        const pertanyaansData = @json($pertanyaans);
        const cabangsData = @json($kuisionerCabangs);
        
        const melakukanIds = pertanyaansData.filter(p => p.category === 'melakukan').map(p => p.id);
        const mengetahui1Ids = pertanyaansData.filter(p => p.category === 'mengetahui1').map(p => p.id);
        const mengetahui2Ids = pertanyaansData.filter(p => p.category === 'mengetahui2').map(p => p.id);
        
        let currentFlow = [];
        let currentIndex = 0;
        let minAllowedIndex = 0; // Kunci supaya tidak bisa kembali melewati cabang yang sudah di-save

        // Fungsi Rebuild Flow Path Linier Multicabang
        function buildFlow() {
            let newFlow = [];
            
            cabangsData.forEach(c => {
                let cid = c.id;
                newFlow.push('cabang_' + cid + '_utama1');
                
                let ans1 = $('input[name="utama1[' + cid + ']"]:checked').val();
                let ans2 = $('input[name="utama2[' + cid + ']"]:checked').val();
                
                if (ans1 === 'Ya') {
                    $('#is_melakukan_' + cid).val(1);
                    $('#is_mengetahui_' + cid).val('');
                    $('#is_mengetahui2_' + cid).val('');
                    melakukanIds.forEach(id => newFlow.push('cabang_' + cid + '_dyn_' + id));
                } else if (ans1 === 'Tidak') {
                    $('#is_melakukan_' + cid).val(0);
                    newFlow.push('cabang_' + cid + '_utama2');
                    
                    if (ans2 === 'Langsung') {
                        $('#is_mengetahui_' + cid).val(1);
                        $('#is_mengetahui2_' + cid).val(0);
                        mengetahui1Ids.forEach(id => newFlow.push('cabang_' + cid + '_dyn_' + id));
                    } else if (ans2 === 'Mendengar') {
                        $('#is_mengetahui_' + cid).val(0);
                        $('#is_mengetahui2_' + cid).val(1);
                        mengetahui2Ids.forEach(id => newFlow.push('cabang_' + cid + '_dyn_' + id));
                    } else if (ans2 === 'Tidak') {
                        $('#is_mengetahui_' + cid).val(0);
                        $('#is_mengetahui2_' + cid).val(0);
                    }
                }
                
                // Tambahkan step konfirmasi di akhir setiap cabang
                newFlow.push('cabang_' + cid + '_konfirmasi');
            });
            
            newFlow.push('submit');
            currentFlow = newFlow;
        }

        // Tampilkan Step
        function renderStep() {
            buildFlow(); // pastikan flow up to date
            
            // Jaga agar currentIndex tidak melebihi panjang array baru (misal user ubah jawaban dari cabang sebelumnya)
            if (currentIndex >= currentFlow.length) {
                currentIndex = currentFlow.length - 1;
            }
            
            let currentStepId = currentFlow[currentIndex];
            
            $('.question-step').addClass('d-none');
            let $activeStep = $('#step_' + currentStepId);
            $activeStep.removeClass('d-none').hide().fadeIn(300);

            // Indikator Progress
            if (currentStepId === 'submit') {
                $('#progressIndicatorBox').addClass('d-none');
            } else {
                $('#progressIndicatorBox').removeClass('d-none');
                $('#currentStepIndicator').text(currentIndex + 1);
                $('#totalStepIndicator').text(currentFlow.length - 1);
                
                // Cari info cabang saat ini dari data-attribute
                let activeCid = $activeStep.data('cid');
                if (activeCid) {
                    let cData = cabangsData.find(c => c.id == activeCid);
                    if (cData && cData.dealer_cabang) {
                        $('#currentCabangIndicator').html('<i class="bi bi-shop me-1"></i> ' + cData.dealer_cabang.cabang);
                    }
                }
            }

            // Tombol Prev
            if (currentIndex <= minAllowedIndex) {
                $('#btnPrev').addClass('invisible');
            } else {
                $('#btnPrev').removeClass('invisible');
            }

            // Tombol Next & Submit
            if (currentStepId === 'submit') {
                $('#btnNext').addClass('d-none');
                $('#btnSubmitKuisioner').removeClass('d-none');
            } else if ($activeStep.data('type') === 'konfirmasi') {
                // Di tahap konfirmasi, Next digantikan oleh tombol Simpan AJAX,
                // Namun kita perlu pastikan Next disembunyikan.
                $('#btnNext').addClass('d-none');
                $('#btnSubmitKuisioner').addClass('d-none');
            } else {
                $('#btnNext').removeClass('d-none');
                $('#btnSubmitKuisioner').addClass('d-none');
            }
        }

        // Toggle Penjelasan Utama 1 per Cabang
        $('.trigger-utama1').on('change', function() {
            let cid = $(this).data('cid');
            if ($(this).val() === 'Info') {
                $('#desc_area_cabang_' + cid + '_utama1').removeClass('d-none').hide().fadeIn(300);
            } else {
                $('#desc_area_cabang_' + cid + '_utama1').addClass('d-none');
            }
            buildFlow();
        });

        // Toggle Utama 2 per Cabang
        $('.trigger-utama2').on('change', function() {
            buildFlow();
        });

        // Validasi Step
        function validateStep(stepId) {
            let isValid = true;
            let errMsg = 'Mohon lengkapi jawaban Anda.';

            let stepDiv = $('#step_' + stepId);
            let cid = stepDiv.data('cid');

            if (stepDiv.data('type') === 'utama1') {
                let ans = $('input[name="utama1[' + cid + ']"]:checked').val();
                if (!ans) {
                    isValid = false;
                } else if (ans === 'Info') {
                    isValid = false;
                    errMsg = 'Opsi ini hanya untuk membaca penjelasan. Anda tetap harus memilih "Ya" atau "Tidak".';
                }
            } else if (stepDiv.data('type') === 'utama2') {
                let ans = $('input[name="utama2[' + cid + ']"]:checked').val();
                if (!ans) isValid = false;
            } else if (stepDiv.data('type') === 'konfirmasi') {
                let isChecked = $('#c' + cid + '_konfirmasi_check').is(':checked');
                if (!isChecked) {
                    isValid = false;
                    errMsg = 'Anda harus mencentang kotak persetujuan untuk menyatakan bahwa jawaban di cabang ini sudah benar.';
                }
            } else if (stepId.includes('_dyn_')) {
                let qid = stepDiv.data('qid');
                let type = stepDiv.data('type');
                let qData = pertanyaansData.find(p => p.id == qid);

                if (type === 'select-description' || type === 'select-info' || type === 'select' || type === 'radio') {
                    let checkedInput = $('input[name="jawaban[' + cid + '][' + qid + ']"]:checked');
                    if (checkedInput.length === 0) {
                        isValid = false;
                    } else {
                        // Cek jika ini select-info dan valuenya butuh penjelasan
                        if (qData && type === 'select-info' && checkedInput.val() === qData.need_description_on) {
                            isValid = false;
                            errMsg = 'Opsi ini hanya untuk membaca penjelasan. Anda tetap harus memilih "Ya" atau "Tidak" untuk melanjutkan.';
                        }
                    }
                } else if (type === 'multiselect' || type === 'multiselect-description') {
                    if ($('input[name="jawaban[' + cid + '][' + qid + '][]"]:checked').length === 0) {
                        isValid = false;
                    }
                } else if (type === 'essay' || type === 'text') {
                    if ($.trim($('textarea[name="jawaban[' + cid + '][' + qid + ']"]').val()) === '') {
                        isValid = false;
                    }
                }

                // Keterangan Tambahan dinamis
                let descArea = $('#desc_area_cabang_' + cid + '_' + qid);
                let isAlways = false;
                if (qData && qData.need_description_on === '*') isAlways = true;
                if (qData && !qData.need_description_on && (type === 'select-description' || type === 'multiselect-description')) isAlways = true;

                if (isAlways || !descArea.hasClass('d-none')) {
                    let descInput = descArea.find('textarea');
                    let isRequired = isAlways || descInput.attr('required');
                    
                    if (descInput.length > 0 && isRequired && $.trim(descInput.val()) === '') {
                        isValid = false;
                        errMsg = 'Mohon isi keterangan tambahan yang diminta.';
                    }
                }
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: errMsg,
                    confirmButtonColor: '#0d6efd'
                });
            }

            return isValid;
        }

        // Aksi Tombol
        $('#btnNext').on('click', function() {
            let currentStepId = currentFlow[currentIndex];
            if (validateStep(currentStepId)) {
                buildFlow(); // pastikan rute di-rebuild
                currentIndex++;
                renderStep();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        $('#btnPrev').on('click', function() {
            if (currentIndex > minAllowedIndex) {
                currentIndex--;
                renderStep();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // AJAX Save Cabang (Global Function)
        window.saveCabang = function(cid) {
            let currentStepId = currentFlow[currentIndex];
            if (!validateStep(currentStepId)) {
                return;
            }

            // Kumpulkan data yang berkaitan dengan cid ini saja
            let formData = new FormData($('#formKuisioner')[0]);
            let ajaxData = {
                _token: formData.get('_token'),
                cid: cid,
                is_melakukan: $('#is_melakukan_' + cid).val(),
                is_mengetahui: $('#is_mengetahui_' + cid).val(),
                is_mengetahui2: $('#is_mengetahui2_' + cid).val(),
                jawaban: {},
                deskripsi: {}
            };

            // Parse jawaban dan deskripsi dari formData
            for (let [key, value] of formData.entries()) {
                // regex matching jawaban[cid][qid]
                let matchAns = key.match(/^jawaban\[(\d+)\]\[(\d+)\](?:\[\])?$/);
                if (matchAns && matchAns[1] == cid) {
                    let qid = matchAns[2];
                    if (key.endsWith('[]')) {
                        if (!ajaxData.jawaban[qid]) ajaxData.jawaban[qid] = [];
                        ajaxData.jawaban[qid].push(value);
                    } else {
                        ajaxData.jawaban[qid] = value;
                    }
                }
                // regex matching deskripsi[cid][qid]
                let matchDesc = key.match(/^deskripsi\[(\d+)\]\[(\d+)\]$/);
                if (matchDesc && matchDesc[1] == cid) {
                    let qid = matchDesc[2];
                    ajaxData.deskripsi[qid] = value;
                }
            }

            let btn = $('#btnSaveCabang_' + cid);
            let btnOriginalHtml = btn.html();
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...').prop('disabled', true);

            $.ajax({
                url: '{{ route('kuisioner.storeCabangJawaban') }}',
                type: 'POST',
                data: ajaxData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Jawaban untuk cabang ini telah disimpan.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            btn.html('<i class="bi bi-check-lg"></i> Tersimpan').removeClass('btn-success').addClass('btn-secondary');
                            
                            // Kunci agar tidak bisa mundur
                            minAllowedIndex = currentIndex + 1;
                            
                            // Lanjut otomatis ke langkah berikutnya
                            buildFlow();
                            currentIndex++;
                            renderStep();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                    }
                },
                error: function(xhr) {
                    btn.html(btnOriginalHtml).prop('disabled', false);
                    Swal.fire('Terjadi Kesalahan', 'Gagal menyimpan data. Silakan coba lagi.', 'error');
                }
            });
        };

        // Deskripsi Dinamis (Bagian Kronologi & Info)
        $('.check-input-trigger').on('change', function() {
            let qid = $(this).data('qid');
            let cid = $(this).data('cid');
            let q = pertanyaansData.find(p => p.id == qid);
            
            if (q) {
                let isAlways = false;
                if (q.need_description_on === '*') isAlways = true;
                if (!q.need_description_on && (q.type === 'select-description' || q.type === 'multiselect-description')) isAlways = true;
                
                if (isAlways) {
                    return; // Selalu tampil, tidak perlu di-toggle
                }

                if (q.need_description_on) {
                    let descArea = $('#desc_area_cabang_' + cid + '_' + q.id);
                    let descInput = descArea.find('textarea');
                    let triggerValues = q.need_description_on.split(',').map(s => s.trim());
                    let showDesc = false;

                    $('.check-input-trigger[data-qid="' + q.id + '"][data-cid="' + cid + '"]:checked').each(function() {
                        if (triggerValues.includes($(this).val())) {
                            showDesc = true;
                        }
                    });

                    if (showDesc) {
                        descArea.removeClass('d-none').hide().fadeIn(300);
                        if(descInput.length) descInput.attr('required', true);
                    } else {
                        descArea.addClass('d-none');
                        if(descInput.length) {
                            descInput.attr('required', false);
                            descInput.val('');
                        }
                    }
                }
            }
            
            // Rebuild flow in case it's a branching trigger
            buildFlow();
        });

        // Submit Form
        $('#btnSubmitKuisioner').on('click', function() {
            let saran = $.trim($('#saran_perbaikan').val());
            if (saran === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Isian Belum Lengkap',
                    text: 'Mohon isi saran dan masukan Anda mengenai apa yang perlu diperbaiki oleh perusahaan sebelum menyelesaikan formulir.',
                    confirmButtonColor: '#0d6efd'
                });
                return;
            }

            Swal.fire({
                title: 'Kirim Semua Jawaban?',
                text: "Pastikan semua saran dan masukan sudah Anda isi dengan jujur dan benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim Sekarang <i class="bi bi-send ms-1"></i>',
                cancelButtonText: 'Periksa Lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formKuisioner').attr('action', '{{ route('kuisioner.submitAll') }}');
                    $('#formKuisioner').submit();
                }
            });
        });

        // Render Awal
        renderStep();
    });
</script>
@endpush
