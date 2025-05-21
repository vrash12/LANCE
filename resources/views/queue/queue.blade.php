@extends('layouts.patient')

@section('content')
  <div class="container py-4">
    <h2 class="mb-4">Join a Queue</h2>
    @if(session('token'))
      <div class="alert alert-success">
        Your token is <strong>{{ session('token')->code }}</strong>.
      </div>
    @endif

    <div class="row g-3">
      @foreach($departments as $d)
        <div class="col-6 col-md-4 col-lg-3">
          <form action="{{ route('patient.queue.store', $d) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-lg w-100 btn-primary">
              Join {{ $d->name }}
            </button>
          </form>
        </div>
      @endforeach
    </div>
  </div>
@endsection
