<div class="mb-3">
  <label class="form-label">Staff Name</label>
  <input type="text" name="staff_name" value="{{ old('staff_name',$schedule->staff_name??'') }}"
         class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Role</label>
  <input type="text" name="role" value="{{ old('role',$schedule->role??'') }}"
         class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Date</label>
  <input type="date" name="date" value="{{ old('date',$schedule->date??'') }}"
         class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Shift Start</label>
  <input type="time" name="shift_start" value="{{ old('shift_start',$schedule->shift_start??'') }}"
         class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Shift End</label>
  <input type="time" name="shift_end" value="{{ old('shift_end',$schedule->shift_end??'') }}"
         class="form-control" required>
</div>
<div class="mb-3">
  <label class="form-label">Department</label>
  <input type="text" name="department" value="{{ old('department',$schedule->department??'') }}"
         class="form-control" required>
</div>
