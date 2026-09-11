<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientesController extends Controller
{
    // Lista de socios con filtros y búsqueda
    public function index(Request $request)
    {
        $query = Socio::query();

        if ($request->filled('buscar')) {
            $q = $request->buscar;
            $query->where(function ($q2) use ($q) {
                $q2->where('nombre', 'like', "%{$q}%")
                   ->orWhere('apellido', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('cedula', 'like', "%{$q}%")
                   ->orWhere('codigo_acceso', 'like', "%{$q}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $socios = $query->orderBy('nombre')->paginate(15)->withQueryString();

        $stats = [
            'total'     => Socio::count(),
            'activos'   => Socio::where('estado', 'activo')->count(),
            'morosos'   => Socio::where('estado', 'moroso')->count(),
            'inactivos' => Socio::where('estado', 'inactivo')->count(),
        ];

        return view('content.clientes.index', compact('socios', 'stats'));
    }

    // Perfil detallado de un socio
    public function show(Socio $socio)
    {
        return view('content.clientes.show', compact('socio'));
    }

    // Formulario crear socio
    public function create()
    {
        return view('content.clientes.form', ['socio' => null]);
    }

    // Guardar nuevo socio
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'email'            => 'nullable|email|max:150',
            'telefono'         => 'nullable|string|max:30',
            'fecha_nacimiento' => 'required|date',
            'cedula'           => 'nullable|string|max:20|unique:socios',
            'categoria'        => 'required|in:familiar,individual,junior,vip',
            'cuota_mensual'    => 'required|numeric|min:0',
            'fecha_ingreso'    => 'required|date',
            'direccion'        => 'nullable|string',
            'notas'            => 'nullable|string',
        ]);

        // Generar código de acceso único
        do {
            $codigo = strtoupper(Str::random(8));
        } while (Socio::where('codigo_acceso', $codigo)->exists());

        $data['codigo_acceso'] = $codigo;
        $data['estado'] = 'activo';

        $socio = Socio::create($data);

        return redirect()->route('clientes.show', $socio)
            ->with('success', "Socio registrado. Código de acceso: {$codigo}");
    }

    // Formulario editar socio
    public function edit(Socio $socio)
    {
        return view('content.clientes.form', compact('socio'));
    }

    // Actualizar socio
    public function update(Request $request, Socio $socio)
    {
        $data = $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'email'            => 'nullable|email|max:150',
            'telefono'         => 'nullable|string|max:30',
            'fecha_nacimiento' => 'required|date',
            'cedula'           => 'nullable|string|max:20|unique:socios,cedula,'.$socio->id,
            'categoria'        => 'required|in:familiar,individual,junior,vip',
            'estado'           => 'required|in:activo,inactivo,moroso',
            'cuota_mensual'    => 'required|numeric|min:0',
            'fecha_ingreso'    => 'required|date',
            'fecha_vencimiento'=> 'nullable|date',
            'direccion'        => 'nullable|string',
            'notas'            => 'nullable|string',
        ]);

        $socio->update($data);

        return redirect()->route('clientes.show', $socio)
            ->with('success', 'Socio actualizado correctamente.');
    }

    // Desactivar socio (soft delete)
    public function destroy(Socio $socio)
    {
        $socio->update(['estado' => 'inactivo']);
        $socio->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Socio desactivado.');
    }
}
