<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Socio;

class LandingController extends Controller
{
    public function index()
    {
        try {
            $socios = Socio::all();
        } catch (\Throwable $e) {
            $socios = collect();
        }

        return view('landing', compact('socios'));
    }
}
