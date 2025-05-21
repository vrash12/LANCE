{{-- resources/views/queue/departments.blade.php --}}

@extends('layouts.admin')

@section('content')
<link  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet"/>
<style>
    .dept-card{
        width:155px;min-height:155px;background:#0e4749;border-radius:.75rem;color:#fff;
        display:flex;flex-direction:column;justify-content:center;align-items:center;padding:.75rem;
        margin:.5rem;font-weight:600;text-align:center;transition:.15s;
    }
    .dept-card:hover{transform:translateY(-3px);box-shadow:0 4px 10px rgba(0,0,0,.2);}
    .dept-card ul{list-style:disc;text-align:left;margin-top:.5rem;padding-left:1rem;font-size:.75rem}
    .plus-card{font-size:3rem;line-height:1;color:#00b467}
    /* sidebar */
    .side-stats{background:#d9f5df;border-radius:.75rem}
    .side-stats h2{color:#00b467;font-size:2rem;margin:0}
</style>

<div class="d-flex justify-content-between align-items-center bg-success text-white p-3 rounded mb-3">
    <h1 class="h4 mb-0">Queueing</h1>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60">
</div>

<div class="row">
    {{-- departments grid --}}
    <div class="col-lg-9">
        <h5 class="mb-2">Departments</h5>
        <div class="d-flex flex-wrap">
            @foreach($departments as $dept)
                <div class="dept-card">
                    {{ $dept->short_name }}
                    <ul>
                        <li>
                            <a class="text-white text-decoration-none"
                               href="{{ route('queue.show', $dept) }}">
                                Display
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('queue.store', $dept) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="btn btn-link p-0 text-white-50 text-decoration-none">
                                    Add Token
                                </button>
                            </form>
                        </li>
                        <li>
                            <a class="text-white-50 text-decoration-none" href="#">
                                Edit Token
                            </a>
                        </li>
                    </ul>
                </div>
            @endforeach

            {{-- add-new department tile --}}
            <a href="{{ route('departments.create') }}"
               class="dept-card plus-card d-flex justify-content-center align-items-center">
                +
            </a>
        </div>
    </div>

    {{-- right-hand stats --}}
    <div class="col-lg-3">
        <div class="side-stats p-3 shadow-sm">
            <div class="text-center border-bottom pb-2 mb-2">
                <h2>{{ $summary['total'] }}</h2><span>Token</span>
            </div>
            <div class="text-center border-bottom pb-2 mb-2">
                <h2>{{ $summary['pending'] }}</h2><span>Pending Tokens</span>
            </div>
            <div class="text-center">
                <h2>{{ $summary['complete'] }}</h2><span>Complete Tokens</span>
            </div>
        </div>
    </div>
</div>
@endsection
