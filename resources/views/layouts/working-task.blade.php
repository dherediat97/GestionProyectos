<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<body>
    <x-adminlte-select class="selUser" name="selUser" label-class="text-navy" igroup-size="lg"
        data-placeholder="Selecciona un calendario" onchange="fetchEvents(this.value)">
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
            <x-adminlte-button id="saveEventButton" icon="fas fa-lg fa-save" theme="success" label="Guardar"
                onclick="saveEvent()" />
            <x-adminlte-button theme="danger" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    @push('css')
        <style>
            .fc-timegrid-axis,
            .fc-scrollgrid-sync-inner,
            .fc-button.fc-button-primary,
            .fc-col-header-cell.fc-day.fc-day-mon.fc-day-future {
                background-color: #2F4486 !important;
            }

            .fc-col-header-cell-cushion {
                color: white !important;
                text-decoration: none;
                font-weight: bold;
            }

            .fc-next-button.fc-button.fc-button-primary {
                margin-right: 20px;
            }

            .fc-timegrid-slot.fc-timegrid-slot-label.fc-timegrid-slot-minor,
            .fc-timegrid-slot-label-frame.fc-scrollgrid-shrink-frame {
                background-color: white !important;
                border: 1px solid #041e49 !important;
            }

            .fc-timegrid-slot.fc-timegrid-slot-lane {
                background-color: #fffadf !important;
            }

            .fc-non-business {
                background-color: #041e4965 !important;
            }

            .fc .fc-toolbar-title {
                font-size: 0.8em;
                font-weight: normal;
            }
        </style>
    @endpush

    @push('js')
        <script>
            var calendar = initCalendar();
            var projectIdDragged = 0;
            getUsers();


            function initCalendar() {
                // Initialize the calendar element
                var calendarEl = document.getElementById('calendar');
                // Initialize the draggable elements
                var draggableElements = [...$('.availableProject')];

                // Initialize the calendar
                calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'es',
                    themeSystem: 'bootstrap5',
                    titleFormat: {
                        weekday: 'long',
                        day: 'numeric',
                        year: 'numeric',
                        month: 'long',
                    },
                    slotLabelFormat: {
                        hour: 'numeric',
                        minute: '2-digit',
                        meridiem: 'short',
                        omitZeroMinute: false,
                    },
                    businessHours: true,
                    businessHours: {
                        startTime: '8:00',
                        endTime: '19:00',
                        daysOfWeek: [1, 2, 3, 4, 5] // Lunes - Viernes
                    },
                    nowIndicator: true,
                    allDaySlot: false,
                    firstDay: 1,
                    buttonIcons: {
                        calendarIcon: 'calendar',
                    },
                    customButtons: {
                        calendarButton: {
                            icon: 'calendarIcon',
                            click: function() {}
                        },
                        administrationButton: {
                            text: 'Gestión',
                            click: function() {}
                        },
                    },
                    eventDisplay: 'block',
                    showNonCurrentDates: false,
                    weekends: true,
                    editable: true,
                    displayEventTime: true,
                    droppable: true,
                    slotLabelInterval: '00:30',
                    slotMinTime: '8:00',
                    slotMaxTime: '23:59',
                    initialView: 'timeGridDay',
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día',
                        timeGridWeek: 'Semana',
                        timeGridDay: 'Día'
                    },
                    headerToolbar: {
                        left: 'prev,calendarButton,next,today',
                        center: 'title',
                        right: 'timeGridWeek,timeGridDay,administrationButton'
                    },
                    droppable: true,
                    drop: function(info) {
                        projectIdDragged = info.draggedEl.dataset.id;
                        openModalEvent(true, info);
                    },
                    eventClick: function(info) {
                        openModalEvent(false, info);
                    },
                });

                calendar.render();

                draggableElements.forEach(element => {
                    let draggable = new FullCalendar.Interaction.Draggable(element, {
                        eventData: {
                            id: element.dataset.id,
                        }
                    });
                });

                return calendar;
            }

            function openModalEvent(newEvent, info) {
                $('#startTimeEvent').val('');
                $('#endTimeEvent').val('');
                $('#eventDescription').val('');
                $('#eventDetailsModal').modal('show');

                if (newEvent) {
                    var startTimeEvent = formatDate(info.date);
                    $('#saveEventButton').removeClass('invisible');
                    $('#saveEventButton').addClass('visible');
                    $('#startTimeEvent').val(startTimeEvent);
                } else {
                    $('#saveEventButton').removeClass('visible');
                    $('#saveEventButton').addClass('invisible');
                    $('#startTimeEvent').val(info.event.start.toLocaleString('es'));
                    $('#endTimeEvent').val(info.event.end.toLocaleString('es'));
                    $('#eventDescription').val(info.event.title);
                }
            }

            function getUsers() {
                // Fetch users from the api using AJAX
                fetch('/api/users')
                    .then(response => response.json())
                    .then(data => {
                        const userSelect = document.querySelector('select[name="selUser"]');
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
                            title: event.text,
                            start: event.start_date,
                            end: event.end_date,
                            color: "#2F4486",
                            textColor: 'white',
                            extendedProps: {
                                projectId: event.project_id,
                            }
                        })));
                    })
                    .catch(error => console.error('Error fetching events:', error));
            }

            function saveEvent() {
                const startTimeEvent = $('#startTimeEvent').val();
                const endTimeEvent = $('#endTimeEvent').val();
                const infoText = $('#eventDescription').val();

                fetch('api/events', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        project_id: projectIdDragged,
                        start_date: startTimeEvent,
                        end_date: endTimeEvent,
                        text: infoText,
                    }),
                }).then(response => {
                    if (response.ok) {
                        $('#eventDetailsModal').modal('hide');
                    } else {
                        console.error('Error saving event:', response.statusText);
                    }
                }).catch(error => console.error('Error saving event:', error));
            }


            function formatDate(date) {
                var day = date.getDate();
                if (day < 10) day = `0${day}`
                var month = date.getMonth() + 1;
                if (month < 10) month = `0${month}`
                const year = date.getFullYear();
                var hours = date.getHours();
                if (hours < 10) hours = `0${hours}`
                var minutes = date.getMinutes();
                if (minutes < 10) minutes = `0${minutes}`

                return `${day}/${month}/${year} ${hours}:${minutes}`;
            }
        </script>
    @endpush
</body>

</html>
