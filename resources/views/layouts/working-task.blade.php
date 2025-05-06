@php
    $config = [
        'format' => 'DD/MM/YYYY HH:mm',
        'dayViewHeaderFormat' => 'MMM YYYY',
        'minDate' => "js:moment().startOf('month')",
        'maxDate' => "js:moment().endOf('month')",
        'locale' => 'es',
        'daysOfWeekDisabled' => [0, 6],
    ];
@endphp
<x-adminlte-select class="selUser" name="selUser" label-class="text-navy" igroup-size="lg"
    data-placeholder="Selecciona un calendario" onchange="fetchEvents(this.value)">
</x-adminlte-select>
<!-- CALENDAR View -->
<div id='calendar'></div>
<!-- Modal for event details -->
<x-adminlte-modal id="eventDetailsModal" title="Evento" theme="navy" size='xs'>

    <x-adminlte-input-date name="startTimeEvent" :config="$config" label-class="text-dark" label="Inicio tarea"
        igroup-size="xs">
        <x-slot name="appendSlot">
            <div class="input-group-text  bg-navy">
                <i class="fas fa-calendar-day"></i>
            </div>
        </x-slot>
    </x-adminlte-input-date>

    <x-adminlte-textarea name="eventDescription" label="Texto informativo" rows=4>
    </x-adminlte-textarea>

    <x-adminlte-input-date name="endTimeEvent" :config="$config" label-class="text-dark" label="Fin tarea"
        igroup-size="xs">
        <x-slot name="appendSlot">
            <div class="input-group-text bg-navy">
                <i class="fas fa-calendar-day"></i>
            </div>
        </x-slot>
    </x-adminlte-input-date>

    <x-slot name="footerSlot">
        <x-adminlte-button id="saveEventButton" icon="fas fa-lg fa-save" theme="success" label="Guardar"
            onclick="saveEvent()" />
        <x-adminlte-button theme="danger" id="closeModal" icon="fas fa-lg fa-xmark" label="Cerrar" data-dismiss="modal"
            onclick="closeModal()" />
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

        .fc-toolbar,
        .fc-toolbar.fc-header-toolbar {
            padding: 0;
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
                customButtons: {
                    administration: {
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
                    left: 'prev,calendar,next,today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay,administration'
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

            //Change calendar icon
            $(".fc-calendar-button").append(`<i class="fa fas fa-calendar-day"></i>`);


            //Add draggable elements to the calendar
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

            if (newEvent) {
                var startTimeEvent = formatDate(info.date);
                $('#saveEventButton').removeClass('invisible');
                $('#saveEventButton').addClass('visible');
                $('#startTimeEvent').val(startTimeEvent);
            } else {
                var startTimeEvent = formatDate(new Date(info.event.start));
                var endTimeEvent = formatDate(new Date(info.event.end));
                $('#saveEventButton').removeClass('visible');
                $('#saveEventButton').addClass('invisible');
                $('#startTimeEvent').val(startTimeEvent);
                if (info.event.end)
                    $('#endTimeEvent').val(endTimeEvent);
                $('#eventDescription').val(info.event.title);
            }
            $("#closeModal").attr('data-newEvent', newEvent);
            $('#eventDetailsModal').modal('show');
        }

        function getUsers() {
            // Fetch users from the api using AJAX
            fetch('/api/users')
                .then(response => response.json())
                .then(data => {
                    const userSelect = $(".selUser");
                    data.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = `Calendario de ${user.name}`;

                        userSelect.append(option);
                    });
                    const option = $('.selUser option:eq({{ Auth::user()->id - 1 }})').prop('selected', true);
                    fetchEvents($('.selUser').find('option:selected').val());
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
                        id: event.id,
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
            const userId = '{{ Auth::user()->id }}';
            $.ajax({
                url: 'api/events/',
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    user_id: userId,
                    project_id: projectIdDragged,
                    start_date: startTimeEvent,
                    end_date: endTimeEvent,
                    text: infoText,
                }),
                success: function(response) {
                    $('#eventDetailsModal').modal('hide');
                    fetchEvents(userId);
                },
                error: function(response) {
                    toastr.error(
                        'Error: El evento no se ha podido crear correctamente'
                    );
                    closeModal();
                }
            });
        }

        function closeModal() {
            if ($("#closeModal").attr("data-newEvent") == 'true')
                calendar.getEvents().at(-1).remove();
            $('#eventDetailsModal').modal('hide');
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
