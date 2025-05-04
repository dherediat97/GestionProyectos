@extends('adminlte::page')

@section('title', 'Control de proyectos')

@section('content')
    @yield('content_body')
    <x-adminlte-modal id="exportEventsPDF" title="Opciones del informe" theme="navy">
        <x-adminlte-input name="startTimeExport" label="Fecha Desde" igroup-size="xs" placeholder="dd/mm/yyyy">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <x-adminlte-input name="endTimeEventExport" label="Fecha Hasta" igroup-size="xs" placeholder="dd/mm/yyyy">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select name="selProject" label="Proyecto" label-class="text-navy" igroup-size="xs"
            placeholder="Todos los proyectos">
        </x-adminlte-select>

        <x-adminlte-select name="selUserModal" label="Usuario" label-class="text-navy" igroup-size="xs"
            placeholder="Selecciona una Opción">
        </x-adminlte-select>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-lg fa-file-pdf" theme="success" label="Generar" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <div class="mx-auto p-2 text-start">
        <div class="row align-items-start">
            <div class="col">
                <x-adminlte-card title="Control de proyectos" theme="white">
                    <x-slot name="toolsSlot" theme="white">
                        @if (auth()->user()->is_user_admin)
                            <x-adminlte-button theme="primary" icon="fas fa-lg fa-plus"
                                onclick="newProject()"></x-adminlte-button>
                        @endif
                        <x-adminlte-button theme="primary" icon="fas fa-lg fa-file-pdf" data-toggle="modal"
                            data-target="#exportEventsPDF"></x-adminlte-button>
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
                                Creado por usuario ${username}
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

    function dragstartHandler(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }
</script>
