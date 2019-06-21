@extends('Shift::shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modelli</h3>
            <div class="card-options">
                <a href="{{ route('shifts.templates.create') }}" class="btn btn-green btn-sm">
                    <span class="fe fe-plus"></span>
                    Aggiungi modello
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
                    <th>Attività</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($templates as $template)
                    <tr>

                        <td>{{ $template->name }}</td>
                        <td>{{ $template->activities->pluck('name')->implode(', ') }}</td>
                        <td>
                            <a href="{{ route('shifts.templates.edit', $template->id) }}" class="icon"><i class="fe fe-edit"></i></a>
                            <a href="#" class="icon" onclick="if(confirm('Vuoi davvero eliminare questo elemento?')){$('#del-{{ $template->id }}').submit()}">
                                <i class="text-red fe fe-trash"></i>
                            </a>
                            <form style="visibility: hidden"
                                  method="POST"
                                  id="del-{{ $template->id }}" action="{{ route('shifts.templates.destroy', $template->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer text-center align-self-center">
                {{ $templates->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

@endsection