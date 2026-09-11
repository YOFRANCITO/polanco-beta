@php
$width = $width ?? '36';
$height = $height ?? $width;
$class = $class ?? '';
@endphp

<img src="{{ asset('assets/img/branding/logo.png') }}" 
     alt="Club Social Petrolero Polanco" 
     width="{{ $width }}" 
     height="{{ $height }}" 
     class="rounded-circle bg-white p-1 {{ $class }}" 
     style="object-fit: contain; aspect-ratio: 1/1; box-shadow: 0 2px 6px rgba(0,0,0,0.12);" />