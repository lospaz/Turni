@extends('Shift::shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuova mansione</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('shifts.tasks.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Descrizione</label>
                            <textarea type="text" name="description" class="form-control" required ></textarea>
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