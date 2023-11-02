<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id='calendar' class="p-10"></div>
                @if (auth()->user()->isAdmin())
                    <div class="flex justify-end">
                        <div class="border border-gray-300 bg-gray-100 shadow-md rounded-md p-6 mx-10 mb-8 -mt-4">
                            <form id="group-selection-form">
                                @csrf
                                <select name="group" id="group" class="rounded-md placeholder-gray-400 mr-3">
                                    <option value="" class="text-gray-200" disabled selected hidden>Seleziona gruppo</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                <x-primary-button type="button" id="go-to-event-creation">Crea evento</x-primary-button>
                            </form>
                        </div>
                    </div>
                @endif
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
                    events: @json($events),
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
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
