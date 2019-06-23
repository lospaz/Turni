@extends('Shift::layouts.shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifica locale</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('shifts.locals.update', $local->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ $local->name }}" required />
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Salva</button>
                </div>
            </form>
        </div>
    </div>

@endsection