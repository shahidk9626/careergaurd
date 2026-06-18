@extends('layouts.app')

@section('content')

<style>
    /* ===== TABS ===== */
    .iq-tab-bar {
        display: flex;
        gap: 4px;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 4px;
        margin-bottom: 24px;
        width: fit-content;
    }
    .iq-tab {
        padding: 8px 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        background: transparent;
        color: #64748b;
        transition: all 0.2s;
    }
    .iq-tab.active {
        background: #fff;
        color: #7e22ce;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .iq-tab-panel { display: none; }
    .iq-tab-panel.active { display: block; }

    /* PDF modal */
    .pdf-modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(15,23,42,0.6);
    z-index: 9999;
    align-items: flex-start;      /* changed from center */
    justify-content: center;
    backdrop-filter: blur(4px);
    overflow-y: auto;             /* add this */
    padding: 16px;                /* add this */
    box-sizing: border-box;       /* add this */
}
.pdf-modal-overlay.open { display: flex; }

.pdf-modal-box {
    background: #fff;
    width: 100%;
    max-width: 500px;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    overflow: hidden;
    margin: auto;                 /* centers vertically when content is short */
    flex-shrink: 0;               /* prevents it from squishing */
}
    .pdf-modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pdf-modal-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    overflow-y: auto;
    max-height: 60vh;             /* body scrolls, footer stays fixed */
}

