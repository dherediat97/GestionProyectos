@push('css')
    <style>
        .bg-dark {
            padding: 10px;
            background-color: grey !important;
        }

        .bg-secondary {
            padding: 10px;
            color: white;
            background-color: #041e49 !important;
        }
    </style>
@endpush

@section('footer')
    <div class="d-flex justify-content-between">
        <span><span class="font-italic">Fin de la sesión: {{ env('LAST_SESSION') }}</span></span>

        <strong>
            ©{{ date('Y') }} <a href="https://solucionesinformaticasmj.com/">{{ env('APP_COMPANY_NAME') }}
                S.C.A.</a>
        </strong>

        <div>
            <span class="bg-dark">Versión:</span>
            <span class="bg-secondary">{{ env('APP_VERSION') }}-{{ date('ddmmYhh') }}</span>
        </div>
    </div>
@stop
