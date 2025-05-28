{{-- resources/views/schedules/modal_content.blade.php --}}
<div class="row">
  <div class="col-md-6">
    <h6 class="text-muted mb-3">Basic Information</h6>
    <table class="table table-borderless table-sm">
      <tr>
        <td><strong>Staff Name:</strong></td>
        <td>{{ $schedule->staff_name }}</td>
      </tr>
      <tr>
        <td><strong>Role:</strong></td>
        <td>{{ $schedule->role }}</td>
      </tr>
      <tr>
        <td><strong>Department:</strong></td>
        <td>{{ $schedule->department }}</td>
      </tr>
      <tr>
        <td><strong>Date:</strong></td>
        <td>{{ $schedule->date->format('F j, Y') }}</td>
      </tr>
      <tr>
        <td><strong>Week Start Day:</strong></td>
        <td>{{ $schedule->start_day }}</td>
      </tr>
      <tr>
        <td><strong>Default Shift Length:</strong></td>
        <td>{{ $schedule->shift_length }} hours</td>
      </tr>
    </table>
  </div>
  
  <div class="col-md-6">
    <h6 class="text-muted mb-3">Weekly Schedule</h6>
    <div class="table-responsive">
      <table class="table table-sm table-bordered">
        <thead class="table-light">
          <tr>
            <th>Day</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
            @php
              $dayLower = strtolower($day);
              $startField = "shift_start_$dayLower";
              $endField = "shift_end_$dayLower";
              $includeField = "include_$dayLower";
              
              $startTime = $schedule->$startField;
              $endTime = $schedule->$endField;
              $isIncluded = $schedule->$includeField;
            @endphp
            <tr class="{{ $isIncluded ? '' : 'text-muted' }}">
              <td><strong>{{ $day }}</strong></td>
              <td>
                @if($startTime)
                  {{ \Carbon\Carbon::parse($startTime)->format('h:i A') }}
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td>
                @if($endTime)
                  {{ \Carbon\Carbon::parse($endTime)->format('h:i A') }}
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td>
                @if($isIncluded)
                  <span class="badge bg-success">Included</span>
                @else
                  <span class="badge bg-secondary">Off</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@if($schedule->created_at)
<div class="row mt-3">
  <div class="col-12">
    <hr>
    <small class="text-muted">
      <strong>Created:</strong> {{ $schedule->created_at->format('M j, Y \a\t h:i A') }}
      @if($schedule->updated_at && $schedule->updated_at != $schedule->created_at)
        | <strong>Last Updated:</strong> {{ $schedule->updated_at->format('M j, Y \a\t h:i A') }}
      @endif
    </small>
  </div>
</div>
@endif