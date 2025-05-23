{{-- resources/views/opd_forms/_form.blade.php --}}
@php
    // When editing, $opd_form is passed in; when creating it is null.
    $form = $opd_form ?? null;

    /**
     * Helper – returns the previous input value, falling back to the model
     * attribute (if in edit) or empty string.
     */
    function f($key, $form) {
        return old($key, $form->data[$key] ?? '');
    }
@endphp

{{-- ───────────────────────── Frame header (green bar) ───────────────────────── --}}
<div class="text-center bg-success text-white py-2 mb-4 rounded">
    <h2 class="m-0">OPD Form – Window A Assignment</h2>
</div>

{{-- Every group below is wrapped in .row so Bootstrap will align nicely --}}
{{-- Date • Time • Health record no. --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Date</label>
        <input  type="date" name="date"
                value="{{ f('date', $form) }}"
                class="form-control @error('date') is-invalid @enderror">
        @error('date') <div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-2">
        <label class="form-label">Time</label>
        <input  type="time" name="time"
                value="{{ f('time', $form) }}"
                class="form-control @error('time') is-invalid @enderror">
        @error('time') <div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Health Record No. <span class="fst-italic text-muted">(if applicable)</span></label>
        <input  type="text" name="record_no"
                value="{{ f('record_no', $form) }}"
                class="form-control @error('record_no') is-invalid @enderror">
        @error('record_no') <div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- ① Patient name – last • given • middle • age • sex • maiden --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" value="{{ f('last_name',$form) }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Given Name</label>
        <input type="text" name="given_name" value="{{ f('given_name',$form) }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Middle Name</label>
        <input type="text" name="middle_name" value="{{ f('middle_name',$form) }}" class="form-control">
    </div>
    <div class="col-md-1">
        <label class="form-label">Age</label>
        <input type="number" min="0" name="age" value="{{ f('age',$form) }}" class="form-control">
    </div>
    <div class="col-md-1">
        <label class="form-label">Sex</label>
        <select name="sex" class="form-select">
            <option value=""></option>
            <option value="male"   {{ f('sex',$form)=='male'   ? 'selected':'' }}>M</option>
            <option value="female" {{ f('sex',$form)=='female' ? 'selected':'' }}>F</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Patient’s Maiden Name <span class="text-muted">(for married women)</span></label>
    <input type="text" name="maiden_name" value="{{ f('maiden_name',$form) }}" class="form-control">
</div>

{{-- ② Birth-related fields --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="birth_date" value="{{ f('birth_date',$form) }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Place of Birth</label>
        <input type="text" name="place_of_birth" value="{{ f('place_of_birth',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Civil Status</label>
        <input type="text" name="civil_status" value="{{ f('civil_status',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Occupation</label>
        <input type="text" name="occupation" value="{{ f('occupation',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Religion</label>
        <input type="text" name="religion" value="{{ f('religion',$form) }}" class="form-control">
    </div>
</div>

{{-- ③ Address --}}
<div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="address" value="{{ f('address',$form) }}" class="form-control">
</div>

{{-- ④ Spouse / marriage block --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Name of Husband</label>
        <input type="text" name="husband_name" value="{{ f('husband_name',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Occupation</label>
        <input type="text" name="husband_occupation" value="{{ f('husband_occupation',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Contact No.</label>
        <input type="text" name="husband_contact" value="{{ f('husband_contact',$form) }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Place of Marriage</label>
        <input type="text" name="place_of_marriage" value="{{ f('place_of_marriage',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Date of Marriage</label>
        <input type="date" name="date_of_marriage" value="{{ f('date_of_marriage',$form) }}" class="form-control">
    </div>
</div>

{{-- ⑤ New-born measurements --}}
<div class="row g-3 mb-3">
    <div class="col-md-2">
        <label class="form-label">Blood Type</label>
        <input type="text" name="blood_type" value="{{ f('blood_type',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Delivery Type</label>
        <input type="text" name="delivery_type" value="{{ f('delivery_type',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Birth Weight (kg)</label>
        <input type="number" step="0.01" name="birth_weight" value="{{ f('birth_weight',$form) }}" class="form-control">
    </div>
    <div class="col-md-2">
        <label class="form-label">Birth Length (cm)</label>
        <input type="number" step="0.01" name="birth_length" value="{{ f('birth_length',$form) }}" class="form-control">
    </div>
</div>

{{-- ⑥ Apgar scores --}}
<div class="row g-3 mb-4">
    @foreach(['appearance','pulse','grimace','activity','respiration'] as $field)
        <div class="col-md-2">
            <label class="form-label text-capitalize">{{ $field }}</label>
            <input type="number" min="0" max="2"
                   name="apgar_{{ $field }}"
                   value="{{ f('apgar_'.$field, $form) }}"
                   class="form-control">
        </div>
    @endforeach
</div>

{{-- ⑦ Submit / cancel buttons – shown by the parent view --}}
