@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="text-body small">
                © {{ date('Y') }} <strong>Club Polanco</strong> — Todos los derechos reservados.
            </div>
            <div class="d-none d-lg-inline-block small text-muted">
                <span>Instalaciones, Deporte y Recreación de Primer Nivel</span>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->