<!-- schedules/_form.blade.php -->

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

<!-- New Fields for Weekly Schedule -->
<div class="mb-3">
  <label class="form-label">Weekly Start Day</label>
  <select name="start_day" class="form-select @error('start_day') is-invalid @enderror" required>
    <option value="Monday" {{ old('start_day', $schedule->start_day ?? 'Monday') === 'Monday' ? 'selected' : '' }}>Monday</option>
    <option value="Tuesday" {{ old('start_day', $schedule->start_day ?? '') === 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
    <option value="Wednesday" {{ old('start_day', $schedule->start_day ?? '') === 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
    <option value="Thursday" {{ old('start_day', $schedule->start_day ?? '') === 'Thursday' ? 'selected' : '' }}>Thursday</option>
    <option value="Friday" {{ old('start_day', $schedule->start_day ?? '') === 'Friday' ? 'selected' : '' }}>Friday</option>
    <option value="Saturday" {{ old('start_day', $schedule->start_day ?? '') === 'Saturday' ? 'selected' : '' }}>Saturday</option>
    <option value="Sunday" {{ old('start_day', $schedule->start_day ?? '') === 'Sunday' ? 'selected' : '' }}>Sunday</option>
  </select>
  @error('start_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Default Shift Length (in hours)</label>
  <input type="number" name="shift_length" class="form-control @error('shift_length') is-invalid @enderror" value="{{ old('shift_length', $schedule->shift_length ?? 8.5) }}" required>
  @error('shift_length') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Shift Times for Each Day of the Week -->
<div class="mb-3">
  <label class="form-label">Shift Time for Each Day</label>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Day</th>
        <th>Shift Start</th>
        <th>Shift End</th>
        <th>Include?</th>
      </tr>
    </thead>
    <tbody>
      @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
        @php
          $dayLower = strtolower($day);
          
          // Get the stored values, handling both old() input and existing schedule data
          $startValue = old("shift_start.$day");
          $endValue = old("shift_end.$day");
          $includeValue = old("include.$day");
          
          // If no old data, try to get from schedule using the correct field names
          if (!$startValue && isset($schedule) && $schedule->exists) {
            $startField = "shift_start_$dayLower";
            $startValue = $schedule->$startField ?? '';
            // Remove seconds if present (e.g., "09:00:00" becomes "09:00")
            if ($startValue) {
              $startValue = substr($startValue, 0, 5);
            }
          }
          
          if (!$endValue && isset($schedule) && $schedule->exists) {
            $endField = "shift_end_$dayLower";
            $endValue = $schedule->$endField ?? '';
            // Remove seconds if present (e.g., "17:00:00" becomes "17:00")
            if ($endValue) {
              $endValue = substr($endValue, 0, 5);
            }
          }
          
          if ($includeValue === null && isset($schedule) && $schedule->exists) {
            $includeField = "include_$dayLower";
            $includeValue = $schedule->$includeField ?? 0;
            $includeValue = (bool)$includeValue;
          }
          
          // Default include to true if we have time values, false otherwise
          if ($includeValue === null) {
            $includeValue = ($startValue || $endValue) ? true : false;
          }
        @endphp
        
        <tr data-day="{{ $day }}">
          <td><strong>{{ $day }}</strong></td>
          <td>
            <input 
              type="time"
              name="shift_start[{{ $day }}]"
              class="form-control shift-time @error('shift_start.'.$day) is-invalid @enderror"
              value="{{ $startValue }}"
              data-day="{{ $day }}"
            >
            @error('shift_start.'.$day)
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </td>
          <td>
            <input 
              type="time"
              name="shift_end[{{ $day }}]"
              class="form-control shift-time @error('shift_end.'.$day) is-invalid @enderror"
              value="{{ $endValue }}"
              data-day="{{ $day }}"
            >
            @error('shift_end.'.$day)
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </td>
          <td class="text-center">
            <div class="form-check">
              <input 
                type="checkbox"
                name="include[{{ $day }}]"
                class="form-check-input include-checkbox"
                value="1"
                data-day="{{ $day }}"
                {{ $includeValue ? 'checked' : '' }}
              >
              <label class="form-check-label">Include</label>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize all rows on page load
  initializeAllRows();
  
  // Add event listeners to checkboxes
  document.querySelectorAll('.include-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
      toggleRowInputs(this);
    });
  });
  
  function initializeAllRows() {
    document.querySelectorAll('.include-checkbox').forEach(function(checkbox) {
      toggleRowInputs(checkbox);
    });
  }
  
  function toggleRowInputs(checkbox) {
    const day = checkbox.getAttribute('data-day');
    const row = checkbox.closest('tr');
    const timeInputs = row.querySelectorAll('.shift-time');
    
    timeInputs.forEach(function(input) {
      if (checkbox.checked) {
        input.disabled = false;
        input.style.backgroundColor = '';
        input.style.color = '';
      } else {
        input.disabled = true;
        input.value = ''; // Clear the value when disabled
        input.style.backgroundColor = '#f8f9fa';
        input.style.color = '#6c757d';
      }
    });
  }
  
  // Optional: Auto-check include checkbox when time is entered
  document.querySelectorAll('.shift-time').forEach(function(input) {
    input.addEventListener('change', function() {
      const day = this.getAttribute('data-day');
      const checkbox = document.querySelector(`.include-checkbox[data-day="${day}"]`);
      const row = this.closest('tr');
      const timeInputs = row.querySelectorAll('.shift-time');
      
      // Check if any time input in this row has a value
      const hasValue = Array.from(timeInputs).some(input => input.value.trim() !== '');
      
      if (hasValue && !checkbox.checked) {
        checkbox.checked = true;
        toggleRowInputs(checkbox);
      }
    });
  });
});
</script>
@endpush

<style>
.table th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.include-checkbox {
  transform: scale(1.2);
}

.shift-time:disabled {
  background-color: #f8f9fa !important;
  color: #6c757d !important;
}

tr[data-day] td {
  vertical-align: middle;
}
</style>