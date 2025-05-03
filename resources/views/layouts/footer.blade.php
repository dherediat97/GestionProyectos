@section('footer')
    <div class="container text-start">
        <div class="row align-items-start">
            <div class="col">
                Fin de la sesión: 23:59:59
            </div>
            <div class="col">
                Version: <span>{{ config('app.version', '1.0.0') }}</span>
            </div>
            <div class="col">
                {{ config('app.company_name', '© 2023 Soluciones Informáticas MJ SCA') }}
            </div>
        </div>
    </div>
@stop
