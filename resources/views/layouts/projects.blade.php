@extends('adminlte::page')

@section('title', 'Control de proyectos')

@section('content')
    @yield('content_body')
    <div class="mx-auto p-2 text-start">
        <div class="row align-items-start">
            <div class="col">
                <x-adminlte-card title="Control de proyectos">
                    <x-slot name="toolsSlot">
                        {{-- @if (auth()->user()->hasRole('admin'))
                            <x-adminlte-button theme="primary" icon="fas fa-lg fa-plus"
                                onclick="newProject()"></x-adminlte-button>
                        @endif --}}
                        <x-adminlte-button theme="primary" icon="fas fa-lg fa-file-pdf"
                            onclick="exportPdf()"></x-adminlte-button>
                    </x-slot>
                    <x-slot name="footerSlot">
                        <x-adminlte-card theme="warning" title="Proyecto 1" body-class="bg-warning"
                            header-class="bg-warning">Creado
                            por usuario 1</x-adminlte-card>
                        <x-adminlte-card theme="warning" title="Proyecto 2" body-class="bg-warning"
                            header-class="bg-warning">Creado
                            por usuario 2</x-adminlte-card>
                        <x-adminlte-card theme="warning" title="Proyecto 3" body-class="bg-warning"
                            header-class="bg-warning">Creado
                            por usuario 3</x-adminlte-card>
                    </x-slot>
                </x-adminlte-card>
            </div>
            <div class="col">
                <x-adminlte-select name="selUser" label-class="text-navy" igroup-size="lg">
                    <option>Mi calendario(David)</option>
                    <option>Calendario de Juan</option>
                </x-adminlte-select>
                @include('layouts.working-task')
            </div>
        </div>
    </div>
    @include('layouts.footer')
@stop



<script>
    function newProject() {
        console.log('New project button clicked!');
    }

    function exportPdf() {
        console.log('Export PDF button clicked!');
    }
</script>
