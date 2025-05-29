{{-- resources/views/queue/select.blade.php --}}
@extends('layouts.admin')
@section('content')
  <h1>Queue for {{ $patientName }}</h1>
  <form action="{{ route('queue.encoder.store', $departments->first()) }}" method="POST">
    @csrf
    <label>Department</label>
    <select name="department_id" onchange="this.form.action = 
      '{{ url('queue') }}/'+this.value+'/add';">
      @foreach($departments as $d)
        <option value="{{ $d->id }}">{{ $d->name }}</option>
      @endforeach
    </select>
    <button class="btn btn-primary mt-2">Add Token</button>
  </form>
@endsection
