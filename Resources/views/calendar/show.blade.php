<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="text-wrap" style="font-size: 18px">
                <p>Data inizio: {{ $shift->start->format('d/m H:i') }}</p>
                <p>Data fine: {{ $shift->end->format('d/m H:i') }}</p>
                <p>Turnisti</p>
                @foreach($shift->users as $user)
                    <span class="tag">
            <span class="tag-avatar avatar" style="background-image: url({{ $user->profile_photo }})"></span>
            {{ $user->name }}
        </span>
                @endforeach

                <p>Attività</p>
                @foreach($shift->getActivities() as $activity)
                    <button type="button" class="btn btn-secondary btn-pill mb-1 loadActivity"
                            aria-pressed="true"
                            data-title="{{ $activity->name }}"
                            data-content="{{ $activity->getTasks() }}">
                        {{ $activity->name }}
                    </button> &nbsp;
                @endforeach

            </div>
        </div>
        <div class="col-md-6" style="font-size: 18px;">
            <div id="activityTitle"></div>
            <div id="activityTask"></div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('.loadActivity').on('click', function () {
        let title = $(this).data('title');
        let content = $(this).data('content');

        $('#activityTitle').text('Attività: ' + title);

        var str = 'Mansioni:<ul>';

        content.forEach(function(task) {
            str += '<li>'+ task.name + ': ' + task.description + '</li>';
        });

        str += '</ul>';

        $('#activityTask').html(str);
    })
</script>