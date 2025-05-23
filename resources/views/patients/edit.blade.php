{{-- resources/views/patients/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container col-lg-8">
  <h2 class="mb-4">Edit Patient</h2>

  <form action="{{ route('patients.update', $patient) }}" method="POST">
    @csrf @method('PUT')

    {{-- === User Account === --}}
    <h5>User Account</h5>
    <div class="mb-3">
      <label class="form-label">Email (username)</label>
      <input type="email"
             name="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email', $patient->user->email) }}"
             required>
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3 row">
      <div class="col">
        <label class="form-label">Password <small class="text-muted">(leave blank to keep)</small></label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col">
        <label class="form-label">Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-control">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text"
             name="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $patient->name) }}"
             required>
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- === Basic Patient Info === --}}
    <h5 class="mt-4">Basic Patient Info</h5>
    <div class="mb-3">
      <label class="form-label">Birth Date</label>
     <input type="date"
       name="birth_date"
       class="form-control @error('birth_date') is-invalid @enderror"
       value="{{ old('birth_date', $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->toDateString() : '') }}">
@error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror

      @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Contact No.</label>
      <input type="text"
             name="contact_no"
             class="form-control @error('contact_no') is-invalid @enderror"
             value="{{ old('contact_no', $patient->contact_no) }}">
      @error('contact_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address"
                rows="2"
                class="form-control @error('address') is-invalid @enderror">{{ old('address', $patient->address) }}</textarea>
      @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- === Extended Profile === --}}
    @php $pf = optional($patient->profile); @endphp

    <h5 class="mt-4">Extended Profile</h5>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Sex</label>
        <select name="sex" class="form-control @error('sex') is-invalid @enderror">
          <option value="">— Select —</option>
          <option value="male"   {{ old('sex', $pf->sex) == 'male'   ? 'selected':'' }}>Male</option>
          <option value="female" {{ old('sex', $pf->sex) == 'female' ? 'selected':'' }}>Female</option>
        </select>
        @error('sex') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4 mb-3">
        <label class="form-label">Religion</label>
        <input type="text"
               name="religion"
               class="form-control @error('religion') is-invalid @enderror"
               value="{{ old('religion', $pf->religion) }}">
        @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4 mb-3">
        <label class="form-label">Date Recorded</label>
        <input type="date"
               name="date_recorded"
               class="form-control @error('date_recorded') is-invalid @enderror"
              value="{{ old('date_recorded', $pf->date_recorded ? \Carbon\Carbon::parse($pf->date_recorded)->toDateString() : '') }}">
        @error('date_recorded') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <h6 class="mt-3">Parental Information</h6>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Father’s Name</label>
        <input type="text"
               name="father_name"
               class="form-control @error('father_name') is-invalid @enderror"
               value="{{ old('father_name', $pf->father_name) }}">
        @error('father_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Father’s Occupation</label>
        <input type="text"
               name="father_occupation"
               class="form-control @error('father_occupation') is-invalid @enderror"
               value="{{ old('father_occupation', $pf->father_occupation) }}">
        @error('father_occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Mother’s Name</label>
        <input type="text"
               name="mother_name"
               class="form-control @error('mother_name') is-invalid @enderror"
               value="{{ old('mother_name', $pf->mother_name) }}">
        @error('mother_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Mother’s Occupation</label>
        <input type="text"
               name="mother_occupation"
               class="form-control @error('mother_occupation') is-invalid @enderror"
               value="{{ old('mother_occupation', $pf->mother_occupation) }}">
        @error('mother_occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <h6 class="mt-3">Marital Information</h6>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Place of Marriage</label>
        <input type="text"
               name="place_of_marriage"
               class="form-control @error('place_of_marriage') is-invalid @enderror"
               value="{{ old('place_of_marriage', $pf->place_of_marriage) }}">
        @error('place_of_marriage') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Date of Marriage</label>
        <input type="date"
               name="date_of_marriage"
               class="form-control @error('date_of_marriage') is-invalid @enderror"
               value="{{ old('date_of_marriage', optional($pf->date_of_marriage)->toDateString()) }}">
        @error('date_of_marriage') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <h6 class="mt-3">Birth Statistics</h6>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Blood Type</label>
        <input type="text"
               name="blood_type"
               class="form-control @error('blood_type') is-invalid @enderror"
               value="{{ old('blood_type', $pf->blood_type) }}">
        @error('blood_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Delivery Type</label>
        <input type="text"
               name="delivery_type"
               class="form-control @error('delivery_type') is-invalid @enderror"
               value="{{ old('delivery_type', $pf->delivery_type) }}">
        @error('delivery_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-2 mb-3">
        <label class="form-label">Weight (kg)</label>
        <input type="number" step="0.01"
               name="birth_weight"
               class="form-control @error('birth_weight') is-invalid @enderror"
               value="{{ old('birth_weight', $pf->birth_weight) }}">
        @error('birth_weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-2 mb-3">
        <label class="form-label">Length (cm)</label>
        <input type="number" step="0.01"
               name="birth_length"
               class="form-control @error('birth_length') is-invalid @enderror"
               value="{{ old('birth_length', $pf->birth_length) }}">
        @error('birth_length') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <h6 class="mt-3">APGAR Score</h6>
    <div class="row">
      @foreach(['appearance','pulse','grimace','activity','respiration'] as $metric)
        <div class="col-md-2 mb-3">
          <label class="form-label">{{ ucfirst($metric) }}</label>
          <input type="number" name="apgar_{{ $metric }}"
                 class="form-control @error('apgar_'.$metric) is-invalid @enderror"
                 min="0" max="2"
                 value="{{ old('apgar_'.$metric, $pf->{'apgar_'.$metric}) }}">
          @error('apgar_'.$metric) <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      @endforeach
    </div>

    <button class="btn btn-info mt-4">Update</button>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-4">Cancel</a>
  </form>
</div>
@endsection
