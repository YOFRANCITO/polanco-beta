<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use App\Models\Pago;
use Illuminate\Http\Request;

class Analytics extends Controller
{
    public function index()
    {
        $sociosActivos = Socio::where('estado', 'activo')->count();
        $ingresosMes = Pago::where('estado', 'completado')->whereMonth('fecha_pago', now()->month)->sum('monto');
        $pagosPendientes = Pago::where('estado', 'pendiente')->count();
        $nuevosIntegrantes = Socio::whereMonth('fecha_ingreso', now()->month)->count();

        $pagosRecientes = Pago::with('socio')->latest()->limit(5)->get();

        $cumpleaneros = Socio::whereMonth('fecha_nacimiento', now()->month)
            ->orderByRaw('DAY(fecha_nacimiento) ASC')
            ->limit(5)
            ->get();

        // Categorías
        $catVip = Socio::where('categoria', 'vip')->count();
        $catFamiliar = Socio::where('categoria', 'familiar')->count();
        $catIndividual = Socio::where('categoria', 'individual')->count();
        $catJunior = Socio::where('categoria', 'junior')->count();

        return view('content.dashboard.dashboards-analytics', compact(
            'sociosActivos',
            'ingresosMes',
            'pagosPendientes',
            'nuevosIntegrantes',
            'pagosRecientes',
            'cumpleaneros',
            'catVip',
            'catFamiliar',
            'catIndividual',
            'catJunior'
        ));
    }
}
