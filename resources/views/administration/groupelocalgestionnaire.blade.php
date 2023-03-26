@push('scripts')

@endpush

<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Gestionnaires du groupe: {{$groupe->libelle}}</h4>
                    </div>
                </div>
                <div class="card-body px-3">
                    {{ Form::open(['url' => 'groupelocal/1/gestionnaire','method' => 'post']) }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Gestionnaires</label>
                            {{ Form::select('gestionnaire', $gestionnaires,null, ['class' => 'form-select','id' => 'group_local', 'required']) }}
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary mt-4" data-bs-dismiss="modal">Ajouter</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="col-md-12 mt-3">
                        <table class="table table-bordered">
                            <thead>
                            <tr><th>Gestionnaire</th>
                                <th>Action</th></tr>

                            </thead>
                            <tbody>
                            @foreach($groupe_gestionnaires as $gestionnaire)
                            <tr>
                                <td>{{$gestionnaire->account->first_name}} {{$gestionnaire->account->last_name}}</td>
                                <td><a class="btn btn-danger">remove</a></td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
