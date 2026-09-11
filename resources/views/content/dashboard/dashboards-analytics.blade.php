@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard — Club Polanco')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

{{-- Bienvenida --}}
<div class="row mb-6">
  <div class="col-12">
    <div class="card" style="background: linear-gradient(135deg, #1a7a3c 0%, #145e2e 60%, #0e4520 100%); border:none; overflow:hidden; position:relative;">
      <div class="card-body py-5 px-6" style="position:relative; z-index:1;">
        <div class="row align-items-center">
          <div class="col-md-8">
            <p class="text-white mb-1 fw-semibold" style="opacity:.8; font-size:.85rem; letter-spacing:.05em; text-transform:uppercase;">Bienvenido al panel administrativo</p>
            <h3 class="text-white fw-bold mb-2" style="font-size:1.8rem;">Club Polanco 🏆</h3>
            <p class="mb-4" style="color:rgba(255,255,255,.75); max-width:460px; line-height:1.6;">Gestiona socios, pagos y finanzas desde un solo lugar. Aquí tienes el resumen del día.</p>
            <div class="d-flex gap-3 flex-wrap">
              <a href="/clientes" class="btn btn-sm px-4 fw-semibold" style="background:#c9a84c; color:#fff; border:none; border-radius:8px;">Ver Socios</a>
              <a href="/pagos/qr" class="btn btn-sm px-4 fw-semibold" style="background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3); border-radius:8px;">Cobrar Ahora</a>
            </div>
          </div>
          <div class="col-md-4 text-end d-none d-md-block">
            <div style="font-size:5rem; opacity:.2; position:absolute; right:2rem; top:50%; transform:translateY(-50%);">🏛️</div>
          </div>
        </div>
      </div>
      {{-- Círculos decorativos --}}
      <div style="position:absolute; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,.05); top:-60px; right:80px;"></div>
      <div style="position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(255,255,255,.05); bottom:-40px; right:200px;"></div>
    </div>
  </div>
</div>

{{-- KPIs principales --}}
<div class="row mb-6 g-4">

  {{-- Socios Activos --}}
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="avatar avatar-sm rounded" style="background:rgba(26,122,60,.12);">
            <i class="bx bx-group fs-4" style="color:#1a7a3c;"></i>
          </div>
          <span class="badge rounded-pill" style="background:rgba(26,122,60,.1); color:#1a7a3c; font-size:.72rem;">Activos</span>
        </div>
        <h4 class="fw-bold mb-1">{{ $sociosActivos }}</h4>
        <p class="text-muted mb-0 small">Socios Activos</p>
        <div class="progress mt-3" style="height:4px; border-radius:4px;">
          <div class="progress-bar" style="width:{{ min(100, $sociosActivos * 10) }}%; background:#1a7a3c;"></div>
        </div>
        <p class="text-muted mt-1 mb-0" style="font-size:.72rem;">Registrados al corriente</p>
      </div>
    </div>
  </div>

  {{-- Ingresos del Mes --}}
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="avatar avatar-sm rounded" style="background:rgba(201,168,76,.12);">
            <i class="bx bx-dollar-circle fs-4" style="color:#c9a84c;"></i>
          </div>
          <span class="badge rounded-pill" style="background:rgba(201,168,76,.1); color:#c9a84c; font-size:.72rem;">Cobrado</span>
        </div>
        <h4 class="fw-bold mb-1">${{ number_format($ingresosMes, 2) }}</h4>
        <p class="text-muted mb-0 small">Ingresos del Mes</p>
        <div class="progress mt-3" style="height:4px; border-radius:4px;">
          <div class="progress-bar" style="width:85%; background:#c9a84c;"></div>
        </div>
        <p class="text-muted mt-1 mb-0" style="font-size:.72rem;">Total liquidado en caja y portal</p>
      </div>
    </div>
  </div>

  {{-- Pagos Pendientes --}}
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="avatar avatar-sm rounded" style="background:rgba(255,171,0,.12);">
            <i class="bx bx-time fs-4" style="color:#ffab00;"></i>
          </div>
          <span class="badge rounded-pill" style="background:rgba(255,171,0,.1); color:#ffab00; font-size:.72rem;">Por verificar</span>
        </div>
        <h4 class="fw-bold mb-1">{{ $pagosPendientes }}</h4>
        <p class="text-muted mb-0 small">Pagos Pendientes</p>
        <div class="progress mt-3" style="height:4px; border-radius:4px;">
          <div class="progress-bar" style="width:{{ min(100, $pagosPendientes * 25) }}%; background:#ffab00;"></div>
        </div>
        <p class="text-muted mt-1 mb-0" style="font-size:.72rem;"><a href="{{ route('pagos.verificacion') }}" class="text-warning">Revisar bandeja</a></p>
      </div>
    </div>
  </div>

  {{-- Nuevos Socios --}}
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="avatar avatar-sm rounded" style="background:rgba(3,195,236,.12);">
            <i class="bx bx-user-plus fs-4" style="color:#03c3ec;"></i>
          </div>
          <span class="badge rounded-pill" style="background:rgba(3,195,236,.1); color:#03c3ec; font-size:.72rem;">Este mes</span>
        </div>
        <h4 class="fw-bold mb-1">{{ $nuevosIntegrantes }}</h4>
        <p class="text-muted mb-0 small">Nuevos Integrantes</p>
        <div class="progress mt-3" style="height:4px; border-radius:4px;">
          <div class="progress-bar" style="width:{{ min(100, $nuevosIntegrantes * 20) }}%; background:#03c3ec;"></div>
        </div>
        <p class="text-muted mt-1 mb-0" style="font-size:.72rem;">Altas en el club</p>
      </div>
    </div>
  </div>

