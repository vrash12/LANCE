{{-- resources/views/patient/queue.blade.php --}}
@extends('layouts.patient')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">Join the Queue</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-warning">{{ session('error') }}</div>
  @endif

  <div class="row gy-3">
    @foreach($departments as $dept)
      @php
        // do they already have a token for this dept?
        $token = $existing->get($dept->id)?->code;
      @endphp

      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm text-center">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">{{ $dept->name }}</h5>

            @if($token)
              {{-- show existing token & disable --}}
              <p class="mt-3"><strong>Your Token:</strong> {{ $token }}</p>
              <button class="btn btn-secondary mt-2" disabled>
                <i class="bi bi-ticket-fill"></i>
                Already Taken
              </button>
            @else
              {{-- fresh “Get Token” --}}
              <form action="{{ route('patient.queue.store', $dept) }}" method="POST">
                @csrf
                <button class="btn btn-primary mt-3" type="submit">
                  <i class="bi bi-ticket-fill"></i> Get Token
                </button>
              </form>
            @endif

          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
