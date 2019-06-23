@extends('Shift::layouts.shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Locali</h3>
            <div class="card-options">
                <a href="{{ route('shifts.locals.create') }}" class="btn btn-green btn-sm">
                    <span class="fe fe-plus"></span>
                    Aggiungi locale
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
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($locals as $local)
                    <tr>

                        <td>{{ $local->name }}</td>
                        <td>
                            <a href="{{ route('shifts.locals.edit', $local->id) }}" class="icon"><i class="fe fe-edit"></i></a>
                            <a href="#" class="icon" onclick="if(confirm('Vuoi davvero eliminare questo elemento?')){$('#del-{{ $local->id }}').submit()}">
                                <i class="text-red fe fe-trash"></i>
                            </a>
                            <form style="visibility: hidden"
                                  method="POST"
                                  id="del-{{ $local->id }}" action="{{ route('shifts.locals.destroy', $local->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer text-center align-self-center">
                {{ $locals->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

@endsection