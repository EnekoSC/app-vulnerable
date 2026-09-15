<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $facturas = $user->invoices()->orderByDesc('id')->take(5)->get();

        return view('dashboard', compact('user', 'facturas'));
    }
}
