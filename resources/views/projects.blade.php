@extends('adminlte::page')

@section('title', 'Control de proyectos')
@section('plugins.toastr', true)

@section('content')
    @yield('content_body')
    @php
        $config = [
            'format' => 'DD/MM/YYYY',
            'dayViewHeaderFormat' => 'MMM YYYY',
            'maxDate' => "js:moment().endOf('month')",
        ];
    @endphp
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

        <x-adminlte-select name="selProject" id="projectSelected" label="Proyecto" label-class="text-navy" igroup-size="xs"
            placeholder="Todos los proyectos">
        </x-adminlte-select>

        <x-adminlte-select name="selUserModal" id="userSelected" label="Usuario" label-class="text-navy" igroup-size="xs"
            placeholder="Selecciona una Opción">
        </x-adminlte-select>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-lg fa-file-pdf" theme="success" label="Generar"
                onclick="generateEventReport()" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <div class="mx-auto p-2 text-start">
        <div class="row align-items-start">
            <div class="col">
                <x-adminlte-card title="{{ __('menu.admin_projects') }}" theme="light">
                    <x-slot name="toolsSlot" theme="light">
                        @if (auth()->user()->is_user_admin)
                            <x-adminlte-button theme="primary" icon="fas fa-lg fa-plus"
                                onclick="newProject()"></x-adminlte-button>
                        @endif
                        <x-adminlte-button id="exportEventsPDFIcon" theme="primary" icon="fas fa-lg fa-file-pdf"
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
    @include('layouts.footer')
@stop

@push('css')
    <style>
        #exportEventsPDFIcon {
            background-color: #2F4486 !important;
        }
    </style>
@endpush

<script>
    var users = null;
    var projectSelected = null;

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
                                Creado por ${username}
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
        console.log('New project button clicked!');
    }

    function openExportEventsModal() {
        $("#startTimeEventExport").val();
        $("#endTimeEventExport").val();
        $("#projectSelected").val();
        $("#userSelected").val();

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
            method: 'POST',
            data: {
                'start_date': startDate,
                'end_date': endDate,
                'user_id': userSelected,
                'project_id': projectSelected,
            },
            success: function(response) {
                toastr.success('Informe exportado correctamente')
                $("#exportEventsPDF").modal('hide');
            }
        });
    }
</script>
