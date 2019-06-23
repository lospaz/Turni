@extends('Shift::layouts.app')

@push('css')
    <link href='{{ asset("fullcalendar/packages/core/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/daygrid/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/timegrid/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/timeline/main.css") }}' rel='stylesheet' />
    <link href='{{ asset("fullcalendar/packages/resource-timeline/main.css") }}' rel='stylesheet' />
@endpush

@section('content')
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
                },
                eventClick: function (info) {
                    let id = info.event.id;
                    let url = '{{ route("shifts.shift.show", ":id") }}';
                    url = url.replace(':id', id);
                    $.get(url, function (data) {
                        $('#shiftModal').modal('show');
                        $('#shiftContent').html(data.view);

                        if(!data.edit)
                            $('#shiftEdit').hide();
                        else {
                            $('#shiftEdit').show();
                            let href = $('#shiftEdit').attr('href');
                            $('#shiftEdit').attr('href', href.replace(':id', id));
                        }

                        if(!data.delete)
                            $('#shiftDelete').hide();
                        else {
                            $('#shiftDelete').show();
                            let action = $('#shiftDeleteForm').attr('action');
                            $('#shiftDeleteForm').attr('action', action.replace(':id', id));
                        }

                    });
                }
            });

            calendar.render();
        });

    </script>

    <div class="modal" id="shiftModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Turno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div id="shiftContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <a href="{{ route('shifts.calendar.edit', ':id') }}" id="shiftEdit" class="btn btn-warning">Modifica</a>
                    <button type="button"
                            onclick="if(confirm('Vuoi davvero eliminare questo elemento?')){$('#shiftDeleteForm').submit()}"
                            id="shiftDelete" class="btn btn-danger">Elimina</button>
                </div>
                <form style="visibility: hidden"
                      method="POST"
                      id="shiftDeleteForm" action="{{ route('shifts.calendar.destroy', ':id') }}">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endpush