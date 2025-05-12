<div class="mb-3">
  <label class="form-label">Form Name</label>
  <input type="text" name="name" value="{{ old('name',$opd_form->name??'') }}" class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Form No.</label>
  <input type="text" name="form_no" value="{{ old('form_no',$opd_form->form_no??'') }}" class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Department</label>
  <input type="text" name="department" value="{{ old('department',$opd_form->department??'') }}" class="form-control" required>
</div>