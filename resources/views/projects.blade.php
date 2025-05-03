@extends('adminlte::page')

@section('title', 'Control de proyectos')

@section('content')
    <x-adminlte-modal id="exportEventsPDF" title="Opciones del informe" theme="navy">
        <x-adminlte-input name="startTimeEvent" label="Fecha Desde" igroup-size="xs" placeholder="dd/mm/yyyy">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <x-adminlte-input name="endTimeEvent" label="Fecha Hasta" igroup-size="xs" placeholder="dd/mm/yyyy">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select name="selProject" label="Proyecto" label-class="text-navy" igroup-size="xs"
            onchange="selectProject(this.value)" placeholder="Todos los proyectos">
        </x-adminlte-select>

        <x-adminlte-select name="selUserModal" label="Usuario" label-class="text-navy" igroup-size="xs"
            onchange="selectUser(this.value)" placeholder="Selecciona una Opción">
        </x-adminlte-select>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-lg fa-file-pdf" theme="success" label="Generar" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <div class="mx-auto p-2 text-start">
        <div class="row align-items-start">
            <div class="col">
                <x-adminlte-card title="Control de proyectos">
                    <x-slot name="toolsSlot">
                        @if (auth()->user()->hasRole('admin'))
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
                <x-adminlte-select class="selUser" name="selUser" label-class="text-navy" igroup-size="lg"
                    onchange="selectUser(this.value)">
                </x-adminlte-select>
                @include('layouts.working-task')
            </div>
        </div>
    </div>
    @yield('content_body')
    @include('layouts.footer')
@stop




<script>
    var userSelected = null;
    var projectSelected = null;
    getProjects();
    getUsers();

    function selectUser(user) {
        userSelected = user;
    }

    function selectProject(project) {
        projectSelected = project;
    }

    function getUsers() {
        // Fetch users from the api using AJAX
        fetch('/api/users')
            .then(response => response.json())
            .then(data => {
                const userSelectModal = document.querySelector('select[name="selUserModal"]');
                const userSelect = document.querySelector('select[name="selUser"]');
                data.forEach(user => {
                    const optionModal = document.createElement('option');
                    optionModal.value = user.id;
                    optionModal.textContent = user.name;

                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = `Calendario de ${user.name}`;

                    userSelect.appendChild(option);
                    userSelectModal.appendChild(optionModal);
                });
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
        // Update the UI with the fetched projects
        const projectContainer = document.querySelector('.project-container');
        projectContainer.innerHTML = ''; // Clear existing projects
        data.forEach(project => {
            const projectCard = document.createElement('div');
            projectCard.className = 'project-card';
            projectCard.innerHTML = `
                        <x-adminlte-card theme="warning" title=${project.name} body-class="bg-warning" header-class="bg-warning">
                            Creado por usuario ${project.user_id}
                        </x-adminlte-card>`;
            projectContainer.appendChild(projectCard);
        });
    }

    function setGeneralProjects(data) {
        const projectSelect = document.querySelector('select[name="selProject"]');
        data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = `${user.name}`;
            projectSelect.appendChild(option);
        });
    }

    function newProject() {
        console.log('New project button clicked!');
    }
</script>
