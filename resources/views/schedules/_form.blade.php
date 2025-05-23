{{-- resources/views/schedules/_form.blade.php --}}

<div class="mb-3">
  <label class="form-label">Staff Name</label>
  <input
    type="text"
    name="staff_name"
    value="{{ old('staff_name', $schedule->staff_name ?? '') }}"
    class="form-control @error('staff_name') is-invalid @enderror"
    required
  >
  @error('staff_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Role</label>
  <input
    type="text"
    name="role"
    value="{{ old('role', $schedule->role ?? '') }}"
    class="form-control @error('role') is-invalid @enderror"
    required
  >
  @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Date</label>
  <input
    type="date"
    name="date"
    value="{{ old('date', optional($schedule->date)->toDateString() ?? '') }}"
    class="form-control @error('date') is-invalid @enderror"
    required
  >
  @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Shift Start</label>
  <input
    type="time"
    name="shift_start"
    value="{{ old('shift_start', optional($schedule->shift_start)->format('H:i') ?? '') }}"
    class="form-control @error('shift_start') is-invalid @enderror"
    required
  >
  @error('shift_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Shift End</label>
  <input
    type="time"
    name="shift_end"
    value="{{ old('shift_end', optional($schedule->shift_end)->format('H:i') ?? '') }}"
    class="form-control @error('shift_end') is-invalid @enderror"
    required
  >
  @error('shift_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Department</label>
  <select
    name="department"
    class="form-select @error('department') is-invalid @enderror"
    required
  >
    <option value="">— choose department —</option>
    @foreach($departments as $dept)
      <option
        value="{{ $dept->name }}"
        {{ old('department', $schedule->department ?? '') === $dept->name ? 'selected' : '' }}
      >
        {{ $dept->short_name ? $dept->short_name.' – ' : '' }}{{ $dept->name }}
      </option>
    @endforeach
  </select>
  @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
