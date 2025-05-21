{{-- resources/views/queue/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet"/>

<div class="container col-lg-6">
  <div class="fc-header mb-4">
    <h1>Edit Token ({{ $department->short_name }})</h1>
    <a href="{{ route('queue.show', $department) }}" class="btn btn-secondary">Back to Queue</a>
  </div>

  <div class="card shadow-sm p-3">
    <form action="{{ route('queue.tokens.update', [$department, $token]) }}" method="POST">
      @csrf
      @method('PATCH')

      {{-- Token Code --}}
      <div class="mb-3">
        <label for="code" class="form-label">Token Code</label>
        <input 
          type="text" 
          id="code"
          name="code" 
          value="{{ old('code', $token->code) }}"
          class="form-control @error('code') is-invalid @enderror"
          required>
        @error('code')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Served At --}}
      <div class="mb-3">
        <label for="served_at" class="form-label">Served At (leave blank if pending)</label>
        <input 
          type="datetime-local" 
          id="served_at"
          name="served_at" 
          value="{{ old('served_at', optional($token->served_at)->format('Y-m-d\TH:i')) }}"
          class="form-control @error('served_at') is-invalid @enderror">
        @error('served_at')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-info">Save Changes</button>
      <a href="{{ route('queue.show', $department) }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
  </div>
</div>
@endsection
