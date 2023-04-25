@push('scripts')

@endpush

<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Gestionnaire: {{$gestionnaire->account->first_name}}</h4>
                    </div>
                </div>
                {{ Form::open(['url' => 'gestionnaires/'.$gestionnaire->id.'/gestionnairedit','method' => 'post']) }}
                <div class="card-body px-3">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">First name</label>
                            {{ Form::text('first_name', old('first_name',$gestionnaire->account->first_name), ['class' => 'form-control','id' => 'firstname', 'placeholder' => '', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Last name</label>
                            {{ Form::text('last_name', old('last_name',$gestionnaire->account->last_name), ['class' => 'form-control','id' => 'lastname', 'placeholder' => '', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Email</label>
                            {{ Form::text('email', old('email',$gestionnaire->account->email), ['class' => 'form-control','id' => 'email', 'placeholder' => '', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Phone</label>
                            {{ Form::text('phone_number', old('phone_number',$gestionnaire->account->phone_number), ['class' => 'form-control','id' => 'phone_number', 'placeholder' => '', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Adresse</label>
                            {{ Form::text('address', old('address',$gestionnaire->address), ['class' => 'form-control','id' => 'address', 'placeholder' => '', 'required']) }}
                        </div>
                       {{-- <div class="form-group col-md-6">
                            <label class="form-label">Groupes locaux</label>
                            {{ Form::select('groups', $groups,null, ['class' => 'form-select','id' => 'group_local', 'required','multiple'=>'multiple']) }}
                        </div>--}}
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="col-md-2 btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <button type="button" class="col-md-2 btn btn-danger" data-bs-dismiss="modal">Cancel</button>

                </div>{{ Form::close() }}
            </div>
        </div>

    </div>

</x-app-layout>
