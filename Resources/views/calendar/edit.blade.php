@extends('Shift::shift')

@push('css')
    <style>
        .text-divider{margin: 2em 0; line-height: 0; text-align: center;}
        .text-divider span{background-color: #ffffff; padding: 1em;}
        .text-divider:before{ content: " "; display: block; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #f7f7f7;}
    </style>
@endpush

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifica turno</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('shifts.calendar.update', $shift->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Data inizio</label>
                            <input type="text" name="startDate" class="form-control" value="{{ $shift->start->format('d/m/Y') }}" required />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ora inizio</label>
                            <input type="text" name="startHour" class="form-control" value="{{ $shift->start->format('H:i') }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Data fine</label>
                            <input type="text" name="endDate" class="form-control" value="{{ $shift->end->format('d/m/Y') }}" required />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ora fine</label>
                            <input type="text" name="endHour" class="form-control" value="{{ $shift->end->format('H:i') }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Turnisti</label>
                            <select type="text" id="users" name="users[]" class="form-control" multiple required>
                                @foreach(\App\User::shiftsAvailable() as $user)
                                    <option value="{{ $user->id }}" @if(in_array($user->id, $shift->users->pluck('id')->toArray())) selected @endif
                                    >{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <p class="text-divider"><span>hai quasi finito!</span></p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Seleziona modello predefinito</label>
                            <select type="text" id="template" name="template_id" class="form-control">
                                <option></option>
                                @foreach($template as $t)
                                    <option value="{{ $t->id }}" @if($t->id == $shift->template_id) selected @endif>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">oppure seleziona le attività</label>
                            <select type="text" id="activities" name="activities[]" class="form-control" multiple>
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}"
                                        @if(in_array($activity->id, $shift->activities->pluck('id')->toArray())) selected @endif>{{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Crea</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#users').selectize();

            let template = $("#template");
            let activities = $("#activities");

            let $templateSelect = template.selectize({
                onChange: function (value) {
                    if(value !== ""){
                        var control = $activitiesSelect[0].selectize;
                        control.clear();
                    }
                }
            });

            let $activitiesSelect = activities.selectize({
                onChange: function (value) {
                    if (value !== "") {
                        var control = $templateSelect[0].selectize;
                        control.clear();
                    }
                }
            });
        });
    </script>
@endpush