<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto mt-6 sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg">
                <div id='calendar' class="p-10"></div>
            </div>
        </div>
    </div>


    @push('scripts')

        <script>
            document.getElementById('go-to-event-creation').addEventListener('click', function () {
                var selectedGroupId = document.getElementById('group').value;
                var url = "{{ route('events.create', ['group' => ':group']) }}";
                url = url.replace(':group', selectedGroupId);
                window.location.href = url;
            });
        </script>

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    slotMinTime: '8:00:00',
                    slotMaxTime: '19:00:00',
                    expandRows:true,
                    allDaySlot: false,
                    titleFormat: { month: 'long', year:'numeric'},
                    events: @json($events),
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    eventContent: function (arg) {
                        var group = arg.event.extendedProps.group;
                        var name = arg.event.title;
                        var date = arg.timeText;
                        var status = arg.event.extendedProps.status;
                        var client = arg.event.extendedProps.client;
                        var content = document.createElement('div');
                        if (status) {
                            var statusElement = document.createElement('span');
                            statusElement.textContent = status;
                            content.appendChild(statusElement);
                            statusElement.classList.add('text-2xs', 'text-white', 'uppercase', 'font-semibold', 'p-1', 'rounded-sm');
                            switch (status) {
                                case 'planned':
                                    statusElement.classList.add('bg-amber-600');
                                    break;
                                case 'completed':
                                    statusElement.classList.add('bg-indigo-600');
                                    break;
                                case 'canceled':
                                    statusElement.classList.add('bg-red-600');
                                    break;
                                case 'active':
                                    statusElement.classList.add('bg-emerald-600');
                                    break;
                            }
                        }
                        if (name) {
                            var nameElement = document.createElement('div');
                            nameElement.textContent = name;
                            content.appendChild(nameElement);
                            nameElement.classList.add('text-sm', 'font-semibold', 'text-white', 'mt-1');
                        }
                        if (date) {
                            var dateElement = document.createElement('div');
                            dateElement.textContent = date;
                            content.appendChild(dateElement);
                            dateElement.classList.add('text-xs', 'text-white');
                        }
                        if (client) {
                            var clientElement = document.createElement('div');
                            clientElement.textContent = client;
                            content.appendChild(clientElement);
                            clientElement.classList.add('text-xs', 'text-white');
                        }
                        if (group) {
                            var groupElement = document.createElement('div');
                            groupElement.textContent = group;
                            content.appendChild(groupElement);
                            groupElement.classList.add('text-xs', 'text-white');
                        }
                        return { domNodes: [content] };
                    },
                });

                calendar.render();
            });
        </script>

    @endpush
</x-app-layout>
