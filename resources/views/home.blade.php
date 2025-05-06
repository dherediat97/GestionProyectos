@extends('adminlte::page')

@section('title', 'Gestión de Proyectos')

@section('content_header')
@stop

@section('content')
    @yield('content_body')
    @include('layouts.footer')
@stop

@section('footer')
    <div class="d-flex justify-content-between">
        <span>Fin de la sesión: {{ env('LAST_SESSION') }} </span>

        <strong>
            ©{{ date('Y') }} <a href="https://solucionesinformaticasmj.com/">{{ env('APP_COMPANY_NAME') }} S.C.A.</a>
        </strong>

        <div>
            <span class="bg-dark">Version:</span><span class="bg-navy">{{ env('APP_VERSION') }}-{{ date('ddmmYhh') }}</span>
        </div>
    </div>
@stop
