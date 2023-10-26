<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id='calendar' class="p-10"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    slotMinTime: '8:00:00',
                    slotMaxTime: '19:00:00',
                    events: @json($events),
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false,
                    },
                    eventContent: function (arg) {
                        var group = arg.event.extendedProps.group;
                        var name = arg.event.title;
                        var date = arg.timeText;
                        var content = document.createElement('div');

                        if (name) {
                            var nameElement = document.createElement('div');
                            nameElement.textContent = name;
                            content.appendChild(nameElement);
                            nameElement.classList.add('text-sm', 'font-semibold', 'text-white');
                        }

                        if (date) {
                            var dateElement = document.createElement('div');
                            dateElement.textContent = date;
                            content.appendChild(dateElement);
                            dateElement.classList.add('text-xs', 'text-white');
                        }

                        if (group) {
                            var groupElement = document.createElement('div');
                            groupElement.textContent = group;
                            content.appendChild(groupElement);
                            groupElement.classList.add('text-xs', 'text-white');
                        }

                        return { domNodes: [content] };
                    },
                    eventRender: function (arg) {
                        var status = arg.event.extendedProps.status;
                        if (status === 'completed') {
                            arg.el.style.backgroundColor = 'green'; // Imposta il colore di sfondo in base allo stato
                        } else if (status === 'active') {
                            arg.el.style.backgroundColor = 'blue';
                        } else if (status === EventStatus::CANCELED) {
                            arg.el.style.backgroundColor = 'red';
                        } else if ( status === EventStatus::PLANNED){
                            arg.el.style.backgroundColor = 'blue';
                        }
                    },
                });
                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
