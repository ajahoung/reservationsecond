@push('scripts')

@endpush

<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit congés&ferié: {{$local->libelle}}</h4>
                    </div>
                </div>
                {{ Form::open(['url' => 'congeferie/'.$local->id.'/edit','method' => 'post']) }}
                <div class="card-body px-3">

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">Libelle</label>
                            {{ Form::text('libelle', old('libelle',$local->libelle), ['class' => 'form-control','id' => 'libelle', 'placeholder' => $local->libelle, 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">Date debut</label>
                            {{ Form::Date('datedebut', old('datedebut',$local->date_debut), ['class' => 'form-control','id' => 'datejour', 'placeholder' => '', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">Date fin</label>
                            {{ Form::Date('datefin', old('datefin',$local->date_fin), ['class' => 'form-control','id' => 'datefin', 'placeholder' => '', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::checkbox('Active', old('Active',$local->active), ['class' => 'form-control','id' => 'Active', 'placeholder' => '', 'required']) }}
                            <label class="form-label">Active</label></div>
                    </div>
                    <div class="row">
                     </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="col-md-2 btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <a  href="{{route('config.indexjourferie')}}" type="button" class="col-md-2 btn btn-danger">Cancel</a>

                </div>{{ Form::close() }}
            </div>
        </div>

    </div>

</x-app-layout>
