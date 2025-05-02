@extends('adminlte::page')

@section('title', 'Control de proyectos')

@section('content')
    @yield('content_body')
    <div class="mx-auto p-2 text-start">
        <div class="row align-items-start">
            <div class="col">
                <x-adminlte-card title="Control de proyectos">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button theme="primary" icon="fas fa-lg fa-plus" onclick="newProject()"></x-adminlte-button>
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
                <x-adminlte-select name="selVehicle" label-class="text-lightblue" igroup-size="lg">
                    <option>Mi calendario(David)</option>
                    <option>Calendario de Juan</option>
                </x-adminlte-select>
                <div class="text-start">
                    <div class="row p-2 align-items-start">
                        <div class="col">
                            <div class="col">
                                <x-adminlte-button theme="primary" icon="fas fa-chevron-left" />
                                <x-adminlte-button theme="primary" icon="fas fa-calendar" />
                                <x-adminlte-button theme="primary" icon="fas fa-chevron-right" />
                            </div>
                        </div>
                        <div class="col">
                            viernes, 02 de marzo de 2025
                        </div>
                        <div class="col">
                            <x-adminlte-button theme="primary" label="Semana" />
                            <x-adminlte-button theme="primary" label="Dia" />
                            <x-adminlte-button theme="primary" label="Año" />
                        </div>
                    </div>
                </div>
                {{-- @php
                    $heads = [
                        'ID',
                        'Name',
                        ['label' => 'Phone', 'width' => 40],
                        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                    ];

                    $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
                    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
                    $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

                    $config = [
                        'data' => [
                            [
                                22,
                                'John Bender',
                                '+02 (123) 123456789',
                                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
                            ],
                            [
                                19,
                                'Sophia Clemens',
                                '+99 (987) 987654321',
                                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
                            ],
                            [
                                3,
                                'Peter Sousa',
                                '+69 (555) 12367345243',
                                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
                            ],
                        ],
                        'order' => [[1, 'asc']],
                        'columns' => [null, null, null, ['orderable' => false]],
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads">
                    @foreach ($config['data'] as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable> --}}
            </div>
        </div>
    </div>
@stop

@section('footer')
    <div class="container text-start">
        <div class="row align-items-start">
            <div class="col">
                Fin de la sesión: 23:59:59
            </div>
            <div class="col">
                Version: {{ config('app.version', '1.0.0') }}
            </div>
            <div class="col">
                {{ config('app.company_name', '2023 Soluciones Informáticas MJ SCA') }}
            </div>
        </div>
    </div>
@stop

<script>
    function newProject() {
        console.log('New project button clicked!');
    }

    function exportPdf() {
        console.log('Export PDF button clicked!');
    }
</script>
