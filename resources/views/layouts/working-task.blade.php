<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<body>
    <x-adminlte-select class="selUser" name="selUser" label-class="text-navy" igroup-size="lg"
        data-placeholder="Selecciona un calendario" onchange="selectUser(this.value)">
    </x-adminlte-select>
    <!-- CALENDAR View -->
    <div id='calendar'></div>
    <!-- Modal for event details -->
    <x-adminlte-modal id="eventDetailsModal" title="Evento" theme="navy" size='xs'>
        <x-adminlte-input name="startTimeEvent" label="Inicio tarea" igroup-size="xs">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <x-adminlte-textarea name="eventDescription" label="Texto informativo" rows=4>
        </x-adminlte-textarea>
        <x-adminlte-input name="endTimeEvent" label="Fin tarea" igroup-size="xs">
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-lg fa-save" theme="success" label="Guardar" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    @push('js')
        <script>
            var calendar = null;
            var users = null;

            initCalendar();
            getUsers();


            function initCalendar() {
                var calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'es',
                    themeSystem: 'bootstrap5',
                    titleFormat: {
                        weekday: 'long',
                        day: 'numeric',
                        year: 'numeric',
                        month: 'long'
                    },
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false,
                        omitZeroMinute: false
                    },
                    businessHours: true,
                    themeSystem: 'bootstrap5',
                    businessHours: {
                        startTime: '8:00',
                        endTime: '18:30',
                        daysOfWeek: [1, 2, 3, 4, 5] // Lunes - Viernes
                    },
                    nowIndicator: true,
                    allDaySlot: false,
                    firstDay: 1,
                    customButtons: {
                        administrationButton: {
                            text: 'Gestión',
                            click: function() {}
                        },
                    },
                    showNonCurrentDates: false,
                    weekends: false,
                    droppable: true,
                    slotMinTime: '8:00',
                    slotMaxTime: '18:30',
                    initialView: 'timeGridDay',
                    contentHeight: "auto",
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día',
                        timeGridWeek: 'Semana',
                        timeGridDay: 'Día'
                    },
                    headerToolbar: {
                        left: 'prev,today,next',
                        center: 'title',
                        right: 'timeGridWeek,timeGridDay,administrationButton'
                    },
                    eventContent: function(info) {
                        return {
                            html: info.event.title
                        };
                    },
                    eventClick: function(info) {
                        $('#eventDetailsModal').modal('show');
                        $('#startTimeEvent').val(info.event.start.toLocaleString('es'));
                        $('#endTimeEvent').val(info.event.end.toLocaleString('es'));
                    },
                });
                calendar.render();
            }


            function selectUser(userIdSelected) {
                fetchEvents(userIdSelected);
            }


            function getUsers() {
                // Fetch users from the api using AJAX
                fetch('/api/users')
                    .then(response => response.json())
                    .then(data => {
                        const userSelect = document.querySelector('select[name="selUser"]');
                        users = data;
                        data.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.id;
                            option.textContent = `Calendario de ${user.name}`;

                            userSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching users:', error));
            }


            function fetchEvents(userId) {
                fetch(`/api/events/${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        calendar.removeAllEventSources();

                        var projects = data.myProjects;
                        var events = data.myEvents;

                        calendar.addEventSource(events.map(event => ({
                            title: `${event.projectName} <br> ${event.text}`,
                            start: event.start_date,
                            end: event.end_date,
                            color: "#041e49",
                            textColor: 'white'
                        })));
                    })
                    .catch(error => console.error('Error fetching events:', error));
            }
        </script>
    @endpush
</body>

</html>
