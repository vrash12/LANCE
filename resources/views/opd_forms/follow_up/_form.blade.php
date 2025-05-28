{{-- resources/views/opd_forms/follow_up/_form.blade.php --}}
@php
    $form = $opd_form ?? null;

    // helper to pull old or existing data
    if (! function_exists('fv')) {
        function fv(string $key, $form) {
            return old($key, data_get($form, "data.{$key}", ''));
        }
    }
@endphp

{{-- ─── Include Select2 CSS ─── --}}
@push('styles')
<link
  href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css"
  rel="stylesheet"/>
@endpush

{{-- ─── Form metadata ─── --}}
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <label class="form-label">Form Name</label>
    <input type="text" class="form-control" value="OPD-OB FORM" readonly>
  </div>
  <div class="col-md-4">
    <label class="form-label">Form #</label>
    <input type="text" class="form-control" value="OPD-F-07" readonly>
  </div>
  <div class="col-md-4">
    <label class="form-label">Department</label>
    <input type="text" class="form-control" value="OB" readonly>
  </div>
</div>

{{-- ─── Patient selector + autofill ─── --}}
<div class="row g-3 mb-3">
  <div class="col-md-12">
    <label class="form-label">Select Patient</label>
    <select id="patient_id" name="patient_id" class="form-control"></select>
    @error('patient_id')<div class="text-danger">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-3">
    <label class="form-label">Last Name</label>
    <input name="last_name" type="text" class="form-control" readonly value="{{ fv('last_name',$form) }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">Given Name</label>
    <input name="given_name" type="text" class="form-control" readonly value="{{ fv('given_name',$form) }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">Middle Name</label>
    <input name="middle_name" type="text" class="form-control" readonly value="{{ fv('middle_name',$form) }}">
  </div>
  <div class="col-md-1">
    <label class="form-label">Age</label>
    <input name="age" type="number" min="0" class="form-control" readonly value="{{ fv('age',$form) }}">
  </div>
  <div class="col-md-2">
    <label class="form-label">Sex</label>
    <input name="sex" type="text" class="form-control" readonly value="{{ fv('sex',$form) ? ucfirst(fv('sex',$form)) : '' }}">
  </div>
</div>

{{-- ─── Follow-Up Rows ─── --}}
<h5 class="mt-4">Follow-Up Records</h5>
<div id="followup-table" class="mb-4">
  @php $rows = fv('followups',$form) ?: [[]]; @endphp
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light text-center">
        <tr>
          <th style="width:110px">Date</th>
          <th style="width:110px">Gest. Weeks</th>
          <th style="width:110px">Weight (kg)</th>
          <th style="width:110px">BP</th>
          <th>Remarks</th>
          <th style="width:40px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $i => $row)
          <tr class="fu-row">
            <td>
              <input
                type="date"
                name="followups[{{ $i }}][date]"
                value="{{ $row['date'] ?? '' }}"
                class="form-control">
            </td>
            <td>
              <input
                type="number"
                name="followups[{{ $i }}][gest_weeks]"
                value="{{ $row['gest_weeks'] ?? '' }}"
                class="form-control">
            </td>
            <td>
              <input
                type="number"
                step="0.01"
                name="followups[{{ $i }}][weight]"
                value="{{ $row['weight'] ?? '' }}"
                class="form-control">
            </td>
            <td>
              <input
                type="text"
                name="followups[{{ $i }}][bp]"
                value="{{ $row['bp'] ?? '' }}"
                class="form-control">
            </td>
            <td>
              <input
                type="text"
                name="followups[{{ $i }}][remarks]"
                value="{{ $row['remarks'] ?? '' }}"
                class="form-control">
            </td>
            <td class="text-center">
              <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <button id="add-followup" type="button" class="btn btn-sm btn-outline-primary">
    Add row
  </button>
</div>
@push('scripts')
<script>
// make sure jQuery & select2.js have already been loaded
$(function(){
  $('#patient_id').select2({
    placeholder: 'Type to search patient…',
    ajax: {
      url: '{{ route("patients.search") }}',
      dataType: 'json',
      delay: 250,
      data: params => ({
        q: params.term || ''
      }),
      processResults: data => ({
        results: data.results
      }),
      cache: true
    },
    minimumInputLength: 0,    // allow empty search
    allowClear: true,
    width: '100%'
  })
  // auto-open on focus or click
  .on('focus click', function() {
    $(this).select2('open');
  });

  // when a patient is chosen, fill in the header fields
  $('#patient_id').on('select2:select', e => {
    const p = e.params.data;
    $('input[name=last_name]').val(p.last_name);
    $('input[name=given_name]').val(p.given_name);
    $('input[name=middle_name]').val(p.middle_name);
    $('input[name=age]').val(p.age);
    $('input[name=sex]').val(p.sex);
  });
});
</script>
@endpush
