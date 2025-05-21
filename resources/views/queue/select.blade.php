{{-- resources/views/queue/select.blade.php --}}
@extends('layouts.patient')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">Choose Department to Display</h2>
  <div class="row g-3">
    @foreach($departments as $d)
      <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('queue.display', $d) }}"
           class="btn btn-lg w-100 btn-outline-success">
          {{ $d->name }}
        </a>
      </div>
    @endforeach
  </div>
</div>
@endsection
