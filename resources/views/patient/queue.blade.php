@extends('layouts.patient')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">Join the Queue</h2>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
      @if(session('current_token'))
        <br>
        <small>Your token: <strong>{{ session('current_token') }}</strong></small>
      @endif
    </div>
  @endif

  <div class="row gy-3">
    @foreach($departments as $dept)
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm text-center">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">{{ $dept->name }}</h5>
            <form action="{{ route('patient.queue.store', $dept) }}" method="POST">
              @csrf
              <button class="btn btn-primary mt-3" type="submit">
                <i class="bi bi-ticket-fill"></i> Get Token
              </button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
