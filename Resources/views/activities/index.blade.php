@extends('Shift::layouts.shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Attività</h3>
            <div class="card-options">
                <a href="{{ route('shifts.activities.create') }}" class="btn btn-green btn-sm">
                    <span class="fe fe-plus"></span>
                    Aggiungi attività
                </a>
                &nbsp;
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm"
                               value="{{ request()->q }}"
                               placeholder="Cerca..." name="q">
                        <span class="input-group-btn ml-2">
                            <button class="btn btn-sm btn-default" type="submit">
                              <span class="fe fe-search"></span>
                            </button>
                          </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-striped table-vcenter">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Locale</th>
                    <th>Mansioni</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($activities as $activity)
                    <tr>

                        <td>{{ $activity->name }}</td>
                        <td>@if($activity->local) {{ $activity->local->name }} @endif</td>
                        <td>{{ $activity->tasks->pluck('name')->implode(', ') }}</td>
                        <td>
                            <a href="{{ route('shifts.activities.edit', $activity->id) }}" class="icon"><i class="fe fe-edit"></i></a>
                            <a href="#" class="icon" onclick="if(confirm('Vuoi davvero eliminare questo elemento?')){$('#del-{{ $activity->id }}').submit()}">
                                <i class="text-red fe fe-trash"></i>
                            </a>
                            <form style="visibility: hidden"
                                  method="POST"
                                  id="del-{{ $activity->id }}" action="{{ route('shifts.activities.destroy', $activity->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer text-center align-self-center">
                {{ $activities->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

@endsection