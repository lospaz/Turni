@extends('Shift::shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuova attività</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('shifts.activities.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Locale</label>
                            <select type="text"
                                   id="locals"
                                   name="local_id" class="form-control">
                                <option></option>
                                @foreach($locals as $local)
                                    <option value="{{ $local->id }}">{{ $local->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Mansioni</label>
                            <select type="text"
                                    id="tasks"
                                    name="tasks[]" class="form-control" multiple required >
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->name }}</option>
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
            $('#locals').selectize();

            $('#tasks').selectize({
                create: false
            });
        });
    </script>
@endpush