</div>

{{-- Gráfico de Ingresos + Pagos Recientes --}}
<div class="row mb-6 g-4">

  {{-- Gráfico ingresos mensuales --}}
  <div class="col-xl-8">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div>
          <h5 class="card-title mb-0">Ingresos Mensuales</h5>
          <p class="text-muted small mb-0">Cuotas cobradas vs pendientes</p>
        </div>
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">2025</button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">2025</a></li>
            <li><a class="dropdown-item" href="#">2024</a></li>
          </ul>
        </div>
      </div>
      <div class="card-body pt-4">
        <div id="incomeChart"></div>
      </div>
    </div>
  </div>

  {{-- Resumen de categorías --}}
  <div class="col-xl-4">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h5 class="card-title mb-0">Socios por Categoría</h5>
        <p class="text-muted small mb-0">Distribución de membresías</p>
      </div>
      <div class="card-body">
        <div id="categoryChart"></div>
        <ul class="list-unstyled mt-3 mb-0">
          <li class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
              <span class="badge rounded-circle p-1" style="background:#1a7a3c; width:10px; height:10px; display:inline-block;"></span>
              <span class="small">Familiar</span>
            </div>
            <span class="fw-semibold small">{{ $catFamiliar }}</span>
          </li>
          <li class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
              <span class="badge rounded-circle p-1" style="background:#c9a84c; width:10px; height:10px; display:inline-block;"></span>
              <span class="small">Individual</span>
            </div>
            <span class="fw-semibold small">{{ $catIndividual }}</span>
          </li>
          <li class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
              <span class="badge rounded-circle p-1" style="background:#03c3ec; width:10px; height:10px; display:inline-block;"></span>
              <span class="small">Junior</span>
            </div>
            <span class="fw-semibold small">{{ $catJunior }}</span>
          </li>
          <li class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <span class="badge rounded-circle p-1" style="background:#ffab00; width:10px; height:10px; display:inline-block;"></span>
              <span class="small">VIP</span>
            </div>
            <span class="fw-semibold small">{{ $catVip }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

</div>

{{-- Actividad reciente + Próximos cumpleaños --}}
<div class="row g-4">

  {{-- Pagos recientes --}}
  <div class="col-xl-7">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Pagos Recientes</h5>
        <a href="{{ route('pagos.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead style="background:rgba(26,122,60,.04);">
            <tr>
              <th class="ps-4 small text-muted fw-semibold">Socio</th>
              <th class="small text-muted fw-semibold">Concepto</th>
              <th class="small text-muted fw-semibold">Monto</th>
              <th class="small text-muted fw-semibold">Método</th>
              <th class="pe-4 small text-muted fw-semibold">Estado</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pagosRecientes as $pago)
            <tr>
              <td class="ps-4">
                <div class="d-flex align-items-center gap-2">
                  <span class="avatar avatar-xs rounded-circle d-flex align-items-center justify-content-center fw-bold text-white small" style="background:#1a7a3c; width:32px; height:32px; min-width:32px; font-size:.72rem;">
                    {{ $pago->socio ? $pago->socio->iniciales : 'CP' }}
                  </span>
                  <div>
                    <span class="fw-semibold small d-block">{{ $pago->socio ? $pago->socio->nombre_completo : 'Socio' }}</span>
                    <small class="text-muted font-monospace" style="font-size:0.7rem;">{{ $pago->referencia }}</small>
                  </div>
                </div>
              </td>
              <td class="small text-muted">{{ $pago->concepto }}</td>
              <td class="fw-semibold small text-success">${{ number_format($pago->monto, 2) }}</td>
              <td>
                <span class="badge {{ $pago->metodo_badge }} small">{{ $pago->metodo_label }}</span>
              </td>
              <td class="pe-4">
                <span class="badge {{ $pago->estado_badge }} small">
                  {{ $pago->estado_label }}
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-muted small">No hay pagos registrados recientemente.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Próximos cumpleaños --}}
  <div class="col-xl-5">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">🎂 Cumpleaños del Mes</h5>
        <span class="badge rounded-pill" style="background:rgba(26,122,60,.1); color:#1a7a3c;">{{ now()->translatedFormat('F') }}</span>
      </div>
      <div class="card-body pt-2">
        @forelse($cumpleaneros as $c)
        @php
            $esHoy = \Carbon\Carbon::parse($c->fecha_nacimiento)->day === now()->day;
            $dia = \Carbon\Carbon::parse($c->fecha_nacimiento)->format('d');
        @endphp
        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
          <div class="d-flex align-items-center gap-3">
            <div class="avatar avatar-xs rounded-circle d-flex align-items-center justify-content-center {{ $esHoy ? 'bg-success text-white' : 'bg-label-info' }}" style="width:36px; height:36px; min-width:36px;">
              <span class="fw-bold fs-6">{{ $dia }}</span>
            </div>
            <div>
              <p class="mb-0 fw-semibold small">
                {{ $c->nombre_completo }}
                @if($esHoy)
                <span class="badge bg-danger ms-1" style="font-size:0.65rem;">¡HOY!</span>
                @endif
              </p>
              <span class="text-muted" style="font-size:.72rem;">{{ ucfirst($c->categoria) }} • +{{ $c->telefono }}</span>
            </div>
          </div>
          @if($c->telefono)
          <a href="https://wa.me/{{ preg_replace('/\D/', '', $c->telefono) }}?text={{ urlencode('¡Feliz Cumpleaños ' . $c->nombre . '! Todo el equipo de Club Polanco le desea un excelente día.') }}" 
             target="_blank" 
             class="btn btn-xs btn-outline-success" 
             title="Felicitar WhatsApp">
            <i class="bx bxl-whatsapp"></i>
          </a>
          @endif
        </div>
        @empty
        <div class="text-center py-4 text-muted small">No hay socios cumpliendo años este mes.</div>
        @endforelse
        <div class="text-center mt-4">
          <a href="{{ route('crm.recordatorios') }}" class="btn btn-sm btn-outline-primary w-100">Ver todos los recordatorios</a>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection

