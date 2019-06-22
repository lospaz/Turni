@extends('Shift::shift')

@push('css')
    <link href='{{ asset("fullcalendar/packages/core/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/daygrid/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/timegrid/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/timeline/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/resource-timeline/main.css") }}' rel='stylesheet' />
@endpush

@section('shift.content')
    <div id='calendar' class="card p-1"></div>
@endsection

@push('scripts')
    <script src='{{ asset("fullcalendar/packages/core/main.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/core/locales/it.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/interaction/main.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/daygrid/main.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/timegrid/main.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/timeline/main.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/resource-common/main.js") }}'></script>
    <script src='{{ asset("fullcalendar/packages/resource-timeline/main.js") }}'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                locale: 'it',
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'resourceTimeline' ],
                editable: true,
                selectable: true,
                aspectRatio: 1.8,
                scrollTime: '00:00',
                timeZone: 'UTC+2',
                header: {
                    left: 'today prev,next',
                    center: 'title',
                    right: 'resourceTimelineDay,resourceTimelineThreeDays,resourceTimelineWeek,resourceTimelineMonth'
                },
                defaultView: 'resourceTimelineDay',
                views: {
                    resourceTimelineThreeDays: {
                        type: 'resourceTimeline',
                        duration: { days: 3 },
                        buttonText: '3 giorni'
                    }
                },
                resources: [
                    @foreach(\App\User::shiftsAvailable() as $user)
                    { id: '{{ $user->id }}', title: '{{ $user->name }}' },
                    @endforeach
                ],
                events: '{{ route("shifts.calendar.source") }}',
                eventTextColor: 'white',
                select: function (info) {
                    window.location.href = '{{ route("shifts.calendar.create")  }}?start=' + (new Date(info.start).getTime() / 1000)
                        + '&end=' + (new Date(info.end).getTime() / 1000 ) + '&resource_id=' + info.resource._resource.id;
                }
            });

            calendar.render();
        });

    </script>
@endpush