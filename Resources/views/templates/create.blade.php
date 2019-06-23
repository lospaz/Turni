@extends('Shift::layouts.shift')

@section('shift.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuovo modello</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('shifts.templates.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Attività</label>
                            <select type="text"
                                    id="activities"
                                    name="activities[]" class="form-control" multiple required >
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
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
            $('#activities').selectize({
                create: false
            });
        });
    </script>
@endpush