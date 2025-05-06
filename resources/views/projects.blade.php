@extends('adminlte::page')

@section('title', 'Control de proyectos')
@section('plugins.toastr', true)

@section('content')
    @yield('content_body')
    {{-- INPUT DATE CONFIG --}}
    @php
        $config = [
            'format' => 'DD/MM/YYYY',
            'locale' => 'es',
            'dayViewHeaderFormat' => 'MMM YYYY',
            'maxDate' => "js:moment().endOf('month')",
        ];
    @endphp
    {{-- EXPORT EVENTS MODAL --}}
    <x-adminlte-modal id="exportEventsPDF" title="Opciones del informe" theme="navy">
        <x-adminlte-input-date :config="$config" name="startTimeEventExport" label="Fecha Desde" igroup-size="xs"
            placeholder="dd/mm/yyyy">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input-date :config="$config" name="endTimeEventExport" label="Fecha Hasta" igroup-size="xs"
            placeholder="dd/mm/yyyy">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-select name="selProject" id="projectSelected" label="Proyecto" label-class="text-navy" igroup-size="xs">
            <option value="0" disabled>Todos los proyectos</option>
        </x-adminlte-select>

        <x-adminlte-select name="selUserModal" id="userSelected" label="Usuario" label-class="text-navy" igroup-size="xs">
            <option value="0" disabled>Selecciona una Opción</option>
        </x-adminlte-select>

        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-lg fa-file-pdf" theme="success" label="Generar"
                onclick="generateEventReport()" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    {{-- NEW PROJECT MODAL --}}
    <x-adminlte-modal id="newProjectModal" title="Nuevo projecto" theme="navy">
        <x-adminlte-input name="nameProject" label="Nombre del proyecto" igroup-size="xs"
            placeholder="Introduce el nombre del proyecto">

        </x-adminlte-input>

        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-lg fa-add" theme="success" label="Crear" onclick="newProjectRequest()" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <div class="mx-auto p-2 text-start">
        <div class="row align-items-start">
            <div class="col">
                <x-adminlte-card title="{{ __('menu.admin_projects') }}" theme="light">
                    <x-slot name="toolsSlot" theme="light">
                        @if (auth()->user()->is_user_admin)
                            <x-adminlte-button theme="primary" id="newProjectButton" icon="fas fa-lg fa-add"
                                onclick="newProject()"></x-adminlte-button>
                        @endif
                        <x-adminlte-button id="exportEventsPDFButton" theme="primary" icon="fas fa-lg fa-file-pdf"
                            data-toggle="modal" onclick="openExportEventsModal()"></x-adminlte-button>
                    </x-slot>
                    <x-slot name="footerSlot">
                        <div class="project-container"></div>
                    </x-slot>
                </x-adminlte-card>
            </div>
            <div class="col">
                @include('layouts.working-task')
            </div>
        </div>
    </div>
@stop

{{-- FOOTER SECTION --}}
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


@push('css')
    <style>
        #exportEventsPDFButton,
        #newProjectButton {
            background-color: #2F4486 !important;
            height: 30px;
        }
    </style>
@endpush

<script>
    var users = null;
    var projectSelected = null;

    // First get all users
    getUsers();


    function getUsers() {
        // Fetch users from the api using AJAX
        fetch('/api/users')
            .then(response => response.json())
            .then(data => {
                const userSelect = document.querySelector('select[name="selUserModal"]');
                users = data;
                data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.name;

                    userSelect.appendChild(option);
                });
                getProjects();
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    function getProjects() {
        // Fetch projects from the server using AJAX
        fetch('/api/projects')
            .then(response => response.json())
            .then(data => {
                setProjects(data);
                setGeneralProjects(data);
            })
            .catch(error => console.error('Error fetching projects:', error));
    }

    function setProjects(data) {
        const projectContainer = document.querySelector('.project-container');
        projectContainer.innerHTML = '';

        data.forEach(project => {
            const projectCard = document.createElement('div');
            const username = users.find(user => user.id === project.user_id).name;
            projectCard.innerHTML = `<div draggable="true" class="availableProject" data-id="${project.id}"  ondragstart="dragstartHandler(event)">
                            <x-adminlte-card theme="warning" title="${project.name}" body-class="bg-warning" header-class="bg-warning">
                                Creado por ${username} el ${project.last_used_date}
                            </x-adminlte-card>
                        </div>`;
            projectContainer.appendChild(projectCard);
        });
    }

    function setGeneralProjects(data) {
        const projectSelect = document.querySelector('select[name="selProject"]');
        data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;
            projectSelect.appendChild(option);
        });
    }

    function newProject() {
        $("#newProjectModal").modal("show");
    }

    function newProjectRequest() {
        const projectSelected = $("#nameProject").val();
        const userId = '{{ Auth::user()->id }}';
        $.ajax({
            url: '/api/projects',
            method: 'POST',
            data: {
                'name': projectSelected,
                'user_id': userId,
            },
            success: function(response) {
                $("#newProjectModal").modal('hide');
                toastr.success('Proyecto creado correctamente');
                getProjects();
            },
            error: function(response) {
                toastr.error('Error. El proyecto tiene que tener un nombre');
            }
        });
    }

    function openExportEventsModal() {
        $("#startTimeEventExport").val($("#startTimeEventExport option:first").val());
        $("#endTimeEventExport").val($("#endTimeEventExport option:first").val());
        $("#projectSelected").val($("#projectSelected option:first").val());
        $("#userSelected").val($("#userSelected option:first").val());


        $("#exportEventsPDF").modal("show");
    }

    function generateEventReport() {
        const startDate = $("#startTimeEventExport").val();
        const endDate = $("#endTimeEventExport").val();
        const projectSelected = $("#projectSelected").val();
        const userSelected = $("#userSelected").val();

        toastr.options = {
            'progressBar': true,
            'closeButton': true,
            'preventDuplicates': false,
        }

        $.ajax({
            url: '/api/reports',
            method: 'GET',
            data: {
                'start_date': startDate,
                'end_date': endDate,
                'user_id': userSelected,
                'project_id': projectSelected,
            },
            success: function(response) {
                $("#exportEventsPDF").modal('hide');
                toastr.success('Informe exportado correctamente');
                window.open('eventReport.pdf');
            },
            error: function(response) {
                toastr.error(
                    'Error. El informe no se ha podido exportar, verifica que has introducido todos los datos requeridos'
                );
            }
        });
    }
</script>