.pdf-modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    flex-shrink: 0;               /* footer never gets pushed off screen */
}
    .pdf-field-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
    }
    .pdf-field-input {
        width: 100%;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.5rem;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .pdf-field-input:focus { border-color: #c084fc; box-shadow: 0 0 0 3px rgba(192,132,252,0.15); }

    /* PDF resource cards */
    .pdf-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        padding: 24px;
    }
    .pdf-card {
        border: 1px solid #f1f5f9;
        border-radius: 14px;
        padding: 20px;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .pdf-card:hover { border-color: #e9d5ff; box-shadow: 0 6px 20px rgba(126,34,206,0.08); }
    .pdf-card-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%);
        border: 1px solid #f3e8ff;
        display: flex; align-items: center; justify-content: center;
        color: #db2777; font-size: 18px;
    }
    .pdf-card-title { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
    .pdf-card-desc  { font-size: 12px; color: #64748b; margin: 0; line-height: 1.5; }
    .pdf-card-meta  { font-size: 11px; color: #94a3b8; }
    .pdf-card-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .pdf-status-toggle {
        display: inline-block;
        padding: 3px 10px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 999px;
        cursor: pointer;
        border: none;
    }
    .pdf-status-active   { background: #dcfce7; color: #15803d; }
    .pdf-status-inactive { background: #f1f5f9; color: #64748b; }
    .pdf-actions { display: flex; gap: 6px; }
    .pdf-btn-del {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        color: #fff; border: none; cursor: pointer; font-size: 12px;
        background: linear-gradient(135deg, #fb7185 0%, #ef4444 100%);
        transition: all 0.2s;
    }
    .pdf-btn-del:hover { opacity: 0.85; transform: translateY(-1px); }
    .pdf-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 48px 24px;
        color: #94a3b8;
    }
    .pdf-empty i { font-size: 36px; margin-bottom: 12px; display: block; }
    .pdf-empty p { font-size: 13px; margin: 0; }

    /* Reuse existing action btn styles */
    .btn-action-edit {
        width: 38px; height: 38px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 0.75rem; color: white; border: none; cursor: pointer;
        background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    .btn-action-delete {
        width: 38px; height: 38px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 0.75rem; color: white; border: none; cursor: pointer;
        background: linear-gradient(135deg, #fb7185 0%, #ef4444 100%);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    .btn-action-edit:hover, .btn-action-delete:hover {
        opacity: 0.85; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transform: translateY(-1px);
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_info { padding-left: 1.5rem !important; color: #8392ab; font-size: 0.75rem; margin-bottom: 1rem; }
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_paginate { padding-right: 1.5rem !important; color: #8392ab; font-size: 0.75rem; margin-bottom: 1rem; }
    .dataTables_wrapper .dataTables_filter input { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.25rem 0.75rem; outline: none; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%); color: white !important; border: none; border-radius: 0.5rem; }
    table.dataTable thead th, table.dataTable tbody td { padding-left: 1.5rem !important; border-bottom: 1px solid #f8f9fa; vertical-align: middle !important; }
    table.dataTable thead th.text-center, table.dataTable tbody td.text-center { padding-left: 0.5rem !important; padding-right: 0.5rem !important; text-align: center !important; }
</style>

<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">

            {{-- Card Header --}}
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <div class="flex flex-wrap -mx-3">
                    <div class="flex items-center w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
                        <h6 class="mb-0">Interview Q&A Management</h6>
                    </div>
                    <div class="w-full max-w-full px-3 text-right lg:w-1/2 lg:flex-none flex items-center justify-end gap-2" id="tab-actions">
                        {{-- Actions injected by JS depending on active tab --}}
                    </div>
                </div>
            </div>

            {{-- Tab bar --}}
            <div class="px-6 pt-5">
                <div class="iq-tab-bar">
                    <button class="iq-tab active" onclick="switchTab('questions', this)">
                        <i class="fas fa-question-circle mr-1"></i> Questions
                    </button>
                    <button class="iq-tab" onclick="switchTab('pdfs', this)">
                        <i class="fas fa-file-pdf mr-1"></i> PDF Resources
                    </button>
                </div>
            </div>

            {{-- ===== TAB 1: QUESTIONS ===== --}}
            <div id="tab-questions" class="iq-tab-panel active">
                <div class="flex-auto p-6 px-0 pb-2">
                    <div class="overflow-x-auto">
                        <table id="questionsTable" class="table items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    @if(hasPermission('questions.delete'))
                                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400" style="width:40px;">
                                            <input type="checkbox" id="selectAll" class="rounded text-purple-600 cursor-pointer">
                                        </th>
                                    @endif
                                    <th class="w-2/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Title</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Categories</th>
                                    <th class="w-4/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Question Preview</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Status</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== TAB 2: PDF RESOURCES ===== --}}
            <div id="tab-pdfs" class="iq-tab-panel">
                <div id="pdf-grid-wrap" class="pdf-grid">
                    <div class="pdf-empty">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p>Loading PDF resources...</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===== QUESTION MODAL (unchanged) ===== --}}
<div id="questionModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background-color:rgba(15,23,42,0.6); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background-color:#ffffff; width:100%; max-width:600px; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); display:flex; flex-direction:column; max-height:90vh; margin:1rem; overflow:hidden;">
        <form id="questionForm" style="display:flex; flex-direction:column; flex:1; overflow:hidden; margin:0;">
            @csrf
            <input type="hidden" id="questionId" name="id">
            <div style="padding:1.5rem; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
                <h6 id="modalTitle" style="margin:0; font-weight:700; color:#334155; font-size:1.125rem;">Add Interview Question</h6>
                <button type="button" onclick="closeModal()" style="background:none; border:none; font-size:1.5rem; line-height:1; color:#94a3b8; cursor:pointer; padding:0;">&times;</button>
            </div>
            <div style="padding:1.5rem; overflow-y:auto; flex:1; min-height:0; display:flex; flex-direction:column; gap:1rem;">
                <div>
                    <label class="pdf-field-label">Title <span style="color:#ef4444">*</span></label>
                    <input type="text" name="title" id="title" required class="pdf-field-input" placeholder="e.g. React Hook Basics">
                </div>
                <div>
                    <label class="pdf-field-label">Categories</label>
                    <div id="categoryCheckboxes" style="display:grid; grid-template-columns:repeat(2,1fr); gap:0.5rem; padding:0.75rem; background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.5rem; max-height:160px; overflow-y:auto;"></div>
                </div>
                <div>
                    <label class="pdf-field-label">Question Text <span style="color:#ef4444">*</span></label>
                    <textarea name="question_text" id="question_text" rows="2" required class="pdf-field-input" style="resize:vertical;" placeholder="Enter the exact interview question"></textarea>
                </div>
                <div>
                    <label class="pdf-field-label">Suggested Answer</label>
                    <textarea name="answer_text" id="answer_text" rows="4" class="pdf-field-input" style="resize:vertical;" placeholder="Enter the suggested or correct answer"></textarea>
                </div>
            </div>
            <div style="padding:1rem 1.5rem; border-top:1px solid #e2e8f0; background:#f8fafc; display:flex; justify-content:flex-end; gap:0.75rem; flex-shrink:0;">
                <button type="button" onclick="closeModal()" style="padding:0.625rem 1.25rem; font-size:0.75rem; font-weight:700; text-transform:uppercase; color:#475569; background:white; border:1px solid #cbd5e1; border-radius:0.5rem; cursor:pointer;">Cancel</button>
                <button type="submit" style="padding:0.625rem 1.5rem; font-size:0.75rem; font-weight:700; text-transform:uppercase; color:white; background:linear-gradient(310deg,#7e22ce 0%,#db2777 100%); border:none; border-radius:0.5rem; cursor:pointer; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">Save Question</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== PDF UPLOAD MODAL ===== --}}
<div id="pdfModal" class="pdf-modal-overlay">
    <div class="pdf-modal-box">
        <div class="pdf-modal-header">
            <h6 id="pdfModalTitle" style="margin:0; font-weight:700; color:#334155; font-size:1.1rem;">Upload PDF Resource</h6>
            <button type="button" onclick="closePdfModal()" style="background:none; border:none; font-size:1.5rem; color:#94a3b8; cursor:pointer; padding:0;">&times;</button>
        </div>
        <form id="pdfForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="pdfId" name="id">
            <div class="pdf-modal-body">
                <div>
                    <label class="pdf-field-label">Title <span style="color:#ef4444">*</span></label>
                    <input type="text" name="title" id="pdfTitle" required class="pdf-field-input" placeholder="e.g. Python Interview Q&A Pack">
                </div>
                <div>
                    <label class="pdf-field-label">Description</label>
                    <textarea name="description" id="pdfDesc" rows="2" class="pdf-field-input" style="resize:vertical;" placeholder="Brief description of what this PDF covers"></textarea>
                </div>
                <div>
                    <label class="pdf-field-label">Categories</label>
                    <div id="pdfCategoryCheckboxes" style="display:grid; grid-template-columns:repeat(2,1fr); gap:0.5rem; padding:0.75rem; background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.5rem; max-height:130px; overflow-y:auto;"></div>
                </div>
                <div id="pdf-file-field">
                    <label class="pdf-field-label">PDF File <span style="color:#ef4444">*</span></label>
                    <input type="file" name="pdf_file" id="pdfFile" accept=".pdf" class="pdf-field-input" style="padding:8px;">
                    <p style="font-size:11px; color:#94a3b8; margin:4px 0 0 0;">Max 10MB. PDF only.</p>
                </div>
            </div>
            <div class="pdf-modal-footer">
                <button type="button" onclick="closePdfModal()" style="padding:0.625rem 1.25rem; font-size:0.75rem; font-weight:700; text-transform:uppercase; color:#475569; background:white; border:1px solid #cbd5e1; border-radius:0.5rem; cursor:pointer;">Cancel</button>
                <button type="submit" style="padding:0.625rem 1.5rem; font-size:0.75rem; font-weight:700; text-transform:uppercase; color:white; background:linear-gradient(310deg,#7e22ce 0%,#db2777 100%); border:none; border-radius:0.5rem; cursor:pointer;">Upload PDF</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ─── Permissions ─────────────────────────────────────────────────────────────
    const canEdit   = {{ hasPermission('questions.edit')   ? 'true' : 'false' }};
    const canDelete = {{ hasPermission('questions.delete') ? 'true' : 'false' }};
    const canStatus = {{ hasPermission('questions.status') ? 'true' : 'false' }};

    // ─── Tab switching ────────────────────────────────────────────────────────────
    function switchTab(tab, btn) {
        document.querySelectorAll('.iq-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.iq-tab-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');
        renderTabActions(tab);
        if (tab === 'pdfs') loadPdfResources();
    }

    function renderTabActions(tab) {
        const wrap = document.getElementById('tab-actions');
        if (tab === 'questions') {
            wrap.innerHTML = `
                ${canDelete ? '<button id="bulkDeleteBtn" style="display:none;" onclick="bulkDelete()" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85 mr-2"><i class="fas fa-trash-alt mr-1"></i> Delete Selected</button>' : ''}
                ${canEdit   ? '<button onclick="openCreateModal()" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Question</button>' : ''}
            `;
        } else {
            wrap.innerHTML = `
                <button onclick="openPdfModal()" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                    <i class="fas fa-upload mr-1"></i> Upload PDF
                </button>
            `;
        }
    }

    // ─── DataTable (Questions tab) ────────────────────────────────────────────────
    let table;
    $(document).ready(function () {
        renderTabActions('questions');

        table = $('#questionsTable').DataTable({
            processing: true, serverSide: false, autoWidth: false,
            ajax: { url: "{{ route('admin.services.questions.index') }}", dataSrc: '' },
            columns: [
                @if(hasPermission('questions.delete'))
                {
                    data: 'id', orderable: false, searchable: false,
                    className: 'px-6 py-3 align-middle text-center bg-transparent border-b whitespace-nowrap shadow-none',
                    render: d => `<input type="checkbox" class="row-checkbox rounded text-purple-600 cursor-pointer" value="${d}">`
                },
                @endif
                {
                    data: 'title',
                    className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                    render: d => `<h6 class="mb-0 text-sm leading-normal whitespace-normal break-words">${d}</h6>`
                },
                {
                    data: 'categories',
                    className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                    render: d => !d || !d.length ? '<span class="text-xs text-slate-400 italic">No Categories</span>'
                        : '<div class="flex flex-wrap gap-1">' + d.map(c => `<span class="px-2 py-1 text-xxs font-bold bg-gray-100 text-slate-600 rounded-lg shadow-none border">${c.name}</span>`).join('') + '</div>'
                },
                {
                    data: 'question_text',
                    className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                    render: d => `<span class="text-xs font-semibold leading-tight text-slate-400 whitespace-normal break-words">${d.length > 50 ? d.substring(0,50)+'...' : d}</span>`
                },
                {
                    data: 'status',
                    className: 'px-6 py-3 align-middle text-center text-sm bg-transparent border-b whitespace-nowrap shadow-none',
                    render: (d, t, row) => {
                        const color = d === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        return canStatus
                            ? `<span onclick="toggleStatus(${row.id})" class="cursor-pointer text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${color}">${d}</span>`
                            : `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${color}">${d}</span>`;
                    }
                },
                {
                    data: 'id',
                    className: 'px-6 py-3 align-middle text-center bg-transparent border-b whitespace-nowrap shadow-none',
                    render: d => {
                        let a = `<div class="flex items-center justify-center gap-1.5 whitespace-nowrap">`;
                        if (canEdit)   a += `<button onclick="editQuestion(${d})"   class="btn-action-edit mx-2"><i class="fas fa-edit"></i></button>`;
                        if (canDelete) a += `<button onclick="deleteQuestion(${d})" class="btn-action-delete mx-2"><i class="fas fa-trash"></i></button>`;
                        return a + '</div>';
                    }
                }
            ],
            language: { paginate: { previous: "<i class='fas fa-angle-left'></i>", next: "<i class='fas fa-angle-right'></i>" } }
        });

        $(document).on('change', '#selectAll', function () {
            $('.row-checkbox').prop('checked', this.checked);
            toggleBulkDeleteButton();
        });
        $(document).on('change', '.row-checkbox', function () {
            if (!this.checked) $('#selectAll').prop('checked', false);
            else if ($('.row-checkbox:checked').length === $('.row-checkbox').length) $('#selectAll').prop('checked', true);
            toggleBulkDeleteButton();
        });
        table.on('draw', function () { $('#selectAll').prop('checked', false); toggleBulkDeleteButton(); });

        $('#questionForm').on('submit', function (e) {
            e.preventDefault();
            const id  = $('#questionId').val();
            const url = id ? "{{ url('admin/services/questions/update') }}/" + id : "{{ route('admin.services.questions.store') }}";
            $.post(url, $(this).serialize(), function (r) {
                Swal.fire('Success', r.success, 'success');
                closeModal();
                table.ajax.reload();
            });
        });

        // PDF form submit
        $('#pdfForm').on('submit', function (e) {
            e.preventDefault();
            const id  = $('#pdfId').val();
            const url = id
                ? "{{ url('admin/services/questions/pdf-resources/update') }}/" + id
                : "{{ url('admin/services/questions/pdf-resources/store') }}";
            const fd = new FormData(this);
            $.ajax({
                url, type: 'POST', data: fd,
                processData: false, contentType: false,
                success: function (r) {
                    Swal.fire('Success', r.success, 'success');
                    closePdfModal();
                    loadPdfResources();
                },
                error: function (xhr) {
                    const msg = xhr.responseJSON?.message || 'Upload failed.';
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });

    // ─── Question modal helpers ───────────────────────────────────────────────────
    function openModalLogic() { const m = document.getElementById('questionModal'); document.body.appendChild(m); m.style.display = 'flex'; }
    function closeModal()     { document.getElementById('questionModal').style.display = 'none'; }

    function loadCategories(selectedIds = []) {
        $.get("{{ route('admin.services.categories.index') }}?parent=interview", function (data) {
            let html = '';
            data.forEach(cat => {
                const checked = selectedIds.includes(cat.id) ? 'checked' : '';
                html += `<label style="display:inline-flex;align-items:center;cursor:pointer;margin-right:0.5rem;">
                    <input type="checkbox" name="categories[]" value="${cat.id}" ${checked} style="width:16px;height:16px;cursor:pointer;accent-color:#cb0c9f;">
                    <span style="margin-left:0.5rem;font-size:0.75rem;color:#475569;">${cat.name}</span>
                </label>`;
            });
            $('#categoryCheckboxes').html(html || '<span style="font-size:0.75rem;color:#94a3b8;font-style:italic;">No categories found.</span>');
        });
    }

    function openCreateModal() { $('#questionForm')[0].reset(); $('#questionId').val(''); $('#modalTitle').text('Add Interview Question'); loadCategories(); openModalLogic(); }

    function editQuestion(id) {
        $.get("{{ url('admin/services/questions/edit') }}/" + id, function (d) {
            $('#questionId').val(d.id); $('#title').val(d.title);
            $('#question_text').val(d.question_text); $('#answer_text').val(d.answer_text);
            $('#modalTitle').text('Edit Interview Question');
            loadCategories(d.categories ? d.categories.map(c => c.id) : []);
            openModalLogic();
        });
    }

    function toggleBulkDeleteButton() {
        const n = $('.row-checkbox:checked').length;
        if (n > 0) $('#bulkDeleteBtn').show(); else $('#bulkDeleteBtn').hide();
    }

    function bulkDelete() {
        const ids = $('.row-checkbox:checked').map(function () { return $(this).val(); }).get();
        if (!ids.length) { Swal.fire('Warning','Please select at least one record.','warning'); return; }
        Swal.fire({ title:'Delete Selected', text:'Are you sure?', icon:'warning', showCancelButton:true, confirmButtonColor:'#cb0c9f', cancelButtonColor:'#8392ab', confirmButtonText:'Yes Delete' })
            .then(r => { if (r.isConfirmed) $.ajax({ url:"{{ route('admin.services.questions.bulk-delete') }}", type:'POST', data:{ _token:"{{ csrf_token() }}", ids }, success(res) { Swal.fire('Deleted!', res.success||'Deleted.', 'success'); table.ajax.reload(null,false); $('#selectAll').prop('checked',false); toggleBulkDeleteButton(); }, error() { Swal.fire('Error','Failed.','error'); } }); });
    }

    function deleteQuestion(id) {
        Swal.fire({ title:'Delete Record', text:'Are you sure?', icon:'warning', showCancelButton:true, confirmButtonColor:'#cb0c9f', cancelButtonColor:'#8392ab', confirmButtonText:'Yes Delete' })
            .then(r => { if (r.isConfirmed) $.ajax({ url:"{{ url('admin/services/questions/delete') }}/" + id, type:'DELETE', data:{ _token:"{{ csrf_token() }}" }, success(res) { Swal.fire('Deleted!','Record deleted.','success'); table.ajax.reload(null,false); }, error() { Swal.fire('Error','Failed.','error'); } }); });
    }

    function toggleStatus(id) { $.post("{{ url('admin/services/questions/status') }}/" + id, { _token:"{{ csrf_token() }}" }, () => table.ajax.reload()); }

    // ─── PDF Resource helpers ─────────────────────────────────────────────────────
    function openPdfModal(id = null) {
        $('#pdfForm')[0].reset(); $('#pdfId').val('');
        $('#pdfModalTitle').text('Upload PDF Resource');
        $('#pdf-file-field').show();
        // Load categories into PDF modal
        $.get("{{ route('admin.services.categories.index') }}?parent=interview", function (data) {
            let html = '';
            data.forEach(cat => {
                html += `<label style="display:inline-flex;align-items:center;cursor:pointer;margin-right:0.5rem;">
                    <input type="checkbox" name="pdf_categories[]" value="${cat.id}" style="width:16px;height:16px;cursor:pointer;accent-color:#cb0c9f;">
                    <span style="margin-left:0.5rem;font-size:0.75rem;color:#475569;">${cat.name}</span>
                </label>`;
            });
            $('#pdfCategoryCheckboxes').html(html || '<span style="font-size:0.75rem;color:#94a3b8;font-style:italic;">No categories found.</span>');
        });
        if (id) {
            $.get("{{ url('admin/services/questions/pdf-resources/edit') }}/" + id, function (d) {
                $('#pdfId').val(d.id); $('#pdfTitle').val(d.title); $('#pdfDesc').val(d.description);
                $('#pdfModalTitle').text('Edit PDF Resource');
                $('#pdf-file-field').hide(); // file not required on edit
                // check categories
                if (d.categories) d.categories.forEach(c => $(`#pdfCategoryCheckboxes input[value="${c.id}"]`).prop('checked', true));
            });
        }
        document.getElementById('pdfModal').classList.add('open');
    }

    function closePdfModal() { document.getElementById('pdfModal').classList.remove('open'); }

    function loadPdfResources() {
        $.get("{{ url('admin/services/questions/pdf-resources') }}", function (data) {
            const wrap = document.getElementById('pdf-grid-wrap');
            if (!data.length) {
                wrap.innerHTML = `<div class="pdf-empty"><i class="fas fa-file-pdf"></i><p>No PDF resources uploaded yet.</p></div>`;
                return;
            }
            wrap.innerHTML = data.map(pdf => `
                <div class="pdf-card">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="pdf-card-icon"><i class="fas fa-file-pdf"></i></div>
                        <div style="min-width:0;">
                            <p class="pdf-card-title">${pdf.title}</p>
                            <p class="pdf-card-meta">Uploaded ${pdf.created_at_human}</p>
                        </div>
                    </div>
                    ${pdf.description ? `<p class="pdf-card-desc">${pdf.description}</p>` : ''}
                    ${pdf.categories && pdf.categories.length ? '<div style="display:flex;flex-wrap:wrap;gap:4px;">' + pdf.categories.map(c => `<span style="padding:2px 8px;background:#faf5ff;color:#7e22ce;border:1px solid #f3e8ff;border-radius:6px;font-size:9px;font-weight:800;text-transform:uppercase;">${c.name}</span>`).join('') + '</div>' : ''}
                    <div class="pdf-card-footer">
                        <button onclick="togglePdfStatus(${pdf.id})" class="pdf-status-toggle ${pdf.status === 'active' ? 'pdf-status-active' : 'pdf-status-inactive'}">
                            ${pdf.status}
                        </button>
                        <div class="pdf-actions">
                            <button onclick="openPdfModal(${pdf.id})" class="btn-action-edit" style="width:32px;height:32px;border-radius:8px;"><i class="fas fa-edit" style="font-size:11px;"></i></button>
                            <button onclick="deletePdf(${pdf.id})" class="pdf-btn-del"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            `).join('');
        });
    }

    function togglePdfStatus(id) {
        $.post("{{ url('admin/services/questions/pdf-resources/status') }}/" + id, { _token:"{{ csrf_token() }}" }, () => loadPdfResources());
    }

    function deletePdf(id) {
        Swal.fire({ title:'Delete PDF', text:'This will remove the file permanently.', icon:'warning', showCancelButton:true, confirmButtonColor:'#cb0c9f', cancelButtonColor:'#8392ab', confirmButtonText:'Yes Delete' })
            .then(r => { if (r.isConfirmed) $.ajax({ url:"{{ url('admin/services/questions/pdf-resources/delete') }}/" + id, type:'DELETE', data:{ _token:"{{ csrf_token() }}" }, success() { Swal.fire('Deleted!','PDF removed.','success'); loadPdfResources(); }, error() { Swal.fire('Error','Failed.','error'); } }); });
    }
</script>
@endpush