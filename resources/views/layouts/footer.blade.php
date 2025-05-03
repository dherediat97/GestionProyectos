@section('footer')
    <div class="container text-end">
        <div class="row align-items-end">
            <div class="col">Fin de la sesión: 23:59:59 </div>
            <div class="col">© {{ date('Y') }} <a
                    href="https://solucionesinformaticasmj.com/">{{ env('APP_COMPANY_NAME') }} S.C.A.</a></div>
            <div class="col">Version: <span>{{ env('APP_VERSION') }}-{{ date('ddmmYhh') }}</span></div>
        </div>
    </div>
@stop
