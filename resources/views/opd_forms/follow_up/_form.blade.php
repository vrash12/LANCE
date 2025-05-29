{{-- resources/views/opd_forms/follow_up/_form.blade.php --}}
@php
    $form = $opd_form ?? null;

    // helper to pull old or existing data
    if (! function_exists('fv')) {
        function fv(string $key, $form) {
            return old($key, data_get($form, "answers.{$key}", ''));
        }
    }

    // existing follow‐ups or start with one blank row
    $rows = fv('followups', $form) ?: [[]];
@endphp

{{-- ─── Enhanced Styles ─── --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
    /* ===== Enhanced Follow-Up Form Styles ===== */
    :root {
        --primary-green: #00b467;
        --secondary-teal: #0e4749;
        --accent-blue: #1e90ff;
        --success-green: #28a745;
        --danger-red: #dc3545;
        --warning-orange: #fd7e14;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --text-muted: #6c757d;
        --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        --border-radius: 0.75rem;
        --transition: all 0.3s ease;
    }

    .form-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
    }

    /* Form Section Headers */
    .section-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #008a52 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: var(--shadow-sm);
    }

    .section-header i {
        font-size: 1.2rem;
    }

    /* Form Metadata Cards */
    .metadata-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-green);
    }

    .metadata-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    /* Enhanced Form Controls */
    .form-group-enhanced {
        margin-bottom: 1.5rem;
    }

    .form-label-enhanced {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-enhanced i {
        color: var(--primary-green);
        font-size: 0.9rem;
    }

    .form-control-enhanced {
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        font-size: 0.95rem;
    }

    .form-control-enhanced:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 103, 0.25);
        outline: none;
    }

    .form-control-enhanced:read-only {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Patient Selection Section */
    .patient-selection {
    background: white;
    border-radius: var(--border-radius);
    padding: 2.5rem; /* Increased from 2rem */
    box-shadow: var(--shadow-sm);
    margin-bottom: 2.5rem; /* Increased margin */
    border: 1px solid var(--border-color);
    min-height: 400px; /* Add minimum height for better proportion */
}

    .patient-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    /* Enhanced Select2 Styling */
    .select2-container--default .select2-selection--single {
        height: 45px;
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
        color: #495057;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 103, 0.25);
    }

    .select2-dropdown {
        border: 2px solid var(--primary-green);
        border-radius: 0.5rem;
        box-shadow: var(--shadow-md);
    }

    /* Follow-Up Table Enhancement */
    .followup-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 2rem;
    }

    .followup-table-container {
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .table-enhanced {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .table-enhanced thead {
        background: linear-gradient(135deg, var(--secondary-teal) 0%, #0a3d3f 100%);
        color: white;
    }

    .table-enhanced thead th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
        padding: 1rem 0.75rem;
        border: none;
    }

    .table-enhanced tbody tr {
        transition: var(--transition);
    }

    .table-enhanced tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        box-shadow: var(--shadow-sm);
    }

    .table-enhanced tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: var(--border-color);
    }

    /* Enhanced Table Input Fields */
    .table-input {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
        transition: var(--transition);
    }

    .table-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.1rem rgba(0, 180, 103, 0.25);
        outline: none;
    }

    /* Action Buttons */
    .btn-enhanced {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary-enhanced {
        background: linear-gradient(135deg, var(--accent-blue) 0%, #0d6efd 100%);
        color: white;
    }

    .btn-primary-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #1c7ed6 0%, #0b5ed7 100%);
    }

    .btn-success-enhanced {
        background: linear-gradient(135deg, var(--success-green) 0%, #198754 100%);
        color: white;
    }

    .btn-success-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #20c997 0%, #157347 100%);
    }

    .btn-remove {
        background: var(--danger-red);
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 1.2rem;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-remove:hover {
        background: #c82333;
        transform: scale(1.1);
        box-shadow: var(--shadow-sm);
    }

    /* Add Row Button */
    .add-row-container {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }

    .btn-add-row {
        background: linear-gradient(135deg, var(--success-green) 0%, #198754 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 2rem;
        border: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        font-size: 0.95rem;
        cursor: pointer;
    }

    .btn-add-row:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #20c997 0%, #157347 100%);
    }

    .btn-add-row i {
        font-size: 1.1rem;
    }

    /* Form Actions */
    .form-actions {
        background: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        border-top: 3px solid var(--primary-green);
    }

    /* Error Messages */
    .error-message {
        color: var(--danger-red);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .error-message i {
        font-size: 0.8rem;
    }

    /* Loading States */
    .loading {
        opacity: 0.7;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid var(--primary-green);
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Row Animation */
    .fu-row {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fu-row.removing {
        animation: slideOut 0.3s ease-in;
    }

    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }

    /* Stats Display */
    .stats-row {
        background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: #155724;
    }

    .stats-row i {
        color: var(--success-green);
        margin-right: 0.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .metadata-grid,
        .patient-info-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .table-responsive {
            font-size: 0.8rem;
        }

        .followup-table-container {
            margin: 0 -1rem;
        }

        .form-container {
            padding: 1rem;
        }
    }
</style>
@endpush

<div class="form-container">
    {{-- ─── Form Header ─── --}}
    <div class="section-header">
        <i class="fas fa-file-medical-alt"></i>
        OPD Follow-Up Form
    </div>

    {{-- ─── Form Metadata ─── --}}
    <div class="metadata-card">
        <div class="metadata-grid">
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-tag"></i>
                    Form Name
                </label>
                <input type="text" class="form-control-enhanced" value="OPD-OB FORM" readonly>
            </div>
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-hashtag"></i>
                    Form Number
                </label>
                <input type="text" class="form-control-enhanced" value="OPD-F-07" readonly>
            </div>
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-building"></i>
                    Department
                </label>
                <input type="text" class="form-control-enhanced" value="OB" readonly>
            </div>
        </div>
    </div>

    {{-- ─── Patient Selection ─── --}}
    <div class="patient-selection">
        <div class="section-header" style="margin-bottom: 1.5rem;">
            <i class="fas fa-user-plus"></i>
            Patient Information
        </div>

        <div class="form-group-enhanced">
            <label class="form-label-enhanced">
                <i class="fas fa-search"></i>
                Select Patient
            </label>
            <select id="patient_id" name="patient_id" class="form-control-enhanced"></select>
            @error('patient_id')
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="patient-info-grid">
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-user"></i>
                    Last Name
                </label>
                <input name="last_name" type="text" class="form-control-enhanced" readonly value="{{ fv('last_name',$form) }}">
            </div>
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-user"></i>
                    Given Name
                </label>
                <input name="given_name" type="text" class="form-control-enhanced" readonly value="{{ fv('given_name',$form) }}">
            </div>
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-user"></i>
                    Middle Name
                </label>
                <input name="middle_name" type="text" class="form-control-enhanced" readonly value="{{ fv('middle_name',$form) }}">
            </div>
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-birthday-cake"></i>
                    Age
                </label>
                <input name="age" type="number" min="0" class="form-control-enhanced" readonly value="{{ fv('age',$form) }}">
            </div>
            <div class="form-group-enhanced">
                <label class="form-label-enhanced">
                    <i class="fas fa-venus-mars"></i>
                    Sex
                </label>
                <input id="sex_display" type="text" class="form-control-enhanced" readonly value="{{ fv('sex',$form) ? ucfirst(fv('sex',$form)) : '' }}">
                
                @if(fv('sex',$form))
                    <input id="sex" type="hidden" name="sex" value="{{ fv('sex',$form) }}">
                @else
                    <input id="sex" type="hidden">
                @endif
                
                @error('sex')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    {{-- ─── Follow-Up Records ─── --}}
    <div class="followup-section">
        <div class="section-header" style="margin-bottom: 1.5rem;">
            <i class="fas fa-clipboard-list"></i>
            Follow-Up Records
        </div>

        {{-- Stats Row --}}
        <div class="stats-row">
            <span>
                <i class="fas fa-chart-line"></i>
                Total Follow-Up Records
            </span>
            <span id="record-count">{{ count($rows) }}</span>
        </div>

        <div id="followup-table">
            <div class="followup-table-container">
                <table class="table table-enhanced">
                    <thead>
                        <tr>
                            <th style="width:130px">
                                <i class="fas fa-calendar me-2"></i>
                                Date
                            </th>
                            <th style="width:130px">
                                <i class="fas fa-baby me-2"></i>
                                Gest. Weeks
                            </th>
                            <th style="width:130px">
                                <i class="fas fa-weight me-2"></i>
                                Weight (kg)
                            </th>
                            <th style="width:130px">
                                <i class="fas fa-heartbeat me-2"></i>
                                Blood Pressure
                            </th>
                            <th>
                                <i class="fas fa-notes-medical me-2"></i>
                                Remarks
                            </th>
                            <th style="width:60px">
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="fu-tbody">
                        @foreach($rows as $i => $row)
                            <tr class="fu-row">
                                <td>
                                    <input type="date" name="followups[{{ $i }}][date]" class="table-input" value="{{ $row['date'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" name="followups[{{ $i }}][gest_weeks]" class="table-input" placeholder="0" value="{{ $row['gest_weeks'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="followups[{{ $i }}][weight]" class="table-input" placeholder="0.00" value="{{ $row['weight'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" name="followups[{{ $i }}][bp]" class="table-input" placeholder="120/80" value="{{ $row['bp'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" name="followups[{{ $i }}][remarks]" class="table-input" placeholder="Enter remarks..." value="{{ $row['remarks'] ?? '' }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-remove remove-row" title="Remove this record">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="add-row-container">
                <button id="add-followup" type="button" class="btn-add-row">
                    <i class="fas fa-plus"></i>
                    Add Follow-Up Record
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
$(function(){
    let idx = {{ count($rows) }};

    /* ─── Enhanced Select2 Patient Search & Autofill ─── */
    $('#patient_id').select2({
        placeholder: '🔍 Type to search for a patient...',
        ajax: {
            url: '{{ route("patients.search") }}',
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term || '' }),
            processResults: data => ({ results: data.results }),
            cache: true
        },
        minimumInputLength: 0,
        allowClear: true,
        width: '100%'
    }).on('focus click', function() {
        $(this).select2('open');
    });

    $('#patient_id').on('select2:select', e => {
        const p = e.params.data;
        
        // Add loading animation
        $('.patient-info-grid input').addClass('loading');
        
        setTimeout(() => {
            $('input[name=last_name]').val(p.last_name);
            $('input[name=given_name]').val(p.given_name);
            $('input[name=middle_name]').val(p.middle_name);
            $('input[name=age]').val(p.age);

            /* ── Handle sex ── */
            const sexRaw = (p.sex || '').toLowerCase();

            // Update display
            $('#sex_display').val(
                sexRaw ? sexRaw.charAt(0).toUpperCase() + sexRaw.slice(1) : ''
            );

            // Update hidden field
            const $hidden = $('#sex');
            if (sexRaw === '') {
                $hidden.removeAttr('name').val('');
            } else {
                $hidden.attr('name', 'sex').val(sexRaw);
            }

            // Remove loading animation
            $('.patient-info-grid input').removeClass('loading');
            
            // Show success feedback
            showNotification('Patient information loaded successfully!', 'success');
        }, 500);
    });

    /* ─── Enhanced Dynamic Follow-Up Rows ─── */
    $('#add-followup').on('click', function() {
        const $button = $(this);
        $button.addClass('loading');
        
        setTimeout(() => {
            $('#fu-tbody').append(renderRow(idx++));
            updateRecordCount();
            $button.removeClass('loading');
            showNotification('New follow-up record added!', 'success');
        }, 300);
    });

    $('#followup-table').on('click', '.remove-row', function(){
        const $row = $(this).closest('tr');
        $row.addClass('removing');
        
        setTimeout(() => {
            $row.remove();
            updateRecordCount();
            showNotification('Follow-up record removed!', 'info');
        }, 300);
    });

    function renderRow(i) {
        return `
            <tr class="fu-row">
                <td>
                    <input type="date" name="followups[\${i}][date]" class="table-input">
                </td>
                <td>
                    <input type="number" name="followups[\${i}][gest_weeks]" class="table-input" placeholder="0">
                </td>
                <td>
                    <input type="number" step="0.01" name="followups[\${i}][weight]" class="table-input" placeholder="0.00">
                </td>
                <td>
                    <input type="text" name="followups[\${i}][bp]" class="table-input" placeholder="120/80">
                </td>
                <td>
                    <input type="text" name="followups[\${i}][remarks]" class="table-input" placeholder="Enter remarks...">
                </td>
                <td class="text-center">
                    <button type="button" class="btn-remove remove-row" title="Remove this record">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>`;
    }

    function updateRecordCount() {
        const count = $('#fu-tbody tr').length;
        $('#record-count').text(count);
        
        // Update count with animation
        $('#record-count').addClass('loading');
        setTimeout(() => {
            $('#record-count').removeClass('loading');
        }, 200);
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = $(`
            <div class="alert alert-${type === 'success' ? 'success' : type === 'info' ? 'info' : 'warning'} alert-dismissible" 
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : 'exclamation-triangle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    /* ─── Form Validation Enhancement ─── */
    $('form').on('submit', function(e) {
        let hasErrors = false;
        const requiredFields = ['patient_id'];
        
        requiredFields.forEach(field => {
            if (!$(`.form-group-enhanced input[name="${field}"], .form-group-enhanced select[name="${field}"]`).val()) {
                hasErrors = true;
                showNotification(`Please fill in the ${field.replace('_', ' ')} field.`, 'error');
            }
        });
        
        if (hasErrors) {
            e.preventDefault();
        } else {
            $(this).find('button[type="submit"]').addClass('loading');
            showNotification('Saving follow-up form...', 'info');
        }
    });

    /* ─── Auto-save functionality (optional) ─── */
    let autoSaveTimeout;
    $('input, select, textarea').on('change', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Implement auto-save logic here if needed
            console.log('Auto-saving form data...');
        }, 2000);
    });

    /* ─── Initialize tooltips ─── */
    $('[title]').tooltip();
});
</script>
@endpush