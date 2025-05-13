{{-- resources/views/queue/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
    /* ==== Queueing page styles ==== */
    .q-header {
        background:#00b467;
        color:#fff;
        padding:1.25rem 2rem;
        border-radius:.25rem;
        display:flex;justify-content:space-between;align-items:center;
        margin-bottom:1.5rem;
    }
    .q-header h1 {font-size:2rem;font-weight:700;margin:0;}

    /* grid of department cards */
    .dept-grid {display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:1rem;}
    .dept-card {
        background:#0e4749;
        color:#fff;
        padding:1rem;
        border-radius:0.6rem;
        height:150px;
        display:flex;flex-direction:column;justify-content:space-between;
        transition:transform .15s;
    }
    .dept-card:hover{transform:translateY(-4px);}
    .dept-card h3{font-size:1.1rem;font-weight:700;margin:0;}
    .dept-card ul{margin:0;padding-left:1rem;font-size:.85rem;}

    /* plus card */
    .plus-card{display:flex;align-items:center;justify-content:center;font-size:3rem;cursor:pointer;background:#0e4749;color:#fff;border-radius:.6rem;transition:background .15s;}
    .plus-card:hover{background:#00a389;}

    /* right sidebar summary */
    .token-panel{
        position:fixed;right:0;top:60px;width:150px;
        background:#d9f5df; /* light green */
        border-top-left-radius:.5rem;border-bottom-left-radius:.5rem;
    }
    .token-box{padding:1.5rem .5rem;text-align:center;border-bottom:1px solid #c1ecc8;}
    .token-box:last-child{border-bottom:none;}
    .token-box h2{font-size:2rem;font-weight:700;margin:0;color:#00b467;}
    .token-box span{display:block;font-size:.9rem;font-weight:500;color:#0e4749;}

    @media(max-width:991px){
        .token-panel{position:static;width:100%;display:flex;justify-content:space-around;margin-top:1.5rem;border-radius:.5rem;}
        main{margin-right:0;}
    }
</style>

<div class="q-header">
    <h1>Queueing</h1>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella logo">
</div>

<div class="row">
    <div class="col-lg-9">
        <h6 class="bg-dark text-white py-2 px-3 rounded-top">Departments</h6>
        <div class="dept-grid bg-dark bg-opacity-25 p-3 rounded-bottom">
            @php
                $departments = ['Gyne','Internal Medicine','Well’come Teens','OPD Pay','OB','Pedia'];
            @endphp
            @foreach($departments as $dept)
                <div class="dept-card">
                    <h3>{{ $dept }}</h3>
                    <ul class="list-unstyled">
                        <li>• Add Token</li>
                        <li>• Edit Token</li>
                        <li>• Display</li>
                    </ul>
                </div>
            @endforeach
            <div class="plus-card" title="Add department">+</div>
            <a href="{{ route('departments.create') }}">
              <div class="plus-card" title="Add department">+</div>
           </a>
        </div>
    </div>

    <!-- Token summary sidebar -->
    <div class="col-lg-3">
        <div class="token-panel shadow-sm">
            <div class="token-box">
                <h2>302</h2>
                <span>Token</span>
            </div>
            <div class="token-box">
                <h2>57</h2>
                <span>Pending Tokens</span>
            </div>
            <div class="token-box">
                <h2>109</h2>
                <span>Complete Tokens</span>
            </div>
        </div>
    </div>
</div>
@endsection
