@section('vendor.adminlte.footer')
    <footer class="main-footer">
        <div class="row align-items-end">
            <div class="col"></div>
            <div class="col">© {{ date('Y') }} <a
                    href="https://solucionesinformaticasmj.com/">{{ env('APP_COMPANY_NAME') }} S.C.A.</a></div>
            <div class="col"></div>
        </div>
        <div class="float-right d-none d-sm-block">
            Version: <span>{{ env('APP_VERSION') }}-{{ date('ddmmYhh') }}</span>
        </div>
    </footer>
@endsection
