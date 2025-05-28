{{-- resources/views/opd_forms/opdb/_form.blade.php --}}

@php
    // helper to pull old input or existing model data
    if (! function_exists('f')) {
        function f(string $key, $form) {
            return old($key, data_get($form, "data.{$key}", ''));
        }
    }

    /**
     * Determine form action:
     * - $postRoute — passed in by the wrapper (create or edit)
     * - otherwise admin mode: store vs. update
     */
    $action = $postRoute
        ?? ($opd_form
            ? route('opd_forms.update', $opd_form)
            : route('opd_forms.store'));

    // Decide whether to spoof PUT when editing
    $needPut = !isset($postRoute) && isset($opd_form);
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if($needPut)
        @method('PUT')
    @endif

    <div class="text-center bg-success text-white py-2 rounded mb-4">
        <h2 class="m-0">OPD-OB Form – Window A Assignment</h2>
    </div>

    {{-- Form metadata --}}
    <div class="row g-3 mb-4">
      {{-- Form Name (fixed) --}}
      <div class="col-md-4">
          <label class="form-label">Form Name</label>
        <input value="OPD-OB FORM" class="form-control" readonly>
      </div>

      {{-- Form # (fixed) --}}
      <div class="col-md-4">
          <label class="form-label">Form #</label>
        <input value="OPD-F-07"    class="form-control" readonly>
      </div>

      {{-- Department (fixed) --}}
      <div class="col-md-4">
          <label class="form-label">Department</label>
   <input value="OB"          class="form-control" readonly>
      </div>
    </div>



    {{-- Date • Time • Health record no. --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Date</label>
            <input
                type="date"
                name="date"
                value="{{ f('date', $opd_form) }}"
                class="form-control @error('date') is-invalid @enderror"
            >
            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-2">
            <label class="form-label">Time</label>
            <input
                type="time"
                name="time"
                value="{{ f('time', $opd_form) }}"
                class="form-control @error('time') is-invalid @enderror"
            >
            @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Health Record No.</label>
            <input
                type="text"
                name="record_no"
                value="{{ f('record_no', $opd_form) }}"
                class="form-control @error('record_no') is-invalid @enderror"
            >
            @error('record_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Patient identifiers --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" value="{{ f('last_name', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Given Name</label>
            <input type="text" name="given_name" value="{{ f('given_name', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Middle Name</label>
            <input type="text" name="middle_name" value="{{ f('middle_name', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-1">
            <label class="form-label">Age</label>
            <input type="number" min="0" name="age" value="{{ f('age', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-1">
            <label class="form-label">Sex</label>
            <select name="sex" class="form-select">
                <option value=""></option>
                <option value="male"   {{ f('sex', $opd_form)=='male'   ? 'selected':'' }}>M</option>
                <option value="female" {{ f('sex', $opd_form)=='female' ? 'selected':'' }}>F</option>
            </select>
        </div>
    </div>

    {{-- Patient’s Maiden Name --}}
    <div class="mb-3">
        <label class="form-label">Patient’s Maiden Name</label>
        <input type="text" name="maiden_name" value="{{ f('maiden_name', $opd_form) }}" class="form-control">
    </div>

    {{-- Birth-related fields --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="birth_date" value="{{ f('birth_date', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Place of Birth</label>
            <input type="text" name="place_of_birth" value="{{ f('place_of_birth', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Civil Status</label>
            <input type="text" name="civil_status" value="{{ f('civil_status', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Occupation</label>
            <input type="text" name="occupation" value="{{ f('occupation', $opd_form) }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Religion</label>
            <input type="text" name="religion" value="{{ f('religion', $opd_form) }}" class="form-control">
        </div>
    </div>

    {{-- Address --}}
    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" value="{{ f('address', $opd_form) }}" class="form-control">
    </div>

    {{-- … continue copying the rest of your fields, replacing every `{{ f('…', $form) }}` with `{{ f('…', $opd_form) }}` … --}}
 {{-- Spouse / marriage --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label">Name of Husband</label>
        <input type="text" name="husband_name" value="{{ f('husband_name', $opd_form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Occupation</label>
        <input type="text" name="husband_occupation" value="{{ f('husband_occupation', $opd_form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Contact No.</label>
        <input type="text" name="husband_contact" value="{{ f('husband_contact', $opd_form) }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Place of Marriage</label>
        <input type="text" name="place_of_marriage" value="{{ f('place_of_marriage', $opd_form) }}" class="form-control">
    </div>  
    <div class="col-md-2">
        <label class="form-label">Date of Marriage</label>
        <input type="date" name="date_of_marriage" value="{{ f('date_of_marriage', $opd_form) }}" class="form-control">
    </div>
</div>

{{-- Tetanus Toxoid Immunization --}}
<h5 class="mt-4">Tetanus Toxoid Immunization</h5>
<table class="table table-sm mb-4">
    <thead><tr><th>Dose</th><th>Date</th><th>Signature</th></tr></thead>
    <tbody>
@foreach(range(1,5) as $i)
<tr>
    <td class="align-middle">T{{ $i }}</td>
    <td>
        <input
            type="date"
            name="tetanus[{{ $i-1 }}][date]"
            value="{{ f('tetanus.' . ($i-1) . '.date', $opd_form) }}"
            class="form-control"
        >
    </td>
    <td>
        <input
            type="text"
            name="tetanus[{{ $i-1 }}][signature]"
            value="{{ f('tetanus.' . ($i-1) . '.signature', $opd_form) }}"
            class="form-control"
        >
    </td>
</tr>
@endforeach
    </tbody>
</table>

{{-- Present Health Problems & Danger Signs --}}
@php
    $problems = ['HPN','DM','Bronchial asthma','Goiter','Anemia','TB','HIV, AIDS'];
    $signs    = ['Vaginal bleeding','Headache, dizziness, vomiting','Severe pallor','Fever (body weakness)','Abdominal pain','Dyspnea'];
@endphp
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <h5>Present Health Problems</h5>
        @foreach($problems as $p)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="present_problems[]" value="{{ $p }}"
                       {{ in_array($p, f('present_problems', $opd_form) ?: []) ? 'checked':'' }}>
                <label class="form-check-label">{{ $p }}</label>
            </div>
        @endforeach
        <input type="text" name="present_problems_other" value="{{ f('present_problems_other', $opd_form) }}" class="form-control mt-2" placeholder="Others">
    </div>
    <div class="col-md-6">
        <h5>Danger Signs</h5>
        @foreach($signs as $s)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="danger_signs[]" value="{{ $s }}"
                       {{ in_array($s, f('danger_signs', $opd_form) ?: []) ? 'checked':'' }}>
                <label class="form-check-label">{{ $s }}</label>
            </div>
        @endforeach
        <input type="text" name="danger_signs_other" value="{{ f('danger_signs_other', $opd_form) }}" class="form-control mt-2" placeholder="Others">
    </div>
</div>

{{-- Obstetric History --}}
<h5 class="mt-4">Gravida History</h5>
<div id="ob-history" class="mb-4">
    @php $rows = f('ob_history', $opd_form) ?: [[]]; @endphp
    @foreach($rows as $i => $row)
        <div class="row g-2 mb-2 align-items-end ob-row">
            <div class="col"><input type="date" name="ob_history[{{ $i }}][date]" value="{{ $row['date'] ?? '' }}" class="form-control"></div>
            <div class="col"><input type="text" name="ob_history[{{ $i }}][delivery_type]" value="{{ $row['delivery_type'] ?? '' }}" class="form-control" placeholder="Delivery Type"></div>
            <div class="col"><input type="text" name="ob_history[{{ $i }}][outcome]" value="{{ $row['outcome'] ?? '' }}" class="form-control" placeholder="Outcome"></div>
            <div class="col"><input type="text" name="ob_history[{{ $i }}][cx]" value="{{ $row['cx'] ?? '' }}" class="form-control" placeholder="Cx"></div>
            <div class="col-auto"><button type="button" class="btn btn-outline-danger remove-row">&times;</button></div>
        </div>
    @endforeach
    <button type="button" class="btn btn-sm btn-outline-primary" id="add-ob-row">Add row</button>
</div>

{{-- Family Planning & PNC --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label">Family Planning Method</label><br>
        @foreach(['Pills','IUD','Injectable','Withdrawal','Standard'] as $opt)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="family_planning" value="{{ $opt }}"
                       {{ f('family_planning', $opd_form) == $opt ? 'checked' : '' }}>
                <label class="form-check-label">{{ $opt }}</label>
            </div>
        @endforeach
    </div>
    <div class="col-md-4">
        <label class="form-label">Previous PNC Provider</label><br>
        @foreach(['Private','MD','HC','TBA'] as $prov)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prev_pnc" value="{{ $prov }}"
                       {{ f('prev_pnc', $opd_form) == $prov ? 'checked' : '' }}>
                <label class="form-check-label">{{ $prov }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-2">
        <label class="form-label">LMP</label>
        <input type="date" name="lmp" value="{{ f('lmp', $opd_form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">EDC</label>
        <input type="date" name="edc" value="{{ f('edc', $opd_form) }}" class="form-control">
    </div>
</div>

{{-- Gravida / Parity / AOG --}}
<div class="row g-3 mb-4">
    <div class="col-md-2"><label class="form-label">Gravida</label><input type="number" min="0" name="gravida" value="{{ f('gravida', $opd_form) }}" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">Parity T</label><input type="number" min="0" name="parity_t" value="{{ f('parity_t', $opd_form) }}" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">Parity P</label><input type="number" min="0" name="parity_p" value="{{ f('parity_p', $opd_form) }}" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">Parity A</label><input type="number" min="0" name="parity_a" value="{{ f('parity_a', $opd_form) }}" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">Parity L</label><input type="number" min="0" name="parity_l" value="{{ f('parity_l', $opd_form) }}" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">AOG (wks)</label><input type="number" min="0" name="aog_weeks" value="{{ f('aog_weeks', $opd_form) }}" class="form-control"></div>
</div>

{{-- Chief Complaint --}}
<div class="mb-4">
    <label class="form-label">Chief Complaint</label>
    <textarea name="chief_complaint" class="form-control" rows="2">{{ f('chief_complaint', $opd_form) }}</textarea>
</div>

{{-- Physical Examination Log --}}
<h5 class="mt-4">Physical Examination Log</h5>
<div id="pe-log" class="mb-4">
    @php $pelogs = f('physical_exam_log', $opd_form) ?: [[]]; @endphp
    @foreach($pelogs as $i => $log)
        <div class="row g-2 mb-2 align-items-end pe-row">
            <div class="col"><input type="date" name="physical_exam_log[{{ $i }}][date]" value="{{ $log['date'] ?? '' }}" class="form-control"></div>
            <div class="col"><input type="text" name="physical_exam_log[{{ $i }}][weight]" value="{{ $log['weight'] ?? '' }}" class="form-control" placeholder="Weight"></div>
            <div class="col"><input type="text" name="physical_exam_log[{{ $i }}][bp]" value="{{ $log['bp'] ?? '' }}" class="form-control" placeholder="BP"></div>
            <div class="col-auto"><button type="button" class="btn btn-outline-danger remove-pe">&times;</button></div>
        </div>
    @endforeach
    <button type="button" class="btn btn-sm btn-outline-primary" id="add-pe-row">Add row</button>
</div>

{{-- System Examination --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">HEENT</label>
        <textarea name="heent" class="form-control" rows="2">{{ f('heent', $opd_form) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Heart & Lungs</label>
        <textarea name="heart_lungs" class="form-control" rows="2">{{ f('heart_lungs', $opd_form) }}</textarea>
    </div>
</div>

{{-- Diagnosis --}}
<div class="mb-4">
    <label class="form-label">Diagnosis</label>
    <textarea name="diagnosis" class="form-control" rows="2">{{ f('diagnosis', $opd_form) }}</textarea>
</div>

{{-- Prepared by --}}
<div class="mb-4">
    <label class="form-label">Prepared by</label>
    <input type="text" name="prepared_by" value="{{ f('prepared_by', $opd_form) }}" class="form-control">
</div>


@if(isset($showButtons) && $showButtons)
<button type="submit" class="btn btn-primary">
    {{ isset($opd_form) ? 'Save' : 'Create' }}
</button>

    <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary ms-2">Cancel</a>
@endif

</form>

@push('scripts')
<script>
(() => {
    // OB history repeater
    const obWrap = document.getElementById('ob-history');
    document.getElementById('add-ob-row').addEventListener('click', () => {
        const idx = obWrap.querySelectorAll('.ob-row').length;
        obWrap.insertAdjacentHTML('beforeend',
            obWrap.querySelector('.ob-row').outerHTML.replace(/\[0\]/g, '['+idx+']'));
    });
    obWrap.addEventListener('click', e => {
        if (e.target.matches('.remove-row')) {
            e.target.closest('.ob-row').remove();
        }
    });

    // PE log repeater
    const peWrap = document.getElementById('pe-log');
    document.getElementById('add-pe-row').addEventListener('click', () => {
        const idx = peWrap.querySelectorAll('.pe-row').length;
        peWrap.insertAdjacentHTML('beforeend',
            peWrap.querySelector('.pe-row').outerHTML.replace(/\[0\]/g, '['+idx+']'));
    });
    peWrap.addEventListener('click', e => {
        if (e.target.matches('.remove-pe')) {
            e.target.closest('.pe-row').remove();
        }
    });
})();
</script>
@endpush