@push('page-script-inline')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // Gráfico de ingresos mensuales
  const incomeOptions = {
    chart: { type: 'bar', height: 280, toolbar: { show: false }, sparkline: { enabled: false } },
    series: [
      { name: 'Cobrado', data: [4200, 3800, 5100, 4900, 6200, 5800, 7100, 6500, {{ $ingresosMes }}, 0, 0, 0] },
      { name: 'Pendiente', data: [420, 380, 510, 490, 620, 580, 710, 650, {{ $pagosPendientes * 100 }}, 0, 0, 0] }
    ],
    colors: ['#1a7a3c', '#c9a84c'],
    plotOptions: { bar: { borderRadius: 6, columnWidth: '55%', grouped: true } },
    dataLabels: { enabled: false },
    legend: { show: true, position: 'top', horizontalAlign: 'right', markers: { radius: 6 } },
    xaxis: {
      categories: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
      axisBorder: { show: false }, axisTicks: { show: false },
      labels: { style: { fontSize: '12px', colors: '#8592a3' } }
    },
    yaxis: { labels: { formatter: v => '$ ' + v.toLocaleString(), style: { colors: '#8592a3' } } },
    grid: { borderColor: '#f1f1f2', strokeDashArray: 4 },
    tooltip: { y: { formatter: v => '$ ' + v.toLocaleString() + ' MXN' } }
  };
  new ApexCharts(document.querySelector('#incomeChart'), incomeOptions).render();

  // Gráfico de categorías dinámico
  const catOptions = {
    chart: { type: 'donut', height: 200, sparkline: { enabled: false } },
    series: [{{ $catFamiliar }}, {{ $catIndividual }}, {{ $catJunior }}, {{ $catVip }}],
    labels: ['Familiar', 'Individual', 'Junior', 'VIP'],
    colors: ['#1a7a3c', '#c9a84c', '#03c3ec', '#ffab00'],
    legend: { show: false },
    dataLabels: { enabled: false },
    plotOptions: { pie: { donut: { size: '70%', labels: {
      show: true,
      total: { show: true, label: 'Socios', formatter: () => '{{ $sociosActivos }}', style: { fontSize: '16px', fontWeight: 700 } }
    }}}},
    stroke: { width: 0 },
    tooltip: { y: { formatter: v => v + ' socios' } }
  };
  new ApexCharts(document.querySelector('#categoryChart'), catOptions).render();

});
</script>
@endpush
