{{-- resources/views/encoder/index.blade.php --}}
@extends('layouts.encoder')  <!-- This ensures the encoder layout is used -->

@section('content')
    <div class="container">
        <h1 class="mb-4">Encoder Dashboard</h1>
        <p>Welcome to your dashboard, where you can manage patient records and OPD forms.</p>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Patient Records</h4>
                    </div>
                    <div class="card-body">
                        <p>Manage patient information, create new records, and update existing ones.</p>
                        <a href="{{ route('encoder.patients.index') }}" class="btn btn-primary">Manage Patient Records</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>OPD Forms</h4>
                    </div>
                    <div class="card-body">
                        <p>Manage OPD forms for triage and consultations.</p>
                        <a href="{{ route('encoder.opd.index') }}" class="btn btn-primary">Manage OPD Forms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
