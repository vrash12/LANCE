<?php

namespace App\Http\Controllers;

class QueueController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        // For now, just return the view
        return view('queue.index');
    }
}
