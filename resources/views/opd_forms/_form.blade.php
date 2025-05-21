{{-- resources/views/opd_forms/_form.blade.php --}}
@php
    // If $opd_form exists (in edit), use its values, otherwise default to old() or empty.
    $form = $opd_form ?? null;
@endphp

<div class="mb-3">
  <label for="name" class="form-label">Form Name</label>
  <input
    type="text"
    name="name"
    id="name"
    class="form-control @error('name') is-invalid @enderror"
    value="{{ old('name', $form->name ?? '') }}"
    required
  />
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="form_no" class="form-label">Form No.</label>
  <input
    type="text"
    name="form_no"
    id="form_no"
    class="form-control @error('form_no') is-invalid @enderror"
    value="{{ old('form_no', $form->form_no ?? '') }}"
    required
  />
  @error('form_no')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="department" class="form-label">Department</label>
  <input
    type="text"
    name="department"
    id="department"
    class="form-control @error('department') is-invalid @enderror"
    value="{{ old('department', $form->department ?? '') }}"
    required
  />
  @error('department')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
